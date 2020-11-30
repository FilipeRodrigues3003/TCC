<?php
	include 'conection.php';
	
	session_start();
	$nome = $_POST['nome'];
	

	new_workspace(id_from_login($_SESSION['usuario']), $nome);

	header('Location: ../view/dashboard.php'); 

	
	
	