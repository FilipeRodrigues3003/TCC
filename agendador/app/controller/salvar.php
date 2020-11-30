<?php
	//$op = $_GET["op"];
	session_start();
	include '../model/export_turmas_to_file.php';
	if($_GET["op"]=="workspace" || $_GET["op"]==0){
		export_workspace($_SESSION['workspace'], $_SESSION['usuario']);	
	}
	