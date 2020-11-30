<?php
	session_start();
	$_SESSION['usuario']="";
	$_SESSION['workspace']="";
	
	session_unset(); 
	session_destroy();
	if(isset($_GET['err'])){
		$err = "?err=" . $_GET['err'];
	}else{
		$err = "";
	}
	header('Location: ../view/login.php' . $err);