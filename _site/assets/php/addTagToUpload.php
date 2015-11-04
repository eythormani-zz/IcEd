<?php
	require 'kickOut.php';
	require 'dbCon.php';
	print_r($_POST);
	$id = $_SESSION['username'];
	$lastID = $_POST['id'];
	$selectedTags = $_POST['tags'];
	//codeblock that gets the currently available tags, checks if the tag exist, if it doesn't, adds it to the taglist
    {
          $SQL = "SELECT name FROM tags";
          $logon = $pdo->prepare($SQL);
          $logon->execute();
          $allTags = $logon->fetchAll();
          //Correct the array returned by fetchAll
          foreach ($allTags as $temp) {
              $realAllTags[] = $temp['name'];
          }
          //does the actual searching and inserting
          foreach ($selectedTags as $temp) {
              //checking.... checking
              if (!in_array($temp, $realAllTags)) {
                $SQL = "INSERT INTO tags (name, userID) VALUES ('$temp', $id)";
                $logon = $pdo->prepare($SQL);
                $logon->execute();
              }
          }
    }
    $selectedTagsID = array();
    //Selects the IDs for the tags the user wants
    foreach ($selectedTags as $temp) {
    	$SQL = "SELECT ID from tags WHERE name = '" . $temp . "'";
	    $logon = $pdo->prepare($SQL);
	    $logon->execute();
	    $var = $logon->fetch();
	    $selectedTagsID[] = $var;
    }
    //links the upload to the appropriate tags
    foreach ($selectedTagsID as $temp) {
      $SQL = "INSERT INTO uploadTags (tagID, uploadID) VALUES (" . $temp['ID'] . ", " . $lastID . ")";
      $logon = $pdo->prepare($SQL);
      $logon->execute();
    }
?>
