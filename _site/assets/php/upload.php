<?php // THIS IS KINDA SOMEWHAT FUNCTIONAL, DO NOT TOUCH EYTHOR ... DONT DO IT, REALLY. JUST DONT.
// checks if session is in place and places the user in an apropriate pos acording to that
require 'kickOut.php';
require 'dbCon.php';
require 'getID.php';
// get the user id for the upload and store it in a varible;
$id = $_SESSION['username'];
if (isset($_POST['name'])) {
  // this runs if the upload has been mede

  $AllowedFormats = ["pdf","docs","txt"];
  $target_file = time(). basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  // Allow certain file formats
 $uploadOk = 0;
  for ($i=0; $i < sizeof($AllowedFormats); $i++) {
    if ($imageFileType == $AllowedFormats[$i]) {
      $uploadOk = 1;
      break;
    }
  }
  if ($uploadOk == 0) {
    echo "Sorry only ";
    foreach ($AllowedFormats as $key) {
     echo $key . ",  ";
    }
    echo " allowed <br>";
  }
  // if($imageFileType != "pdf" && $imageFileType != "txt") {
  //     echo "Sorry, only PDF and txt files are allowed.";
  //     $uploadOk = 0;
  // }



  // Check if $uploadOk is set to 0 by an error. if it is ok ... upload
  if ($uploadOk == 0) {
      echo "your file was not uploaded.";
  // if everything is ok, try to upload file
  }
  else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],"../../uploads/". $target_file)) {
          echo '<script>alert("File Uploaded", "."The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.".", "success")</script>';
      } else {
          echo "Sorry, there was an error uploading your file.";
          $uploadOk = 0;
      }
  }
  // enter details about the file into mysql if the upload succeded.
  if ($uploadOk == 1) {

    $name = $_POST['name'];
    $location = $target_file;
    $description = $_POST['description'];
    // $length  later
    $size = $_FILES["fileToUpload"]["size"];
    $format = $imageFileType;
    $userID = $id;

    $sql = "INSERT INTO uploads(name,location,description,size,format,userID)VALUES
    ('$name','$location','$description','$size','$format','$userID')";
    $pdo -> query($sql);

  }
}
header("Location: http://iced.is/front.php");
?>
