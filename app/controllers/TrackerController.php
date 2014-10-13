<?php

class TrackerController extends \BaseController {

    function index() {
        return View::make('tracker.index', array('users' => User::all()));
    }

    function show($id) {
        $user = User::find($id);
        $username = $user->summonerName;

        $last20 = $user->getAverageStat(array("assists", "champLevel", "deaths", "goldEarned", "kills", "largestMultiKill", "totalDamageDealtToChampions", "totalDamageTaken", "minionsKilled", "wardsPlaced"), 20);
        $last1 = $user->getAverageStat(array("assists", "champLevel", "deaths", "goldEarned", "kills", "largestMultiKill", "totalDamageDealtToChampions", "totalDamageTaken", "minionsKilled", "wardsPlaced"), 1);

        $averages = array();
        $averages["Assists"] = $last20["assists"];
        $averages["Level"] = $last20["champLevel"];
        $averages["Deaths"] = $last20["deaths"];
        $averages["Gold earned"] = $last20["goldEarned"];
        $averages["Kills"] = $last20["kills"];
        $averages["Largest multikill"] = $last20["largestMultiKill"];
        $averages['Damage dealt to champions'] = $last20["totalDamageDealtToChampions"];
        $averages['Damage taken'] = $last20["totalDamageTaken"];
        $averages['Minnions killed'] = $last20["minionsKilled"];
        $averages['Wards placed'] = $last20["wardsPlaced"];

        $latest = array();
        $latest["Assists"] = $last1["assists"];
        $latest["Level"] = $last1["champLevel"];
        $latest["Deaths"] = $last1["deaths"];
        $latest["Gold earned"] = $last1["goldEarned"];
        $latest["Kills"] = $last1["kills"];
        $latest["Largest multikill"] = $last1["largestMultiKill"];
        $latest['Damage dealt to champions'] = $last1["totalDamageDealtToChampions"];
        $latest['Damage taken'] = $last1["totalDamageTaken"];
        $latest['Minnions killed'] = $last1["minionsKilled"];
        $latest['Wards placed'] = $last1["wardsPlaced"];

        return View::make('tracker.stats', array('avg_stats' => $averages, "user" => $username, "new_stats" => $latest));
    }

    function create() {
        
    }

    function store() {
        
    }

    function edit($id) {
        
    }

    function update($id) {
        
    }

    function destroy($id) {
        
    }

}
