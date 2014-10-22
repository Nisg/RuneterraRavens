<?php

    class NewUserController extends \BaseController
    {

        /**
         * Display a listing of users.
         * GET /user
         *
         * @return Response
         */
        public function index()
        {
            return View::make('index', array('users' => User::all(), 'summonercount' => User::count(), 'matchcount' => Match::count()));
        }

        /**
         * Display the specified user.
         * GET /user/{summonerId}
         *
         * @param  int  $summonerId
         * @return Response
         */
        public function show($summonerId)
        {
            $user = User::find($summonerId);
            if (isset($user) == false)
                return View::make("user.error", array("summonerId" => $summonerId));
            return View::make('user.main', array('user' => User::find($summonerId)));
        }

        /**
         * Update the specified user.
         * PATCH /user/{summonerid}
         *
         * @param  int  $summonerId
         * @return Response
         */
        public function update($summonerId)
        {
            /* TODO;
             * return data from database
             */

            $user = User::find($summonerId);
            if ($this -> isUpToDate($user))
            {
                // return data from DB
                return "a";
            } else
            {
                $this -> getDataFromAPI($user);
                $user -> touch();
                $user -> save();
                $this -> update($summonerId);
            }
        }

        // START OF PRIVATE FUNCTIONS!

        private function isUpToDate($user)
        {
            $last = strtotime($user -> updated_at);
            $min30 = mktime(date("H"), date("i") - 30);
            return $last > $min30;
        }

        private function getDataFromAPI($user)
        {
            $matchHistory = $this -> getMatchHistory($user);
            if ($matchHistory === FALSE || array_key_exists("matches", $matchHistory) === FALSE)
                return;
            foreach ($matchHistory["matches"] as $match)
            {
                $dbm = DB::table("matches") -> select("matchId") -> where("matchId", "=", $match["matchId"]) -> get();
                if ($dbm)
                    continue;
                $matchInfo = $this -> getMatchInfo($user -> region, $match["matchId"]);
                if ($matchInfo === FALSE)
                    continue;
                $this -> addToDatabase($matchInfo);
            }
        }

        private function addToDatabase($match)
        {
            $this -> addMatch($match);
            $this -> addTimeline($match);
            $this -> addTeam($match);
            $this -> addParticipant($match);
            foreach ($match['participantIdentities'] as $participantIdentity)
            {
                $this -> addParticipantInfoRanked($match['matchId'], $participantIdentity['participantId'], $participantIdentity['player']['summonerName'], $participantIdentity['player']['summonerId']);
            }
        }

        private function addMatch($match)
        {
            DB::table("matches") -> insert(array("matchId" => $match['matchId'], "matchCreation" => $match['matchCreation'], "matchDuration" => $match['matchDuration'], "mapId" => $match['mapId'], "matchMode" => $match['matchMode'], "matchType" => $match['matchType'], "matchVersion" => $match['matchVersion'], "queueType" => $match['queueType'], "region" => $match['region'], "season" => $match['season'], "frameInterval" => $match['timeline']['frameInterval']));
        }

        private function addTimeline($match)
        {
            $tf = DB::table("timeline_frames") -> select("id") -> where("matchId", "=", $match["matchId"]) -> get();
            if ($tf)
                return;

            foreach ($match['timeline']['frames'] as $frameId => $frame)
            {
                $id = DB::table("timeline_frames") -> insertGetId(array("matchId" => $match['matchId'], "frameId" => $frameId, "timestamp" => $frame["timestamp"]));

                $te = DB::table("timeline_frames_events") -> select("id") -> where("timelineFrameId", "=", $id) -> get();
                if ($te)
                    continue;

                if (array_key_exists('events', $frame))
                {
                    foreach ($frame['events'] as $eventId => $event)
                    {
                        $id2 = DB::table("timeline_frames_events") -> insertGetId(array("timelineFrameId" => $id, "eventId" => $eventId, "buildingType" => isset($event['buildingType']) ? $event['buildingType'] : NULL, "creatorId" => isset($event['creatorId']) ? $event['creatorId'] : NULL, "eventType" => isset($event['eventType']) ? $event['eventType'] : NULL, "itemAfter" => isset($event['itemAfter']) ? $event['itemAfter'] : NULL, "itemBefore" => isset($event['itemBefore']) ? $event['itemBefore'] : NULL, "itemId" => isset($event['itemId']) ? $event['itemId'] : NULL, "killerId" => isset($event['killerId']) ? $event['killerId'] : NULL, "laneType" => isset($event['laneType']) ? $event['laneType'] : NULL, "levelUpType" => isset($event['levelUpType']) ? $event['levelUpType'] : NULL, "monsterType" => isset($event['monsterType']) ? $event['monsterType'] : NULL, "participantId" => isset($event['participantId']) ? $event['participantId'] : NULL, "positionX" => isset($event['positionX']) ? $event['positionX'] : NULL, "positionY" => isset($event['positionY']) ? $event['positionY'] : NULL, "skillSlot" => isset($event['skillSlot']) ? $event['skillSlot'] : NULL, "teamId" => isset($event['teamId']) ? $event['teamId'] : NULL, "timestamp" => isset($event['timestamp']) ? $event['timestamp'] : NULL, "towerType" => isset($event['towerType']) ? $event['towerType'] : NULL, "victimId" => isset($event['victimId']) ? $event['victimId'] : NULL, "wardType" => isset($event['wardType']) ? $event['wardType'] : NULL));
                        if (isset($event['assistingParticipantIds']))
                        {
                            foreach ($event['assistingParticipantIds'] as $assistant)
                            {
                                DB::table("timeline_events_assisting_participants") -> insert(array("eventTableId" => $id2, "participantId" => $assistant));
                            }
                        }
                    }
                }

                $tfpf = DB::table("timeline_frames_participant_frames") -> select("id") -> where("timelineFrameTableId", "=", $id);
                if ($tfpf)
                    continue;

                if (array_key_exists('participantFrames', $frame))
                {
                    foreach ($frame['participantFrames'] as $participantFrameId => $participantFrame)
                    {
                        $id2 = DB::table("timeline_frames_participant_frames") -> insert(array("timelineFrameId" => $id, "participantId" => $participantFrame['participantId'], "positionX" => $participantFrame['position']['x'], "positionY" => $participantFrame['position']['y'], "currentGold" => $participantFrame['currentGold'], "totalGold" => $participantFrame['totalGold'], "level" => $participantFrame['level'], "xp" => $participantFrame['xp'], "minionsKilled" => $participantFrame['minionsKilled'], "jungleMinionsKilled" => $participantFrame['jungleMinionsKilled']));
                    }
                }
            }
        }

        private function addTeam($match)
        {
            $ma = DB::table("teams") -> select("id") -> where("matchId", "=", $match["matchId"]) -> get();
            if ($ma)
                return;

            foreach ($match['teams'] as $teamId => $team)
            {
                $id = DB::table("teams") -> insertGetId(array("matchId" => $match['matchId'], "teamId" => $team['teamId'], "baronKills" => $team['baronKills'], "dragonKills" => $team['dragonKills'], "firstBaron" => $team['firstBaron'], "firstBlood" => $team['firstBlood'], "firstDragon" => $team['firstDragon'], "firstInhibitor" => $team['firstInhibitor'], "firstTower" => $team['firstTower'], "inhibitorKills" => $team['inhibitorKills'], "towerKills" => $team['towerKills'], "vilemawKills" => $team['vilemawKills'], "winner" => $team['winner']));
                if (array_key_exists('bans', $team))
                {
                    $dbban = DB::table("teams_bans") -> select("id") -> where("teamTableId", "=", $id);
                    if ($dbban)
                        continue;
                    foreach ($team["bans"] as $banId => $ban)
                    {
                        DB::table("teams_bans") -> insert(array("teamTableId" => $id, "championId" => $ban['championId'], "pickTurn" => $ban['pickTurn']));
                    }
                }

            }
        }

        private function addParticipant($match)
        {
            $ma = DB::table("participants") -> select("id") -> where("matchId", "=", $match["matchId"]);
            if ($ma)
                return;
            foreach ($match["participants"] as $participantId => $participant)
            {
                $pid = DB::table("participants") -> insertGetId(array("matchId" => $match['matchId'], "participantId" => $participant['participantId'], "summonerId" => $participant['summonerId'], "summonerName" => $participant['summonerName'], "championId" => $participant['championId'], "spell1Id" => $participant['spell1Id'], "spell2Id" => $participant['spell2Id'], "teamId" => $participant['teamId'], "role" => $participant['timeline']['role'], "lane" => $participant['timeline']['lane']));
                if (array_key_exists('runes', $participant))
                {
                    foreach ($participant['runes'] as $rune)
                    {
                        DB::table("participants_runes") -> insert(array("participantTableId" => $pid, "runeId" => $rune['runeId'], "rank" => $rune['rank']));
                    }
                }
                if (array_key_exists('masteries', $participant))
                {
                    foreach ($participant['masteries'] as $mastery)
                    {
                        DB::table("participants_masteries") -> insert(array("participantTableId" => $pid, "masteryId" => $mastery['masteryId'], "rank" => $mastery['rank']));
                    }
                }
                if (array_key_exists('stats', $participant))
                {
                    DB::table("participants_stats") -> insert(array("participantTableId" => $pid, "assists" => $participant['stats']['assists'], "champLevel" => $participant['stats']['champLevel'], "deaths" => $participant['stats']['deaths'], "doubleKills" => $participant['stats']['doubleKills'], "firstBloodAssist" => $participant['stats']['firstBloodAssist'], "firstBloodKill" => $participant['stats']['firstBloodKill'], "firstInhibitorAssist" => $participant['stats']['firstInhibitorAssist'], "firstInhibitorKill" => $participant['stats']['firstInhibitorKill'], "firstTowerAssist" => $participant['stats']['firstTowerAssist'], "firstTowerKill" => $participant['stats']['firstTowerKill'], "goldEarned" => $participant['stats']['goldEarned'], "goldSpent" => $participant['stats']['goldSpent'], "inhibitorKills" => $participant['stats']['inhibitorKills'], "item0" => $participant['stats']['item0'], "item1" => $participant['stats']['item1'], "item2" => $participant['stats']['item2'], "item3" => $participant['stats']['item3'], "item4" => $participant['stats']['item4'], "item5" => $participant['stats']['item5'], "item6" => $participant['stats']['item6'], "killingSprees" => $participant['stats']['killingSprees'], "kills" => $participant['stats']['kills'], "largestCriticalStrike" => $participant['stats']['largestCriticalStrike'], "largestKillingSpree" => $participant['stats']['largestKillingSpree'], "largestMultiKill" => $participant['stats']['largestMultiKill'], "magicDamageDealt" => $participant['stats']['magicDamageDealt'], "magicDamageDealtToChampions" => $participant['stats']['magicDamageDealtToChampions'], "magicDamageTaken" => $participant['stats']['magicDamageTaken'], "minionsKilled" => $participant['stats']['minionsKilled'], "neutralMinionsKilled" => $participant['stats']['neutralMinionsKilled'], "neutralMinionsKilledEnemyJungle" => $participant['stats']['neutralMinionsKilledEnemyJungle'], "neutralMinionsKilledTeamJungle" => $participant['stats']['neutralMinionsKilledTeamJungle'], "nodeCapture" => isset($participant['stats']['nodeCapture']) ? $participant['stats']['nodeCapture'] : NULL, "nodeCaptureAssist" => isset($participant['stats']['nodeCaptureAssist']) ? $participant['stats']['nodeCaptureAssist'] : NULL, "nodeNeutralize" => isset($participant['stats']['nodeNeutralize']) ? $participant['stats']['nodeNeutralize'] : NULL, "nodeNeutralizeAssist" => isset($participant['stats']['nodeNeutralizeAssist']) ? $participant['stats']['nodeNeutralizeAssist'] : NULL, "objectivePlayerScore" => isset($participant['stats']['objectivePlayerScore']) ? $participant['stats']['objectivePlayerScore'] : NULL, "pentaKills" => $participant['stats']['pentaKills'], "physicalDamageDealt" => $participant['stats']['physicalDamageDealt'], "physicalDamageDealtToChampions" => $participant['stats']['physicalDamageDealtToChampions'], "physicalDamageTaken" => $participant['stats']['physicalDamageTaken'], "quadraKills" => $participant['stats']['quadraKills'], "sightWardsBoughtInGame" => $participant['stats']['sightWardsBoughtInGame'], "teamObjective" => $participant['stats']['teamObjective'], "totalDamageDealt" => $participant['stats']['totalDamageDealt'], "totalDamageDealtToChampions" => $participant['stats']['totalDamageDealtToChampions'], "totalDamageTaken" => $participant['stats']['totalDamageTaken'], "totalHeal" => $participant['stats']['totalHeal'], "totalTimeCrowdControlDealt" => $participant['stats']['totalTimeCrowdControlDealt'], "totalUnitsHealed" => $participant['stats']['totalUnitsHealed'], "towerKills" => $participant['stats']['towerKills'], "tripleKills" => $participant['stats']['tripleKills'], "trueDamageDealt" => $participant['stats']['trueDamageDealt'], "trueDamageDealtToChampions" => $participant['stats']['trueDamageDealtToChampions'], "trueDamageTaken" => $participant['stats']['trueDamageTaken'], "unrealKills" => $participant['stats']['unrealKills'], "visionWardsBoughtInGame" => $participant['stats']['visionWardsBoughtInGame'], "wardsKilled" => $participant['stats']['wardsKilled'], "wardsPlaced" => $participant['stats']['wardsPlaced'], "winner" => $participant['stats']['winner']));
                }
                if (array_key_exists('timeline', $participant))
                {
                    foreach ($participant['timeline'] as $timelineKey => $timeline)
                    {
                        if ($timelineKey != "lane" && $timelineKey != "role")
                        {
                            foreach ($timeline as $timelineDataKey => $timelineData)
                            {
                                DB::table("participants_timelines") -> insert(array("participantTableId" => $pid, "timelineDataType" => $timelineKey, "timelineDataInterval" => $timelineDataKey, "timelineData" => $timelineData));
                            }
                        }
                    }
                }
            }

        }

        private function addParticipantInfoRanked($matchId, $participantId, $summonerName, $summonerId)
        {
            DB::table("participants") -> where("matchId", "=", $matchId) -> where("participantId", "=", $participantId) -> update(array("summonerId" => $summonerId, "summonerName" => $summonerName));
        }

        private function getMatchHistory($user)
        {
            return $this -> download($user -> region . ".api.pvp.net/api/lol/" . $user -> region . "/v2.2/matchhistory/" . $user -> summonerId);
        }

        private function getMatchInfo($region, $id)
        {
            return $this -> download($region . ".api.pvp.net/api/lol/" . $region . "/v2.2/match/" . $id . "?includeTimeline=true");
        }

        private function download($url)
        {
            $API_KEY = "f4fc824e-b1ec-4906-8c9d-c4374a014562";
            $url .= ((strpos($url, '?')) ? "&" : "?") . "api_key=" . $API_KEY;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            if (curl_error($ch))
            {
                die(curl_error($ch));
            }
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($http_status != 200)
            {
                if ($http_status == 429)
                {
                    sleep(10);
                    return getData($url);
                }
                http_response_code($http_status);
                return false;
            }
            return json_decode($result, true);
        }

    }
