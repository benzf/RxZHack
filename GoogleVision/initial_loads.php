<?php
	$servername = "localhost";
	$username = "root";
	$password = "rx123";
	$dbname = "newprescription";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT `image_keywords` FROM `keywords`";

	$result = mysqli_query($conn, $sql);
	//print_r($result);
?>
