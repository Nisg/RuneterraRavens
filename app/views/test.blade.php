<pre>
<?php

$participant = $match->participants[0];

$count = 0;
var_dump($participant->stats->assists);
foreach ($participant->events as $event)
{
	if (($event->eventType=="CHAMPION_KILL") && ($event->killerId!=$participant->participantId) && ($event->victimId!=$participant->participantId))
	{
		$count++;
		var_dump($event->assistants);
	}
}
var_dump($count);
//var_dump(TimelineEvent::find(16497)->frame->match);
?>
</pre>