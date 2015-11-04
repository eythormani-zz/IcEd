<?php 
	// 
	require 'assets/php/dbCon.php';
	require 'assets/php/kickOut.php';
	// get the id and all the info from the mysql server
	$uploadid = $_GET['id'];
	$SQL = "SELECT * FROM uploads WHERE ID = " . $uploadid . " JOIN uploadSubjects on (uploadSubjects.uploadID = uploads.ID) JOIN subjects on (subjects.ID = uploadSubjects.subjectID)"; 
	$query = $pdo -> prepare($SQL);
	$resault = $query -> execute();
	$row = $resault -> fetch();
?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

</body>
</html>