<?php
  $done = false;
  $sent = false;
    if (isset($_POST['kennitala'])) {
      require 'assets/php/dbCon.php';
      $uuid = $_POST['kennitala'];
      // get the user id 
      $SQL = "SELECT ID,email,name,active FROM users WHERE kennitala = '".$uuid."';";
      $result = $pdo -> prepare($SQL);
      $result -> execute();
      $row = $result -> fetch();
      $id = $row['ID'];
      $email = $row['email'];
      $name = $row['name'];
    if ($row['active'] == 1) {
      // generate random string
      $length = 255;
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      // insert the random string into the database
      $SQL = "INSERT INTO recoveryLinks(userid,link)VALUES('".$id."','".$randomString."')";
      $nonquery = $pdo -> prepare($SQL);
      $nonquery -> execute(); 
      //  generate recovery link for the user

      // send password email to user
      $msg = "Sæl(l) ".$name.", Hérna er slóð til að breyta lykilorðinu. ATHUGA slóðin deyr klukkutíma eftir sendingu þessa pósts\nSlóð: http://iced.is/passwordemail.php?link=" . $randomString;
      $headers = "From: iced@iced.is\r\n";
      $headers .= "Reply-To: iced@iced.is\r\n"; 
      $headers .= "Organization: Icelandic Education\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-type: text/plain; charset=utf-8\r\n";
      $headers .= "X-Priority: 3\r\n";
      $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
      mail($email,"Lykilorða breyting", $msg, $headers);
      //echo "NEW PASSWORD : " . $password . "<br>";
      $sent = true;
      $done = true;
      }
      else{
        $done = true;
      }
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Núllstilling Lykilorðs</title>
    <link rel="stylesheet" type="text/css" href="assets/style/main.css">
  </head>
  <body id="recover-body loginContainer">
     <a href="index.php">
       <div class="loginLogo">
          <img src="assets/img/logo-black.png" class="login-logo"><h1>Icelandic Education</h1>
      </div>
     </a>
  <div class="loginForm">
    <div class="formContainer">
      <div class="formHead">
        Endursetning lykilorðs
      </div>
      <form action="recover.php" method="post" accept-charset="utf-8">
      <div class ="login-inputs">
        <input class="loginInput" type="text" name="kennitala" placeholder="Kennitala">
        <button class="loginInput loginButton" type="submit">Fá upplýsingar í Tölvupósti</button>
      </div>
    </form>
    </div>
  </div>
  <?php
  if ($sent && $done == true) {
    echo "<script>alert(\"Tölvupóstur hefur verið sendur. Ekki gleyma að gá í spam.\")</script>";
  }
  elseif($done){
    echo "<script>alert(\"Tölvupóstur var ekki sendur. ATHUGA tölvupóstfang þarf að vera virkjað.\")</script>";
  }
  ?>
  </body>
</html>



 