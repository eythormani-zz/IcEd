<?php 
	require 'assets/php/dbCon.php';
	require 'assets/php/getID.php';
	$id = kennitala($_SESSION['username']);	
	$SQL = "SELECT name, address, email, phone FROM users WHERE ID = $id";
	$logon = $pdo->prepare($SQL);
	$logon->execute();
	$returnedData = $logon->fetch();
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
	<title>Stillingar fyrir notenda</title>
</head>
<body>
	<nav id="navigation"></nav>
	<div id="main">
		<form action="userSettings.php" method="POST">
			<input class="form-control" type="text" name="name" value="<?php  ?>">
			<input class="form-control" type="text" name="address" value="<?php  ?>">
			<input class="form-control" type="text" name="email" value="<?php  ?>">
			<input class="form-control" type="text" name="phone" value="<?php  ?>">
		</form>
		<div id="searchContainer">
			
		</div>
	</div>
	<!-- Latest compiled and minified JavaScript -->
	<script src="./assets/js/main.js" type="text/javascript" charset="utf-8" async defer></script>
	<script type="text/javascript">
		
	</script>		
</body>

</html>

lala.lala