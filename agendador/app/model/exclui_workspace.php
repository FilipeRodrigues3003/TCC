<?php
	include 'conection.php';
	
	session_start();
	
	$nome = $_GET['w'];
	$id = $_GET['u'];
	
try {
 
	delete_workspace(id_from_login($id), $nome);
	// echo('<meta http-equiv="Location" content="../view/dashboard.php">');
	exit(header('Location: ../view/dashboard.php?status=new'));  
	//exit; 
	// header('Refresh:0; url=../view/dashboard.php', TRUE , 302); 
} catch (\Throwable $th) {
    throw $th;
    header('Location: ../view/error.html');
  }
	
	
	
