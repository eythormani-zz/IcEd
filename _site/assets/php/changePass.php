<?php 
	require 'kickOut.php';
	require 'dbCon.php';
	$id = $_SESSION['username'];
	$approved = false;
	foreach ($_POST as $temp) {
		if (empty($temp)) {
			echo "Engin tóm lykilorð leyfð";
			break;
		}
	}
	$oldPass = $_POST['oldPass'];
	$newPass0 = $_POST['newPass0'];
	$newPass1 = $_POST['newPass1'];
	if ($newPass1 != $newPass0) {
		echo "Lykilorðin passa ekki saman";
	}
	//selects the current password and salt for the user
	$sql = "SELECT salt, password FROM users WHERE ID = $id LIMIT 1";
	try {
    	$logon = $pdo->prepare($sql);

	    $logon->execute();

	    $returnedData = $logon->fetch();
    } catch (Exception $e) {
    	throw $e;
    }
    $Blowfish_Pre = '$2a$05$';
    $Blowfish_End = '$';
    $salt = $returnedData['salt'];
    $dbPassword = $returnedData['password'];

    $hashpass = crypt($oldPass, $Blowfish_Pre . $salt . $Blowfish_End);
    if ($hashpass == $dbPassword) {
    	$approved = true;
    }
    else{
    	$approved = false;
    	echo "nofit";
    }
    //at this point, if the password was approved and all is well, the rest of the code runs
    if ($approved == true) {
    	// for the best security we hash and salt all passwords
		CRYPT_BLOWFISH or die ('No Blowfish found.');
		$Blowfish_Pre = '$2a$05$';
		$Blowfish_End = '$';

		$Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
		$Chars_Len = 63;
		// 18 would be secure as well.
		$Salt_Length = 21;

		$salt = "";

		for($i=0; $i<$Salt_Length; $i++){
		    $salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
		}
		$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
		$hashed_password = crypt($newPass0, $bcrypt_salt);

		$sql = "UPDATE users SET password ='$hashed_password', salt='$salt'";
		//echo "$sql";
		$pdo -> query($sql);
		echo "success";
    }
?>