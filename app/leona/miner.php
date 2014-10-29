<?php

class Miner {

	private static $api = "THIS IS A SECRET";
	//The version with out the "v"!
	private static $versions = array(
		'game' => '1.3',
		'match' => '2.2',
		'matchhistory' => '2.2'
		);

	public static function getRecentMatches($user)
	{
		return self::getMatchHistory($user->region,$user->summonerId,array('endIndex'=>15))['matches'];
	}

	private static function getGen($region, $version, $add, $optional, $static = false) {
		$url = "https://".$region.".api.pvp.net/api/lol/";
		if($static) {
			$url .= "static-data/"; 
		}
		$url .= $region."/";
		$url .= "v".$version."/";
		$url .= $add;
		$url .= "?";
		if (is_array($optional)) {
    	//treat optional as array
			$first = true;
			foreach ($optional as $key => $value) {
				if ($first)
					$first = false;
				else
					$url .= "&";
				$url .= $key."=".$value;
			}
			$url .= "&api_key=".self::$api;
		}
		else
			$url .= "api_key=".self::$api;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		if(curl_getinfo($ch,CURLINFO_HTTP_CODE)!=200)
		{
			return curl_getinfo($ch,CURLINFO_HTTP_CODE);
		}
		curl_close($ch);
		return json_decode($output, true);
	}

	public static function getRecent($region, $id, $optional = "") {
		$result = self::getGen($region, self::$versions['game'], "game/by-summoner/".$id."/recent", $optional);
		if (is_numeric($result))
			return -1;
		else
			return $result['games'];
	}

	public static function getMatchHistory($region, $id, $optional = "") {
		$result = self::getGen($region, self::$versions['matchhistory'], "matchhistory/".$id, $optional);
		if (is_numeric($result))
			return -1;
		else
			return $result;
	}

	public static function getMatch($region, $id, $optional = "") {
		$result = self::getGen($region, self::$versions['match'], "match/".$id, $optional);
		if (is_numeric($result))
			return -1;
		else
			return $result;
	}
}