<?php
// checks if session is in place and places the user in an apropriate pos acording to that
require 'kickOut.php';
require 'dbCon.php';
require 'getID.php';
// get the user id for the upload and store it in a varible;
$id = kennitala($_SESSION['username']);
if (isset($_POST['name'])) {
  // this runs if the upload has been mede

  $target_dir = "./../../uploads/";
  $target_file = $target_dir .time(). basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

  // Allow certain file formats
  if($imageFileType != "pdf" && $imageFileType != "txt") {
      echo "Sorry, only PDF and txt files are allowed.";
      $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          echo '<script>swal("File Uploaded", "."The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.".", "success")</script>';
      } else {
          echo "Sorry, there was an error uploading your file.";
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
    header("Location: http://iced.is/front.php");
  }
}
?>
