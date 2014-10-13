<?php

foreach ($users as $user) {
    echo "<li>" . HTML::linkRoute('tracker.show', $user->summonerName, $user->summonerId) . "</li>";
}