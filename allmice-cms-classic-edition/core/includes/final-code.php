<?php

if(isset($startTime)){
	$endTime = round(microtime(true) * 1000);

	$runningTime = "Running time was: ".($endTime-$startTime)." milliseconds";

	echo $runningTime;
	echo "<br>";
}
