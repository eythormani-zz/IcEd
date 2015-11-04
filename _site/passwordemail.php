 <?php
 $sucess = true;
 $updated = false;
 session_start();
if (isset($_GET['link'])) {
  $_SESSION['link'] = $_GET['link'];
}

if (isset($_POST['password'])) {
  require 'assets/php/dbCon.php';
  $link =  $_SESSION['link'];

  // find out if the user and the link entry in the database, confirm its validation and checks if it is less then an hour old.
  $SQL = "SELECT users.name, users.ID, recoveryLinks.time FROM recoveryLinks JOIN users on (users.ID = recoveryLinks.userid) WHERE recoveryLinks.link = '".$link."' AND recoveryLinks.time >= TIME(NOW() + INTERVAL 1 hour)";
  $result = $pdo -> prepare($SQL);
  $result -> execute();
  $row = $result -> fetch();
  $id = $row['ID']; 

  // check if the info recived is valid
  if(isset($row['ID'])) {
    if ($_POST['password'] == $_POST['passwordVerify']) {
        $password = $_POST['password'];

        // hash the password
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

        // update password in database -- code been modified
        $SQL = "UPDATE users SET password= '". $hashed_password . "',salt='".$salt."'  WHERE ID = " . $id . ";";
        $nonquery = $pdo -> prepare($SQL);
        $nonquery -> execute();
        $SQL = "DELETE FROM recoveryLinks WHERE userid = '".$id."';";
        $nonquery = $pdo -> prepare($SQL);
        $nonquery ->execute();
        $updated = true;
    }
    else{
      $sucess = false;
    }
  }
  else{
    $sucess = false;
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
        Nýtt lykilorð
      </div>
      <form action="passwordemail.php" method="post" accept-charset="utf-8">
      <div class ="login-inputs">
        <input class="loginInput" type="password" name="password" placeholder="Nýtt Lykilorð">
        <input class="loginInput" type="password" name="passwordVerify" placeholder="Lykilorð Aftur">
        <button class="loginInput loginButton" type="submit">Breyta lykilorði</button>
      </div>
    </form>
    </div>
    <?php 
      if ($sucess == false) {
        echo "<script>alert('Eitthvað fór úrskeiðis, vinsamlegast reyndu aftur. og mundu að lykilorðin þurfa að vera eins!')</script>";
      }
      if ($sucess && $updated) {
          echo "<script>alert('Lykilorði þínu hefur verið breytt')</script>";
          header("Location: assets/php/logout.php");
      }
    ?>
  </div>
  </body>
</html>