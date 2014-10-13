<?php

    class TrackerController extends \BaseController
    {

        function index()
        {
            return View::make('tracker.tracker', array('users' => User::all()));
        }

        function show($id)
        {
            $username = User::find($id) -> summonerName;
            $all_stats = DB::table("users") -> where("users.summonerId", $id) 
            -> join("participants", "participants.summonerId", "=", "users.summonerId") 
            -> join("matches", "matches.matchId", "=", "participants.matchId") 
            -> join("participants_stats", "participants.id", "=", "participants_stats.participantTableId") 
            -> select("participants_stats.*") -> where("matches.matchMode", "=", "classic") -> orderBy("matches.matchCreation", "desc") -> take(20) -> remember(10);

            $averages = array();
            $averages["Assists"] = round($all_stats -> avg("participants_stats.assists"));
            $averages["Level"] = round($all_stats -> avg("participants_stats.champLevel"));
            $averages["Deaths"] = round($all_stats -> avg("participants_stats.deaths"));
            $averages["Gold earned"] = round($all_stats -> avg("participants_stats.goldEarned"));
            $averages["Kills"] = round($all_stats -> avg("participants_stats.kills"));
            $averages["Largest multikill"] = round($all_stats -> avg("participants_stats.largestMultiKill"));
            $averages['Damage dealt to champions'] = round($all_stats -> avg("participants_stats.totalDamageDealtToChampions"));
            $averages['Damage taken'] = round($all_stats -> avg("participants_stats.totalDamageTaken"));
            $averages['Minnions killed'] = round($all_stats -> avg("participants_stats.minionsKilled"));
            $averages['Wards placed'] = round($all_stats -> avg("participants_stats.wardsPlaced"));

            $latest = array();
            $row = $all_stats -> first();
            $latest["Assists"] = $row -> assists;
            $latest["Level"] = $row -> champLevel;
            $latest["Deaths"] = $row -> deaths;
            $latest["Gold earned"] = $row -> goldEarned;
            $latest["Kills"] = $row -> kills;
            $latest["Largest multikill"] = $row -> largestMultiKill;
            $latest['Damage dealt to champions'] = $row -> totalDamageDealtToChampions;
            $latest['Damage taken'] = $row -> totalDamageTaken;
            $latest['Minnions killed'] = $row -> minionsKilled;
            $latest['Wards placed'] = $row -> wardsPlaced;

            return View::make('tracker.stats', array('avg_stats' => $averages, "user" => $username, "new_stats" => $latest));
        }

        function create()
        {
        }

        function store()
        {
        }

        function edit($id)
        {
        }

        function update($id)
        {
        }

        function destroy($id)
        {
        }

    }
?>