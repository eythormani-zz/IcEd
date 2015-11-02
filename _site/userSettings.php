<?php
	require 'assets/php/kickOut.php';
	require 'assets/php/dbCon.php';
	$id = $_SESSION['username'];
	$SQL = "SELECT name, address, email, phone FROM users WHERE id = $id";
	$logon = $pdo->prepare($SQL);
	$logon->execute();
	$returnedData = $logon->fetch();


	 // if the change info button if pressed
	 if (isset($_POST['EXEC'])) {
	 		require 'assets/php/phpfunctions.php';
			ChangeUserData($_POST);
	 }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="./assets/style/main.css" media="screen" title="no title" charset="utf-8">
	<title>Stillingar fyrir notendur</title>
</head>
<body id="bodyUserSettings">
	<nav id="navigation"></nav>
	<div id="main">
		<h1>Hérna eru þínar upplýsingar</h1>
		<form action="userSettings.php" method="POST" id="userinfo">
			<input class="form-control" type="text" name="name" value="<?php echo $returnedData['name'] ?>">
			<input class="form-control" type="text" name="address" value="<?php echo $returnedData['address'] ?>">
			<input class="form-control" type="text" name="email" value="<?php echo $returnedData['email'] ?>">
			<input class="form-control" type="text" name="phone" value="<?php echo $returnedData['phone'] ?>">
			<input type="submit" name="EXEC" value="Breyta upplýsingum">
		</form>
		<h1>Breyttu þeim fögum sem þú kennir</h1>
		<form class="" action="index.html" method="post">

		</form>
	</div>
	<!-- Latest compiled and minified JavaScript -->
	<script src="./assets/js/main.js" type="text/javascript" charset="utf-8" async defer></script>
	<script type="text/javascript">

	</script>
</body>

</html>
