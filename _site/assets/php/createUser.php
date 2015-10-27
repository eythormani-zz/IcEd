<?php
require 'kickOut.php';
	if (isset($_SESSION['username'])) {
		
	}
	if (isset($_POST['uuid'])) {
		require_once 'dbCon.php';
		// uuid for the user, (kennitala)
		$uuid = $_POST['uuid'];
		// full name
		$name = $_POST['name'];
		// address of the user
		$address = $_POST['address'];
		// school id refrences the id of the school the user works at
		$schoolID = $_POST['schoolID'];
		$positionID = $_POST['positionID'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$password = $_POST['passwd'];

		// for the best security we hash and salt all passwords
		CRYPT_BLOWFISH or die ('No Blowfish found.');
		$Blowfish_Pre = '$2a$05$';
		$Blowfish_End = '$';

		$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
		$Chars_Len = 63;
		// 18 would be secure as well.
		$Salt_Length = 21;

		$salt = "";

		for($i=0; $i<$Salt_Length; $i++)
		{
		    $salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
		}
		$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;

		$hashed_password = crypt($password, $bcrypt_salt);

		$sql = "INSERT INTO users (salt, password,kennitala,name,address, schoolID, positionID, email, phone) VALUES ('$salt', '$hashed_password', '$uuid','$name','$address','$schoolID','$positionID','$email','$phone' )";
		$pdo -> query($sql);
	}
	// forge an sql query
	// return data to the ajax w
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Create User</title>
	<meta charset="utf-8">
</head>
<body>
<form action="createUser.php" method="post" accept-charset="utf-8">
	<input type="text" name="uuid" placeholder="Kennitala">
	<input type="text" name="name" placeholder="Fullt Nafn">
	<input type="text" name="address" placeholder="Heimilisfang">
	<input type="text" name="schoolID" placeholder="schoolID">
	<input type="text" name="positionID" placeholder="positionID">
	<input type="text" name="email" placeholder="Tölvupóstfang">
	<input type="text" name="phone" placeholder="Símanúmer">
	<input type="password" name="passwd" placeholder="Lykilorð">
	<input type="submit" value="register user">
</form>
</body>
</html>