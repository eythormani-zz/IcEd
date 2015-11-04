<?php 
$sessionisset = true;
session_start();
	if (isset($_SESSION['username'])) {
		require 'dbCon.php';
		// update the email status
		$SQL = "UPDATE users SET active = 1 WHERE ID = '".$_SESSION['username']."';";
		$nonquery = $pdo -> prepare($SQL);
		$nonquery -> execute();
		header("Location:../../index.php");
	}
	else {
		$sessionisset = false;
	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset ="utf-8">
</head>
<body>
<?php 
	if ($sessionisset == false) {
		echo "<script>alert(\"Þú ert ekki skráður inn\")</script>";
	}
?>
</body>
</html>