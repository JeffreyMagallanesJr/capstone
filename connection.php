<?php
date_default_timezone_set('Asia/Manila');

$connection = mysqli_connect("localhost", "root","", "dms");

	if (mysqli_connect_errno()) {
   		 echo "Failed to connect to MySQL: " . mysqli_connect_error();
	
	}

?>