<?php
	require 'kickOut.php';
	require 'dbCon.php';
	$ID = $_SESSION['username'];
	$name = $_POST['name'];
	$address = $_POST['address'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$grades = $_POST['grades'];
	$subjects = $_POST['subjects'];

	//deletes all current subjects from the user
	$SQL = "DELETE FROM userSubjects WHERE userID = $ID";
	$logon = $pdo->prepare($SQL);
	$logon->execute();
	//adds the selected grades to the users profile
	foreach ($subjects as $temp) {
		$SQL = "INSERT INTO userSubjects (subjectID, userID) VALUES (" . $temp . ", " . $ID . ")";
		$logon = $pdo->prepare($SQL);
		$logon->execute();
	}
	//deletes all current grades from the user
	$SQL = "DELETE FROM userGrades WHERE userID = $ID";
	$logon = $pdo->prepare($SQL);
	$logon->execute();
	//adds the selected grades to the users profile
	foreach ($grades as $temp) {
		$SQL = "INSERT INTO userGrades (gradeID, userID) VALUES (" . $temp . ", " . $ID . ")";
		$logon = $pdo->prepare($SQL);
		$logon->execute();
	}
	//finishes up with updating the user's relevant info
	$SQL = "UPDATE users SET name ='" . $name . "', address='" . $address . "', email='" . $email . "', phone='" . $phone . "' WHERE ID=" . $ID . "";
	$logon = $pdo->prepare($SQL);
	$logon->execute();
?>