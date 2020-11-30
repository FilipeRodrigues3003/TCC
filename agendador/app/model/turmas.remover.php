<?php
  $turma = $_GET["turma"];
  $pdo = new PDO("mysql:host=localhost;dbname=alocadb", "acess", "pass@1234");
  try {
    $deleta = $pdo->prepare("DELETE FROM turma WHERE  nome_turma=:turma ");
    $deleta->bindValue(":turma", $turma);
    $deleta->execute();
  } catch (\Throwable $th) {
    throw $th;
    header('Location: ../view/error.html');
  }

  header('Location: ../view/turmas.gerenciar.php');
  

