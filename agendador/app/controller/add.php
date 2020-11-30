<?php

	include '../model/model_turmas.php';
	
	try{
		if (isset($_POST['envia'])) {
			$turma = $_POST['turma'];
			if ($turma != "") {
				session_start();
				$id = inserir_turma($turma, $_SESSION['workspace']);
				
				if (isset($_POST['aluno'])) {
				    $aluno = $_POST['aluno'];
				    $j = 0;
				    for ($i = 0; $i < count($aluno); $i++) {
				        if ($aluno[$i] != "") {
				        	$new_alunos[$j] = $aluno[$i];
				        	$j++;
				        }
				    }
				    inserir_alunos_na_turma($new_alunos, $id);
				}
			}
		}
	}catch (Exception $e) {
		header('Location: ../view/error.php?q=' . base64_encode($e->getMessage()) );
	}
	
	header('Location: ../view/turmas.gerenciar.php?q=sucess');