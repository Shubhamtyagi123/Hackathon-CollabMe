<?php
	
	$requests_t = "requests";
	$projects_t = "projects";
	$login = "login";
	$team_members = "team_members";
	$register = "register";
	$accepted = '1';
	$pending = '0';

	function get_all_accepted_requests($user_id, $link) {
		
		global $requests_t, $accepted;
		$s = "SELECT * FROM $requests_t WHERE user_id = '$user_id' AND status = '$accepted'";
		$x = mysqli_query($link,  $s);

		if ($x && (mysqli_num_rows($x) > 0)) 
			return $x;
		else{
			echo mysqli_error($link);
			return null;	
		}
	}

	function get_all_pending_requests($user_id, $link) {
		
		global $requests_t, $pending;
		$s = "SELECT * FROM $requests_t WHERE user_id = '$user_id' AND status = '$pending'";
		$x = mysqli_query($link,  $s);

		if ($x && (mysqli_num_rows($x) > 0)) 
			return $x;
		else{
			echo mysqli_error($link);
			return null;	
		}
	}

	function get_project_name($project_id, $link) {
		
		global $projects_t;
		$s = "SELECT project_title AS project_name FROM $projects_t WHERE project_id = '$project_id'";
		$x = mysqli_query($link, $s);

		if ($x && (mysqli_num_rows($x) == 1 )){
			$name = mysqli_fetch_object($x);
			return $name->project_name;
		}
		else{
			echo mysqli_error($link);
			return null;
		}
	}

	function get_user_information($username, $link) {
		
		global $register;
		$s = "SELECT * FROM $register WHERE username = '$username'";
		$x = mysqli_query($link, $s);
		
		if ($x && (mysqli_num_rows($x) == 1))
			return $x;
		else{
			echo mysqli_error($link);
			return null;
		} 
	}

	function get_all_projects($username, $link) {
		global $projects_t;

		$s = "SELECT * FROM $projects_t WHERE admin_name = '$username'";
		$x = mysqli_query($link, $s);

		if ($x && (mysqli_num_rows($x) > 0))
			return $x;
		else {
			echo mysqli_error($link);
			return null;
		}
	}

	function get_project($project_id, $link) {

		global $projects_t;
		$s = "SELECT * FROM $projects_t WHERE project_id = '$project_id'";
		$x = mysqli_query($link, $s);

		if ($x && (mysqli_num_rows($x) > 0))
			return $x;
		else {
			echo mysqli_error($link);
			return null;
		}
	}

	function get_all_pending_project_requests($project_id, $link) {

		global $requests_t, $pending;

		$s = "SELECT * FROM $requests_t WHERE project_id = '$project_id' AND status = '$pending'";
		$x = mysqli_query($link, $s);

		if ($x && (mysqli_num_rows($x) > 0))
			return $x;
		else {
			echo mysqli_error($link);
			return null;
		}	
	}
	function get_all_approved_project_requests($project_id, $link) {

		global $requests_t, $accepted;

		$s = "SELECT * FROM $requests_t WHERE project_id = '$project_id' AND status = '$accepted'";
		$x = mysqli_query($link, $s);

		if ($x && (mysqli_num_rows($x) > 0))
			return $x;
		else {
			echo mysqli_error($link);
			return null;
		}	
	}

	function validate($data) {
		  
		 $data = trim($data);
		 $data = stripslashes($data);
		 $data = htmlspecialchars($data);
		 
		 return $data;
	}

	function SQLProof($connect_link,$data){
		
		return mysqli_real_escape_string($connect_link,$data);
	}	


?>