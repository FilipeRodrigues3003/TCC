<?php
	include 'conection.php';
    $testable = 0;
    $max_time = 50;
    
    function tempo($post_tempo){
    	$GLOBALS['max_time'] = isset($post_tempo) ? (int) $post_tempo : 10;
    	return $GLOBALS['max_time'];
    }
    
    //$max_time  =  tempo($post_tempo);// Tempo máximo em segundos para carregar a página com o melhor resultado obtido $GLOBALS['max_time']
   
    function geraCor($n, $k, $ac)
    {
        $j = 0;
        for ($i = $n - 1; $i >= 0; $i--) {
            if ($ac[$i] < $k - 1 && $j == 0 && $i > 0) {
                $cor[$i] = $ac[$i] + 1;
                $j = 1;
            } else {
                if ($j == 1) {
                    $cor[$i] = $ac[$i];
                } else {
                    $cor[$i] = 0;
                    $j = 0;
                }
            }
        }
        
        if ($j == 1) {
            $GLOBALS['testable']++;
            return $cor;
        } else {
            $GLOBALS['testable'] = -1;
            return -1;
        }
    }


    function verificaCor($cor, $G, $n)
    {
        $soma = 0;
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                if ($cor[$i] == $cor[$j]) {
                    $soma += $G[$i][$j];
                }
            }
        }
        return $soma;
    }

    function colorir($G, $n, $k)
    {
   
        $a_value = -1;
        list($usec, $sec) = explode(' ', microtime());
        $script_start = (float) $sec + (float) $usec;
        $solmin = 65000000;
        $c = 0;
        for ($j = 0; $j < $n; $j++) {
            if (($n - 1) - $j - $k < 0) {
                $cores[$j] = $c++;
            } else {
                $cores[$j] = 0;
            }
        }
        //print_r($cores);

        do {
            // $value = ceil($GLOBALS['testable'] * 100 / (($k ** ($n - 1)) / 2));
            $min = verificaCor(
                $cores,
                $G,
                $n
            );
            
            if ($solmin == 65000000) {
                $solmin = $min;
                for ($i = 0; $i < $n; $i++) {
                    $corMin[$i] = $cores[$i];
                }
            } else {
                if ($min < $solmin) {
                    $solmin = $min;
                    for ($i = 0; $i < $n; $i++) {
                        $corMin[$i] = $cores[$i];
                    }
                }
            }
            // $tempo = $GLOBALS['testable'];
            if ($solmin == 0) {

                $GLOBALS['testable'] = -1;
                break;
            }
            $cor = geraCor($n, $k, $cores);
            if ($cor == -1) {
                break;
            } else {
                $cores = $cor;
            }
            list($usec, $sec) = explode(' ', microtime());
            $script_end = (float) $sec + (float) $usec;
            $elapsed_time = round($script_end - $script_start, 5);

            if ($elapsed_time >= $GLOBALS['max_time']) {
                break;
            }
        } while ($cor != -1 && $solmin > 0);

        // echo (($tempo + 1) * 100 / ($k ** ($n - 1)));
        $corMin[$n] = $solmin;
        return $corMin;
    }

	    
    function matriz_adjacencia($cursos, $id_workspace){
		$pdo = conect();
		
		$sql = "SELECT COUNT(aluno.nome_aluno) AS aresta
				FROM aluno JOIN turma_aluno JOIN turma JOIN workspace
				WHERE aluno.id_aluno = turma_aluno.id_aluno 
					AND turma_aluno.id_turma = turma.id_turma 
					AND turma.nome_turma = :nome_turma1
					AND turma_aluno.id_aluno=aluno.id_aluno 
					AND workspace.id_workspace=turma.id_workspace 
					AND turma.id_workspace= :id_workspace
					AND aluno.id_aluno
				IN(
					SELECT aluno.id_aluno 
					FROM aluno JOIN turma_aluno JOIN turma JOIN workspace
					WHERE aluno.id_aluno = turma_aluno.id_aluno 
						AND turma_aluno.id_turma = turma.id_turma 
						AND turma.nome_turma = :nome_turma2
						AND turma_aluno.id_aluno=aluno.id_aluno 
						AND workspace.id_workspace=turma.id_workspace 
						AND turma.id_workspace= :id_workspace
				)";
		
		$busca = $pdo->prepare($sql);

		$matrix[0][0] = 0;
		for ($i = 0; $i < count($cursos) - 1; $i++) {
		    for ($j = $i + 1; $j < count($cursos); $j++) {
		        $busca->bindValue(":nome_turma1", $cursos[$i]);
		        $busca->bindValue(":nome_turma2", $cursos[$j]);
		        $busca->bindValue(":id_workspace", $id_workspace);
		        
		        $busca->execute();
		        $data = $busca->fetchAll(0);
		        $aresta = $data[0]['aresta'];
		        $matrix[$i][$j] = $aresta;
		        $matrix[$j][$i] = $aresta;
		        $matrix[$i][$i] = 0;
		        $matrix[$j][$j] = 0;
		    }
		}
		return $matrix;
    }
    
    function tam_turmas($cursos, $nome_workspace, $nome_usuario){
		$n_turma = [];
		$pdo = conect();
		$workspace = id_from_nome_workspace($nome_workspace, $nome_usuario);
		$conta_turma = $pdo->prepare("SELECT aluno.matricula FROM aluno JOIN turma_aluno JOIN turma JOIN workspace WHERE workspace.id_workspace=:workspace AND turma.id_workspace=:workspace AND aluno.id_aluno = turma_aluno.id_aluno AND turma_aluno.id_turma = turma.id_turma AND turma.nome_turma = :turma ORDER BY aluno.matricula;");
		for ($i = 0; $i < count($cursos); $i++) {
		    $conta_turma->bindValue(":turma", $cursos[$i]);
		    $conta_turma->bindValue(":workspace",$workspace);
		    $conta_turma->execute();
		    $data = $conta_turma->fetchAll();
		    $n_turma[$cursos[$i]] = count($data);
		}
		return $n_turma;
    }
    
    
    function trata_cursos($post_graph){
		$result = $post_graph;
		$grafos = explode(";", $result);
		array_pop($grafos);
		 $i = 0;
		foreach ($grafos as &$value) {
		    $hora_turma[$i++] = explode(":", $value);
		}
		$i = 0;
		$turmas = "";
		foreach ($hora_turma as &$value) {
		    $turmas = $turmas . $value[1] . ",";
		}
		$cursos = explode(",", $turmas);
    	array_pop($cursos);
    	$cursos = array_values(array_filter($cursos, function ($k) {
		    return $k != 'undefined';
		}));
		return $cursos;
	}
	
	function trata_horarios($post_graph, $cores){
		$result = $_POST["graph"];
		$grafos = explode(";", $result);
		array_pop($grafos);
		$i = 0;
		foreach ($grafos as &$value) {
		    $hora_turma[$i++] = explode(":", $value);
		}
		$horarios = "";
		foreach ($hora_turma as &$value) {
		    $horarios .= $value[0] . ",";
		    $cores_h[$value[0]] = explode(",", $value[1]);
		}
		$slots = explode(",", $horarios);
		array_pop($slots);
		
		$cores_t = [];
		
  		ksort($cores_h);
    	$hora_exp = array_keys($cores_h);

		for ($i = 0; $i < count($hora_exp); $i++) {
		    $hora_exp[$i] = str_replace('horario', "", $hora_exp[$i]);
		}
   
		$j = 0;
		foreach ($cores_h as &$hora) {

		    foreach ($hora as $t) {
		        $cores_t[$t] = $cores[(int)$hora_exp[$j] - 1]; // $cores[$j];
		        $cores_t[$j] = $cores[(int)$hora_exp[$j] - 1]; // $cores[$j];
		    }
		 	$j++;
		}
		
		return $cores_t;
	}
    
    function best_solution($GRAPH, $k, $cores, $id_workspace){
		$cursos = trata_cursos($GRAPH);
		$matriz = matriz_adjacencia($cursos, $id_workspace);
		$corMin = colorir($matriz, count($cursos), $k);
		$cores_t = trata_horarios($GRAPH, $cores);
		for($i=0;$i<count($cursos);$i++){
			$coloracao_manual[$i] = array_search($cores_t[$cursos[$i]], $cores); 
		}
	 
		$corManual = verificaCor($coloracao_manual, $matriz, count($cursos));
		
		
		if($corMin[count($cursos)]>=$corManual){
			for($i=0;$i<count($cursos);$i++){
				$corMin[$i] = $coloracao_manual[$i];
			}
			$corMin[$i] = $corManual;
			$corMin[count($cursos) + 1] = 0; 
		}
		else{
			$corMin[count($cursos) + 1] = 1; 
		}
		return $corMin;
    }
    
    function atual_solution($GRAPH, $k, $cores, $id_workspace){
		$cursos = trata_cursos($GRAPH);
		$matriz = matriz_adjacencia($cursos, $id_workspace);
		// $corMin = colorir($matriz, count($cursos), $k);
		$cores_t = trata_horarios($GRAPH, $cores);
		for($i=0;$i<count($cursos);$i++){
			$coloracao_manual[$i] = array_search($cores_t[$cursos[$i]], $cores); 
		}
		$corManual = verificaCor($coloracao_manual, $matriz, count($cursos));
		
		for($i=0;$i<count($cursos);$i++){
			$corMin[$i] = $coloracao_manual[$i];
		}
		$corMin[$i] = $corManual;
		$corMin[count($cursos) + 1] = -1; 
		
		return $corMin;
    }