<?php
    $servername = "localhost";
    $username = "root";
    $password = "12230347";
    
    try {
      $pdo = new PDO("mysql:host=$servername;dbname=pf_system", $username, $password);
      // set the PDO error mode to exception
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
?>