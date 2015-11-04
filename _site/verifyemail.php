<?php
$sent = false;
    if (isset($_POST['send'])) {
      require 'assets/php/dbCon.php';
      session_start();
      $uuid = $_SESSION['username'];
      // get the user id 
      $SQL = "SELECT ID,email,name,active FROM users WHERE ID = '".$uuid."';";
      $result = $pdo -> prepare($SQL);
      $result -> execute();
      $row = $result -> fetch();
      $id = $row['ID'];
      $email = $row['email'];
      $name = $row['name'];

      // send password email to user
      $msg = "Sæl(l) ".$name.", Vinsamlegast farðu inná http://iced.is/assets/php/verify.php  til að staðfesta tölvupóstfang þitt";
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
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Staðfesta Tölvupóst</title>
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
        Vinsamlegast staðfestu tölvupóstfangið þitt
      </div>
      <form action="verifyemail.php" method="post" accept-charset="utf-8">
      <div class ="login-inputs">
        <button class="loginInput loginButton" name="send" type="submit">Senda</button>
      </div>
    </form>
    </div>
    <?php 
      if ($sent) {
        echo "<script>alert(\"Mundu að kíkja í spam\")</script>";
      }
     ?>
  </div>
  </body>
</html>