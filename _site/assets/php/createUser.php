<!--THIS IS FUNCTIONAL... EYTHOR DONT MESS IT UPP-->
<?php
require 'kickOut.php';
require_once 'dbCon.php';
if (isset($_POST['uuid'])) {

		// user information
		$uuid 			= $_POST['uuid'];
		$name 			= $_POST['name'];
		$address 		= $_POST['address'];
		$schoolID 	= $_POST['schoolID'];
		$email 			= $_POST['email'];
		$phone 			= $_POST['phone'];
		$password 	= $_POST['passwd'];
		$grades 		= $_POST['grades'];
		$subjects 	= $_POST['subjects'];

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
		$hashed_password = crypt($password, $bcrypt_salt);
		$sql = "INSERT INTO users (salt, password,kennitala,name,address, schoolID, email, phone) VALUES ('$salt', '$hashed_password', '$uuid','$name','$address','$schoolID','$email','$phone' )";
		$pdo -> query($sql);
		// get the user id
		$SQL = "SELECT ID FROM users WHERE kennitala = '" .$uuid."'";
		$resault = $pdo -> prepare($SQL);
		$resault -> execute();
		$row = $resault -> fetch();
		// here we have the id that the user had just created. this works because this is blocking code, meaning that the code above runs before it goes down.
		$userid = $row['ID'];
		// run through each grade and create a connection in userGrades
		for ($i=0; $i < sizeof($grades); $i++) {
			$SQL = "INSERT INTO userGrades(userID,gradeID)VALUES(".$userid.",".$grades[$i].")";
			$nonReadQuery = $pdo -> prepare($SQL);
			$nonReadQuery -> execute();
			}
		// do the same with subjects
		for ($i=0; $i < sizeof($subjects); $i++) {
			$SQL = "INSERT INTO userSubjects(userID,subjectID)VALUES(".$userid.",".$subjects[$i].")";
			$nonReadQuery = $pdo -> prepare($SQL);
			$nonReadQuery -> execute();
			}
		}
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
	<input type="text" name="email" placeholder="Tölvupóstfang">
	<input type="text" name="phone" placeholder="Símanúmer">
	<input type="password" name="passwd" placeholder="Lykilorð">
	<?php
			// get all grades
			$SQL = "SELECT * FROM grades";
			$gradesResault = $pdo -> prepare($SQL);
			$gradesResault -> execute();

			// get all subjects
			$SQL = "SELECT * FROM subjects";
			$subjectResault = $pdo -> prepare($SQL);
			$subjectResault -> execute();
			// echo out the grades that you teach
			echo "<br><h2>Bekkir sem þú kennir</h2>";
			while ($row = $gradesResault -> fetch()) {
				echo "<input type=\"checkbox\" name=\"grades[]\" value=\"".$row['ID']."\"><label>".$row['name'].". Bekkur</label><br>";
				}
			// echo out the subjects that you could teach
			echo "<br><h2>Það sem þú kennir</h2>";
			while ($row = $subjectResault -> fetch()) {
				echo "<input type=\"checkbox\" name=\"subjects[]\" value=\"".$row['ID']."\"><label>".$row['name']."</label><br>";
				}

	 ?>
	<input type="submit" value="Skrá Notenda">
</form>
</body>
</html>
