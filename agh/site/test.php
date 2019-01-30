<?php

	$date = new DateTime();
	$timestamp = $date->getTimestamp();
	if($timestamp - 1548298452 < 30){ //if younger than 30s
		echo "alert!";
	}

?>