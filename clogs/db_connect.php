<?php

$server = "localhost";
$username = "root";
$pass = "";
$db_name = "collab";

$connect_link = mysqli_connect($server, $username, $pass, $db_name);

	if(mysqli_connect_errno()){
		die('Could not connect to database!'.mysqli_error($connect_link)); 
	}
	


?>
