<?php 
    
    $pdo = new PDO("mysql:host=localhost;dbname=alocadb", "acess", "pass@1234");
    $sql = file_get_contents("data.sql");
    $pdo->prepare($sql);
    $pdo->execute();
