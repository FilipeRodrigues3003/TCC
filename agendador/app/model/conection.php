<?php
	
	function conect(){
		$pdo = new PDO("mysql:host=localhost;dbname=alocadb", "acess", "pass@1234");
		return $pdo;
	}
	
	function nome_from_login($login){
		$pdo = conect();
		
		$sql = "SELECT user_nome FROM usuario WHERE usuario.login=:nome";
		$busca = $pdo->prepare($sql);
		$busca->bindValue(":nome",$login);
		$busca->execute();
		$data = $busca->fetchAll(0);
		return $data[0][0];
	}
	
	function new_workspace($id_usuario, $nome_workspace){
		$pdo = conect();
		
		$sql = "INSERT INTO workspace(id_usuario, nome_workspace) VALUES(:id, :nome)";
		$insere = $pdo->prepare($sql);
		$insere->bindValue(":id",$id_usuario);
		$insere->bindValue(":nome",$nome_workspace);
		$insere->execute();
	
	}
	
	function id_from_login($login){
		$pdo = conect();
		
		$sql = "SELECT id_user FROM usuario WHERE usuario.login=:nome";
		$busca = $pdo->prepare($sql);
		$busca->bindValue(":nome",$login);
		$busca->execute();
		$data = $busca->fetchAll(0);
		return $data[0][0];
	}

	// inserir_turma(nome_turma, workspace);
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
	
	// inserir_alunos_na_turma(alunos, id_turma_nova);
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
	
	
	// alunos_from_turma(data[i][0]);
	function alunos_from_turma($id_turma){
		$pdo = conect();
		$sql = "SELECT aluno.nome_aluno, aluno.matricula
				FROM aluno JOIN turma_aluno JOIN turma
				WHERE turma.id_turma=turma_aluno.id_turma 
				AND aluno.id_aluno=turma_aluno.id_aluno 
				AND turma.id_turma=:id
				ORDER BY aluno.nome_aluno";
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
	
	function id_from_nome_turma_nologin($nome_turma, $nome_workspace, $id){
		$pdo = conect();
		$sql = "SELECT turma.id_turma
				FROM turma JOIN workspace 
				WHERE turma.nome_turma=:turma
					AND turma.id_workspace=workspace.id_workspace
					AND workspace.nome_workspace=:workspace
					AND workspace.id_usuario=:user";
		$busca = $pdo->prepare($sql);
		$busca->bindValue(":turma",$nome_turma);
		$busca->bindValue(":workspace",$nome_workspace);
		$busca->bindValue(":user",$id);
		$busca->execute();
		$data = $busca->fetchAll(0);
		$id = $data[0][0];
		return $id;
	}
	
	function new_user($id_usuario){
		$pdo = conect();
		
		$sql = "SELECT COUNT(workspace.id_workspace) 
				FROM workspace 
				WHERE workspace.nome_workspace='Exemplo' AND workspace.id_usuario=:user";
		$busca = $pdo->prepare($sql);
		$busca->bindValue(":user",$id_usuario);
		$busca->execute();
		$data = $busca->fetchAll(0);
		
		if($data[0][0]==0){
			// Criar workspace chamado Exemplo
			$sql_insert = "INSERT IGNORE INTO workspace(nome_workspace, id_usuario)
							VALUES('Exemplo',:user)";
			$busca = $pdo->prepare($sql_insert);
			$busca->bindValue(":user",$id_usuario);
			$busca->execute();
			
			
			// Pegar o id do workspace Clone
			$sql = "SELECT workspace.id_workspace
				FROM workspace 
				WHERE workspace.nome_workspace='Exemplo' AND workspace.id_usuario=:user";
			$busca = $pdo->prepare($sql);
			$busca->bindValue(":user",$id_usuario);
			$busca->execute();
			$clone = $busca->fetchAll(0);
			//echo("<br>id_clone<br>");
			$id_clone = (int)$clone[0][0];
			//var_dump($id_clone);
			//echo("<br><br>");
			//Adicionar as turmas do "Exemplo" original para a cópia 
			$sql = "SELECT turma.id_turma, turma.nome_turma
				FROM turma
				WHERE turma.id_workspace='9'";
			$busca = $pdo->prepare($sql);
			$busca->execute();
			$turmas_original = $busca->fetchAll(0);
			//echo("<br>Turmas<br>");
			//var_dump($turmas_original);
			//echo("<br><br>");
			for($i=0; $i<count($turmas_original); $i++){
				$ids_turmas[$i] = $turmas_original[$i][0];
				$nomes_turmas = $turmas_original[$i][1];
				
				$id_turma_nova = inserir_turma($nomes_turmas, $id_clone);
				$alunos = alunos_from_turma(id_from_nome_turma_nologin($nomes_turmas,'Apresentação','2'));
				inserir_alunos_na_turma($alunos, $id_turma_nova);
			}
		}/**/
	}
	
	function id_from_nome_turma($nome_turma, $id_workspace, $login){
		$pdo = conect();
		$sql = "SELECT turma.id_turma
				FROM turma JOIN workspace 
				WHERE turma.nome_turma=:turma
					AND turma.id_workspace=workspace.id_workspace
					AND workspace.id_workspace=:workspace
					AND turma.id_workspace=workspace.id_workspace
					AND workspace.id_usuario=:user";
		$busca = $pdo->prepare($sql);
		$busca->bindValue(":turma",$nome_turma);
		$busca->bindValue(":workspace",$id_workspace);
		$id = id_from_login($login);
		$busca->bindValue(":user",$id);
		$busca->execute();
		$data = $busca->fetchAll(0);
		$id = $data[0][0];
		return $id;
	}
	
	
	
	function id_from_nome_workspace($nome_workspace, $login){
		$pdo = conect();
		$sql = "SELECT id_workspace 
				FROM workspace
				WHERE workspace.nome_workspace=:nome 
					AND workspace.id_usuario=:id";
		$busca = $pdo->prepare($sql);
		$busca->bindValue(":nome",$nome_workspace);
		
		$id = id_from_login($login);
		
		$busca->bindValue(":id",$id);
		$busca->execute();
		$data = $busca->fetchAll(0);
		$id = $data[0][0];
		return $id;
	}
	
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
	
	
	
	
	function user_create($nome, $login, $senha){
		try{
			$pdo = new PDO("mysql:host=localhost;dbname=alocadb", "acess", "pass@1234");
			$busca = $pdo->prepare("SELECT COUNT(id_user) FROM usuario WHERE login=:login;");
			$busca->bindValue(":login", $login);
			$busca->execute();
			$data = $busca->fetchAll();
			if($data[0][0]>0){
				return -2;
			}
			$busca = $pdo->prepare("INSERT INTO usuario(login, user_nome, senha) VALUES(:login, :nome, :senha);");
			$busca->bindValue(":login", $login);
		    $busca->bindValue(":nome", $nome);
		    $busca->bindValue(":senha", $senha);
		    $busca->execute();
		    
		    $busca2 = $pdo->prepare("SELECT id_user FROM usuario WHERE login=:login;");
		    $busca2->bindValue(":login", $login);
		    $busca2->execute();
		    $data = $busca2->fetchRow();
		    return $data['id_user'];
        }catch(Exception $e){
        	echo($e->getMessage());
        	return -1;
        }
	}
	
	function user_login($login, $senha){
		try{
			$pdo = new PDO("mysql:host=localhost;dbname=alocadb", "acess", "pass@1234");
			$busca = $pdo->prepare("SELECT senha FROM usuario WHERE login=:login;");
		    $busca->bindValue(":login", $login);
		    $busca->execute();
		    $data = $busca->fetchAll();
		    if($data[0][0] === $senha){
		    	return 1;
		    }
		    else{
		    	return 0;
		    }
		}catch(Exception $e){
			echo($e->getMessage());
			return -1;
		}
	}
	
	
	function readDB($id_workspace, $login) 
    {
        $pdo = new PDO("mysql:host=localhost;dbname=alocadb", "acess", "pass@1234");
        
        $sql = 	"
        		
        		
        		";
        
        
        $test = $pdo->prepare("SELECT COUNT(id_workspace) FROM workspace JOIN usuario WHERE usuario.login=:login AND workspace.id_workspace=:workspace AND usuario.id_user=workspace.id_usuario");
        $test->bindValue(":login",$login);
        $test->bindValue(":workspace",$id_workspace);
        $test->execute();
        $valid = $test->fetchAll(0);
        
       if($valid[0][0]=="1"){
		    $turmasdb = $pdo->prepare("SELECT nome_turma FROM turma WHERE turma.id_workspace=:workspace");
		    $turmasdb->bindValue(":workspace",$id_workspace);
		    $turmasdb->execute();
		    $dataTurmas = $turmasdb->fetchAll(0);

			
		    foreach ($dataTurmas as $turma) {

		        $busca = $pdo->prepare("SELECT aluno.matricula 
		        						FROM aluno JOIN turma_aluno JOIN turma  
		        						WHERE turma_aluno.id_aluno=aluno.id_aluno 
		        							AND nome_turma=:turma 
		        							AND turma.id_turma=turma_aluno.id_turma
		        							AND turma.id_workspace=:workspace");
          
		        $busca->bindValue(":turma", $turma[0]);
		        $busca->bindValue(":workspace",$id_workspace);
		        $busca->execute();
		        $data = $busca->fetchAll();
		        
		        $id = $data[0][0];
		        for ($i = 1; $i < count($data); $i++) {
		            $id = $id . ":" . $data[$i][0];
		        }
		        echo ('<div class="drag btn-group" id="' . $turma[0] . '" draggable="true" ondragstart="return dragStart(event)" data-value="' . $id . '"  value="turmas"><i class="material-icons" style="float: left; margin-top: 12px;">drag_indicator</i>' . $turma[0] . '</div>');
		    }
		    echo ('<br><div class="spinner-border d-none" style="width: 3rem; height: 3rem;" role="status">
		    <span class="sr-only">Loading...</span>
		  </div>');
      }else{
      	header("Location: dashboard.php");
      }
    }
    
    function workspace_name($id){
    	$pdo = new PDO("mysql:host=localhost;dbname=alocadb", "acess", "pass@1234");
    	$busca = $pdo->prepare("SELECT nome_workspace FROM workspace WHERE workspace.id_workspace=:id");
    	$busca->bindValue(":id",$id);
    	$busca->execute();
    	$result = $busca->fetchAll(0);
    	return (string)$result[0][0];
    
	}

    
    function dashboard_load($login){
    	$pdo = new PDO("mysql:host=localhost;dbname=alocadb", "acess", "pass@1234");
    	$limpa = $pdo->prepare("RESET QUERY CACHE; ");
    	$limpa->execute();
    	$busca = $pdo->prepare("SELECT id_user FROM usuario WHERE login=:login;");
    	$busca->bindValue(":login", $login);
		$busca->execute();
		$usuario = $busca->fetchAll(0);
        $areas = $pdo->prepare("SELECT nome_workspace, id_workspace FROM workspace WHERE id_usuario=:usuario");
    	$areas->bindValue(":usuario", $usuario[0][0]);
    	$areas->execute();
    	$data = $areas->fetchAll(0);
    	   	
    	return $data;
    }
    
    function data_workspace($nome_workspace, $login){
		$pdo = conect();
		$idioma = 'SET lc_time_names = "pt_br"';
		$ini = $pdo->prepare($idioma);
		$ini->execute();
		$sql = 'SELECT DATE_FORMAT(data_criacao ,"%W,  %e de %M de %Y")
				FROM workspace
				WHERE workspace.nome_workspace=:nome 
					AND workspace.id_usuario=:id';
		$busca = $pdo->prepare($sql);
		$busca->bindValue(":nome",$nome_workspace);
		
		$id = id_from_login($login);
		
		$busca->bindValue(":id",$id);
		$busca->execute();
		$data = $busca->fetchAll(0);
		$id = $data[0][0];
		return $id;
	}
    
    function delete_workspace($id_user, $nome_workspace){
        $pdo = conect();
        $ini = $pdo->prepare('DELETE FROM workspace WHERE workspace.nome_workspace=:nome AND workspace.id_usuario=:id');
        $ini->bindValue(":nome",$nome_workspace);
        $ini->bindValue(":id",$id_user);
        $ini->execute();
        $limpa = $pdo->prepare("RESET QUERY CACHE; ");
    	$limpa->execute();
    }
 ?>
