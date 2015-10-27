<?php 
require 'kickOut.php';
function kennitala($value)
{
	require 'dbCon.php';
	$sql = "SELECT ID FROM users where kennitala = " . $value . " LIMIT 1";
	$result = $pdo -> query($sql);
	$row = $result -> fetch();
	$id = $row['ID'];
	return $id;
}

 ?>