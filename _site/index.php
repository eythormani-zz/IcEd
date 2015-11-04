<?php
	$error = null;
	session_start();
	if (isset($_SESSION['username'])) {
		header("Location:http://iced.is/front.php");
	}
	if (isset($_POST['kennitala'])) {

    require 'assets/php/dbCon.php';

    $kennitala = $_POST['kennitala'];
    $password = $_POST['password'];
    $sql = "SELECT salt, password, kennitala,id FROM users WHERE kennitala=:username LIMIT 1";

    try {
    	$logon = $pdo->prepare($sql);

	    $logon->bindParam(':username',$kennitala);

	    $logon->execute();

	    $returnedData = $logon->fetch();
	    // echo "can connect to db";
    } catch (Exception $e) {
    	throw $e;
    }
    $Blowfish_Pre = '$2a$05$';
    $Blowfish_End = '$';
    $salt = $returnedData['salt'];
    $dbUsername = $returnedData['kennitala'];
    $dbPassword = $returnedData['password'];
		$dbid = $returnedData['id'];
    $hashpass = crypt($password, $Blowfish_Pre . $salt . $Blowfish_End);
	    if ($hashpass == $dbPassword && $dbUsername == $kennitala) {
	      $_SESSION['username'] = $dbid;
	      header("Location:front.php");
	    }
	    else{
	      $error = '<script type="text/javascript">alert("Rangt notendanafn eða lykilorð")</script>';
	    }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Icelandic Education</title>
	<link rel="shortcut icon" type="image/png" href="assets/img/logo-black.png">
	<meta name="author" content="Eyþór Máni Steinarsson, Ómar Högni Guðmarsson, Þorgrímur Kári Emilsson">
	<link rel="stylesheet" href="assets/style/main.css">
</head>
<body class="loginContainer">
	<div class="loginLogo">
		<img src="assets/img/logo-black.png" class="login-logo"><h1>Icelandic Education</h1>
	</div>
	<div class="loginForm">

		<div class="formContainer">

			<div class="formHead">
				Innskráning
			</div>

			<form action="index.php" method="post" accept-charset="utf-8">
			<div class ="login-inputs">
				<input class="loginInput" type="text" name="kennitala" placeholder="Kennitala">
				<input class="loginInput" type="password" name="password" placeholder="Lykilorð">
				<button class="loginInput loginButton" type="submit">Innskrá</button>
			</div>
			<a href="recover.php" class="forgotPass">Gleymt Lykilorð?</a>
		</form>
		</div>
	</div>
	<?php
		if ($error == '<script type="text/javascript">alert("Rangt notendanafn eða lykilorð")</script>') {
			echo $error;
		}
	?>
</body>
</html>
