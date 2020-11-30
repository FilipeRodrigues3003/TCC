<?php
	include 'conection.php';
	$nome = $_POST['nome'];
	$login = $_POST['login'];
	$senha = md5($_POST['senha1']);
	$op = user_create($nome, $login, $senha);
	if($op==-1){
		header('Location: ../view/error.html');
	}else if($op==-2){
		header('Location: ../view/cadastro_usuario.php');
	}
