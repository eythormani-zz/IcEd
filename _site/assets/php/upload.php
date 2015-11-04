<?php // THIS IS KINDA SOMEWHAT FUNCTIONAL, DO NOT TOUCH EYTHOR ... DONT DO IT, REALLY. JUST DONT.
// checks if session is in place and places the user in an apropriate pos acording to that
require 'kickOut.php';
require 'dbCon.php';
$returnArrayToAjax = array();
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
    $returnArrayToAjax['incorrectFormat'] = "Það má ekki setja inn skrár af þessari gerð";
  }



  // Check if $uploadOk is set to 0 by an error. if it is ok ... upload
  if ($uploadOk == 0) {
    $returnArrayToAjax['noError'] = "Við náðum ekki að setja inn skránna og við vitum ekki afhverju, afsakið þetta";
  // if everything is ok, try to upload file
  }
  else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],"../../uploads/". $target_file)) {
        $returnArrayToAjax['allIsWell'] = "Verkefni móttekið";
      } else {
        $returnArrayToAjax['unableToMove'] = "Verkefni móttekið";
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
    //variables used for categorizing
    $subject = $_POST['subject'];
    $grades = $_POST['grades'];

    //inserts the actual project
    $sql = "INSERT INTO uploads(name,location,description,size,format,userID, subjectID) VALUES ('$name','$location','$description','$size','$format','$userID', '$subject')";
    $pdo -> query($sql);
    //gets the ID of the insertet upload
    $lastID = $pdo->lastInsertId();
    $returnArrayToAjax['uploadID'] = $lastID;
    //links the upload to the appropriate grades
    foreach ($grades as $temp) {
      $SQL = "INSERT INTO uploadGrades (gradeID, uploadID) VALUES (" . $temp . ", " . $lastID . ")";
      $logon = $pdo->prepare($SQL);
      $logon->execute();
    } 
    print $returnArrayToAjax['uploadID'];
  }
}
//header("Location: http://iced.is/front.php");
?>
