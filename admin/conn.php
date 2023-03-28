<?php
$serverName = "localhost";
$userName = "root";
$password = "";

try{
    $conn = new PDO("mysql:host=$serverName;dbname=blog", $userName, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Connected successfully";
}catch(PDOException $e){
      echo "Connection failed: " . $e->getMessage();
}
?>