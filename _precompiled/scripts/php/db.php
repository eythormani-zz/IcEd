<?php 
try {
    $dbHandler = new PDO("mysql:host=localhost; dbname=IcEd", "iced", "hvaðerigangi");
    $dbHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
 ?>