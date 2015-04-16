<?php
	if (isset($readmore) && $readmore->description != NULL) {
		echo $readmore->description;
	} else {
		echo '<h2>No description available </h2>Write a description';
	}