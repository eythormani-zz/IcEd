<?php 
//The purpose of this script is to redirect users that have not logged in to the index.php site.
//this file will be required at the top of all sites of the website
session_start();
if (!isset($_SESSION['username'])) {
	header("Location:../../index.html");
}
 ?>