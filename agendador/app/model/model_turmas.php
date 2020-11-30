<?php
	include 'conection.php';
	
	// CRUD TURMAS
	
	// CREATE
	
	// create turma
	
	function inserir_turma($nome_turma, $id_workspace){
		$pdo = conect();
		$sql = "INSERT IGNORE INTO turma(nome_turma, id_workspace) VALUES(:nome, :workspace)";
		$busca = $pdo->prepare($sql);
		$busca->bindValue(":nome",$nome_turma);
		$busca->bindValue(":workspace",$id_workspace);
		$busca->execute();
		
		$sql = "SELECT turma.id_turma 
				FROM turma 
				WHERE turma.nome_turma=:nome AND turma.id_workspace=:workspace";
		$busca = $pdo->prepare($sql);
		$busca->bindValue(":nome",$nome_turma);
		$busca->bindValue(":workspace",$id_workspace);
		$busca->execute();
		$data = $busca->fetchAll(0);
		//
		$id = $data[0][0];
		//echo("<br>ID TURMA NOVA: ".$id."<br>");
		return $id;
	}
	
	// create aluno
	function  inserir_alunos_na_turma($alunos, $id_turma){
		$pdo = conect();
		//echo("<br>Inserir alunos TURMA NOVA: ".$id_turma."<br>");
		//var_dump($alunos);
		//echo("<br>");
		for($i=0;$i<count($alunos);$i++){
			$insere_aluno = $pdo->prepare("INSERT IGNORE INTO aluno(matricula, nome_aluno) VALUES(:matricula, :nome)");
		    $insere_aluno->bindValue(":matricula", $alunos[$i][1]);
		    $insere_aluno->bindValue(":nome", $alunos[$i][0]);
		    $insere_aluno->execute();
		    
		    $busca_aluno = $pdo->prepare("SELECT id_aluno FROM aluno WHERE matricula=:matricula");
		    $busca_aluno->bindValue(":matricula", $alunos[$i][1]);
		    $busca_aluno->execute();
		    $id_aluno = $busca_aluno->fetchAll(0);
		    
		    $relaciona = $pdo->prepare("INSERT INTO turma_aluno(id_turma, id_aluno) VALUES(:id_turma,:id_aluno)");
		    $relaciona->bindValue(":id_turma", $id_turma);
		    $relaciona->bindValue(":id_aluno", $id_aluno[0][0]);
		    $relaciona->execute();
        }
	}
	
	
	// READ
	
	// read turma
	function nome_turmas_from_workspace($id_workspace){
		$pdo = conect();
		$busca = $pdo->prepare("SELECT nome_turma FROM turma WHERE turma.id_workspace=:id");
		$busca->bindValue(":id",$id_workspace);
		$busca->execute();
		$arr_turmas = $busca->fetchAll(0);
		
		$turmas[0] = '';
		
		for($i=0; $i<count($arr_turmas);$i++){
			$turmas[$i] = $arr_turmas[$i]["nome_turma"];
		}
		
		return $turmas; 
	}
	// read aluno
	function alunos_from_turma($id_turma){
		$pdo = conect();
		$sql = "SELECT aluno.nome_aluno, aluno.matricula
				FROM aluno JOIN turma_aluno JOIN turma
				WHERE turma.id_turma=turma_aluno.id_turma 
				AND aluno.id_aluno=turma_aluno.id_aluno 
				AND turma.id_turma=:id";
		$busca = $pdo->prepare($sql);
		$busca->bindValue(":id",$id_turma);
		$busca->execute();
		$data = $busca->fetchAll(0);
		
		for($i=0; $i<count($data);$i++){
			$alunos[$i][0] = $data[$i]["nome_aluno"];
			$alunos[$i][1] = $data[$i]["matricula"];
		}
		
		return $alunos;
	}
	// UPDATE
	
	// update turma
	
	// update aluno
	
	// DELETE
		
	// delete turma
	
	// detele aluno