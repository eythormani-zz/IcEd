<?php
//The purpose of this script is to redirect users that have not logged in to the index.php site.
//this file will be required at the top of all sites of the website
if(session_id() == ""){
	session_start();
	// if the user has logged in
	require 'dbCon.php';
	$SQL = "SELECT active FROM users WHERE ID = '".$_SESSION['username']."' LIMIT 1;";
	$result = $pdo -> prepare($SQL);
	$result -> execute();
	$row = $result -> fetch();
	if ($row['active'] == "0") {
		header("Location:../../verifyemail.php");
	}
	
}
if (!isset($_SESSION['username'])) {
	header("Location:../../index.php");
	
}
?>
