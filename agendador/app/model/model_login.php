<?php
	include 'conection.php';
	$login = $_POST['login'];
	$senha = md5($_POST['senha']);
	
	$op = user_login($login, $senha);
	if($op==-1){
		header('Location: ../view/error.html');
	}else if($op==0){
		header('Location: ../view/login.php');
	}else{
		session_start();
		$_SESSION["usuario"] = $login;
		echo('<iframe width="100%" height="100%" src="https://www.youtube-nocookie.com/embed/OKPZBugBbgg?autoplay=1&controls=0&showinfo=0&rel=0&modestbranding=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"  allowfullscreen></iframe>');
		
		$id = id_from_login($login);
		new_user($id);
		header('Location: ../view/dashboard.php');
		// header('Location: ../view/alocador.php');
	}