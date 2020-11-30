<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
	<meta name="viewport" content="width=1024" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>Resultados</title>
 	<link rel="stylesheet" href="src/bootstrap.min.css" />
 	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="src/roboto.css" />
        <link rel="stylesheet" href="src/icon.css" />
        <link rel="stylesheet" href="style/main.css" />
		<link rel="stylesheet" href="style/tests.css" />

</head>

<body style="box-align: center;"> 
    <div id="progress" class="text-center">
        <div class="row horizontal-center vertical-center robo-row">
            <img src="img/robotic.svg" width="60px" heigth="60px">
            <div class="balao">
                <h1>Aguarde: Estou em busca da melhor solução...</h1>
            </div>

        </div>
    </div>
    
    <?php
	
    include '../controller/ini_session.php';
    
    include '../model/solucao.php';
    
    identidade(workspace_name(base64_decode($_GET['q'])));
    
    $tt = isset($_POST['tempo']) ? (int) $_POST['tempo'] : 10;
    $max_time  =  tempo($tt);
    ini_set('max_execution_time', 310);
    
    $result = $_POST["graph"];
    $info = $_POST["infos"];
    $k = (int)$_POST["k"];
    $infos = explode(";", $info);
	$cores = array(
				'#F44336', '#2196F3', '#4CAF50', '#FFEB3B', '#9C27B0', '#3E2723', '#E91E63', '#01579B', '#B71C1C', '#CDDC39',
				'#00E5FF', '#8BC34A', '#FF9800', '#673AB7', '#009688', '#FFC107', '#FF5722', '#2962FF', '#1B5E20', '#AA00FF',
				'#76FF03', '#BF360C', '#F48FB1', '#E6EE9C', '#9FA8DA', '#33691E', '#FFCC80', '#80CBC4', '#000000', '#FFFF00'
			);
			
	$q = isset($_GET['r']) ? (string) $_GET['r'] : '0';
    if($q == md5('best')){
    	$corMin = best_solution($_POST["graph"], $k, $cores, id_from_nome_workspace($_SESSION['workspace'], $_SESSION['usuario']));
    }else{
    	$corMin = atual_solution($_POST["graph"], $k, $cores, id_from_nome_workspace($_SESSION['workspace'], $_SESSION['usuario']));
   	}
   
    echo ('<script>document.getElementById("progress").classList.add("d-none");</script>');
    
    ?>
    
    <nav class="navbar  navbar-expand-sm navbar-dark bg-dark">
		
	  	<a class="navbar-brand" href="#">	
	  		<button class="btn btn-dark btn-lg" disabled>
		    		<i class="material-icons">insert_chart_outlined</i>
				Resultado
    			</button>
		</a>

	  	<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
				<li class="nav-item active">
                    <a class="nav-link" href="#" onclick="dashboard();">
                        <button class="btn btn-dark btn-sm">
                            <i class="material-icons">
                               bookmarks
                            </i>
                            <b>Dashboard</b> 
                        </button>
                    </a>
                </li>
		  		<li class="nav-item active" onclick="info();">
		    		<a class="nav-link" href="#">
		    			<button class="btn btn-dark btn-sm">
		    				<i class="material-icons">info</i>
		    				Sobre
		    			</button>
		    		</a>
		  		</li>
		  		<li class="nav-item">
		    		<a class="nav-link" href="#" onclick="contato();">
		    			<button class="btn btn-dark btn-sm">
		    				<i class="material-icons">alternate_email</i>
		    				Contato
		    			</button>
		    		</a>
		  		</li>
		  		<li class="nav-item">
		   			
		   			<a class="nav-link" href="#">
		   				<button class="btn btn-dark btn-sm" onclick="exit();">
			   				<i class="material-icons">power_settings_new</i>
			   				Sair
		   				</button>
		   			</a>
		  		</li>
			</ul>
			<div class="form-inline my-2 my-lg-0" >
				<div class="input-group ">
			  		<input id="busca" class="form-control  " type="text" placeholder="Pesquisar na Wikipédia" aria-label="Pesquisar">
			  		<div class="input-group-append ">
			  			<button class="btn btn-light btn-sm" onclick="search_p(document.getElementById('busca').value)"><i class="material-icons">search</i></button>
			  		</div>
			  	</div>
			</div>
	  	</div>
	</nav>
    <br><br>
    <?php
    echo ('<div class="d-none d-print-inline-block"><img src="img/0001.jpg" width="100%"/></div><h1 class="d-none d-print-inline-block">Resultados obtidos para realização das provas</h1>');
    
    $cursos = trata_cursos($result);
    
    $ante = (int) $infos[0];
		
	$n = (int) count($cursos);
	$robo = (int) $corMin[$n];
	if ($ante > 0) {
	    $value_x = (string) (ceil((($ante - $robo) * 100) / $ante));
	} else {
	    $value_x = $robo * 100;
	}
    
    
    if($corMin[count($cursos)+1] == -1 || $corMin[count($cursos)+1] == 0){
		echo ('<div class="row text-center robo-row d-print-none"> <img src="img/robotic.svg" width="30px" heigth="30px"> <div class="balao"> <h3> Sua solução necessita de <span class="badge badge-light badge-pill">'. $corMin[count($cursos)] .'</span> provas de Segunda Chamada!</h3></div></div><br><br>');
		echo ('<div class="d-none d-print-inline-block"><p>Para aplicar as provas com sua solução, serão necessárias '. $corMin[count($cursos)] .' provas de Segunda Chamada.</p></div>');
		
    }
    
    if ($corMin[count($cursos)+1] != -1){
    
		if ($GLOBALS['testable'] == -1 &&  $corMin[count($cursos)+1] == 1) {
		    echo ('<div class="row text-center robo-row d-print-none"> <img src="img/robotic.svg" width="30px" heigth="30px"> <div class="balao"><h3 > A melhor solução encontrada necessita de <span class="badge badge-light badge-pill">' . $corMin[count($cursos)] . '</span> provas de Segunda Chamada!</h3></div></div>');
		    echo ('<div class="d-none d-print-inline-block"><p>Após verificar todas as opções de alocação para as turmas, encontramos uma solução que necessitará de ' . $corMin[count($cursos)] . ' provas de segunda chamada.</p></div>');
		} else if($corMin[count($cursos)+1] == 1){
		    echo ('<div class="row text-center robo-row d-print-none"> <img src="img/robotic.svg" width="30px" heigth="30px"> <div class="balao"> <h3> A melhor solução encontrada em ' . $GLOBALS['max_time'] . ' seg foi de <span class="badge badge-light badge-pill">' . $corMin[count($cursos)] . '</span> provas de Segunda Chamada!</h3></div></div>');
		    echo ('<div class="d-none d-print-inline-block"><p>Após verificar as opções de alocação para as turmas por ' . $GLOBALS['max_time'] . ' segundos, encontramos uma solução que necessitará de ' . $corMin[count($cursos)] . ' provas de segunda chamada.</p></div>');
		}
		echo ('<br>');
	   
		
		
		if ($ante > $robo) {
			echo ('<div class="d-print-none alert alert-secundary border-dark alert-dismissible fade show" role="alert"><h3 class="d-print-none text-center"> Sua solução exigiria <span class="badge badge-dark badge-pill">' . $infos[0] . '</span> provas de Segunda Chamada!</h3><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		    echo ('<div class="d-print-none alert alert-success alert-dismissible fade show" role="alert"><h4 class="text-center"> O Robô encontrou uma solução ' . ($value_x) . '% melhor que a obtida manualmente!</h4><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		    echo ('<div class="d-none d-print-inline-block"><p>A solução encontrada com uso do nosso <a href="#pdf-solucao" style="text-decoration: none;">algoritmo</a> é ' . ($value_x) . '% melhor que a obtida manualmente.</p></div>');
		} else if ($corMin[count($cursos)+1] == 0) {
		    echo ('<div class="d-print-none alert alert-warning alert-dismissible fade show" role="alert"><h4 class="text-center"> A solução encontrada pelo Robô foi descartada por não ser melhor que a obtida manualmente!</h4><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		    echo ('<div class="d-none d-print-inline-block"><p>A solução encontrada foi descartada por ser pior que a obtida manualmente. Isso ocorreu devido ao <a href="#pdf-solucao" style="text-decoration: none;">algoritmo</a> não ter tido tempo suficiente para testar todas as possibilidades de alocação.</p></div>');
		} else {
		    echo ('<div class="d-print-none alert alert-secondary alert-dismissible fade show" role="alert"><h4 class="text-center"> A solução encontrada pelo Robô é igual a obtida manualmente!</h4><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		    if ($GLOBALS['testable'] == -1) {
		        echo ('<div class="d-none d-print-inline-block"><p>O resultado da solução encontrada é a mesma que a obtida manualmente. Isso representa que a solução obtida manualmente é a melhor possivel para esse conjunto de turmas.</p></div>');
		    } else {
		        echo ('<div class="d-none d-print-inline-block"><p>O resultado da solução encontrada é a mesma que a obtida manualmente. Isso significa que a solução obtida manualmente é igual a solução encontrada em ' . $GLOBALS['max_time'] . ' segundos de execução do algoritmo. </p></div>');
		    }
		}
	}
	$matrix =  matriz_adjacencia($cursos, id_from_nome_workspace($_SESSION['workspace'], $_SESSION['usuario']));
    $j = 0;
    foreach ($cursos as &$turma) {
        $cores_t[$turma] = $cores[$corMin[$j]];
        $j++;
    }
  	
  	$pdo = conect();
	$sql1 = 	"SELECT aluno.nome_aluno, aluno.matricula FROM 
				aluno JOIN turma_aluno JOIN turma JOIN workspace 
				WHERE aluno.id_aluno = turma_aluno.id_aluno 
					AND turma_aluno.id_turma = turma.id_turma 
					AND turma.nome_turma = :nome_turma 
					AND workspace.id_workspace=turma.id_workspace 
					AND turma.id_workspace= :id_workspace
				ORDER BY aluno.nome_aluno";
				
    $busca_turma = $pdo->prepare($sql1);
    
    $sql2 =    "SELECT aluno.nome_aluno, aluno.matricula 
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

				)
				ORDER BY aluno.nome_aluno";
    $busca_inter = $pdo->prepare($sql2);
    ?>
    <div class="slot-container row">
        <?php

        $aux = 1;
        $n_turmas = tam_turmas($cursos, $_SESSION['workspace'], $_SESSION['usuario']);
        foreach ($cores as &$slot) {
            $e = 0;
            $sum = 0;
            for ($i = 0; $i < $n; $i++) {  if ($slot == $cores_t[$cursos[$i]]) { $sum += $n_turmas[$cursos[$i]]; } }
            for ($i = 0; $i < $n; $i++) {
                if ($slot == $cores_t[$cursos[$i]]) {
                
                    if ($e == 0) {
                        
                        echo (' <div class="slots-horarios  d-print-inline-flex card text-white d-print-inline-block" style="max-width: 80%; background-color: ' . $cores_t[$cursos[$i]] . ';">
						        <div class="card-header"><span class="badge badge-light badge-pill">'. $sum . '</span> <span style="margin-left: 23%;">Provas no Horário ' . $aux++ . '</span></div>
						        <div class="card-body">
						            <p class="card-text">
						                <ul class="list-group">');
                    }
                   
                    echo (' <li class="list-group-item list-group-item-dark d-flex justify-content-between align-items-center">
                ' . $cursos[$i] . '<span class="badge badge-light badge-pill">
                ' . $n_turmas[$cursos[$i]] . '</span></li> ');
                    $e++;
                    
                }
            }
            if ($e > 0) {
                echo (' </ul>
                        </p>
                    </div>
                </div>');
            }
        }

        ?>
        <div class="d-none d-print-inline-block"><br>
            <h2>Horários para realização dos Exames</h2>
            <p>
            Cada horário, representado por um retângulo de uma cor específica, possui as turmas que deverão realizar os exames em um mesmo horário.
            </p>
            <p>
            Sobreposto à informação da turma, está a quantidade de alunos matriculados, dessa forma podemos saber o exato número de provas que cada disciplina precisará. O número total de provas necessárias em cada horário é apresentado no topo do retângulo, realizando o somatório das provas por turma, sem o decréscimo das avaliações para os alunos prejudicados, caso existam. 
            </p>
        </div>
    </div>
    
    
    <br><br><br>
    <div class="container-fluid" id="container">
        <div class="d-print-inline-block row justify-content-start">
           <!--<div class="d-none d-print-inline-block">
                 <p id="header">Método de Solução Utilizado</p>
                <p>
                    Visando permitir o uso do poder computacional na busca de uma solução para o problema, foi necessário modelar o problema de forma matemática.
                </p>
                <p>
                    Dessa forma foi optado o uso da teoria dos grafos como estrutura matemática
visando modelar o problema.
                </p>
                <p>
                O que é Teoria dos Grafos?
                <ul>
                    <li><strong>Grafo</strong>: é definido por Szwarcifter (1986) como sendo uma estrutura matemática composta por um conjunto finito não vazio de vértices V e um conjunto E de pares, não ordenados, de diferentes vértices denominados arestas.</li>
                    <li><strong>Vértices</strong>: um vértice é denotado por V é representado graficamente através de um ponto, a quantidade dos vértices de um grafo é expressa por |V |, onde um grafo com |V | = 1 é classificado como um grafo trivial;</li>
                    <li><strong>Arestas</strong>: uma aresta $e \in E$ é denotada por um par de vértices $e = (v,w)$. Dessa forma os vértices $v$ e $w$ estão conectados as extremidades da aresta e, dessa forma são denominados adjacentes. Já uma aresta é denominada incidente aos vértices em seus extremos $v$ e $w$;</li>
                    <li><strong>Coloração de Grafos</strong>: Colorir um grafo consiste em encontrar um conjunto de cores para os vértices de forma que nenhuma aresta incida em dois vértices de mesma cor.</li>
                    
                </ul>
                </p>
            </div>-->
            <div class="d-none d-print-inline-block desc-graph"><h2>Resultado em forma de Grafo.</h2><p>Com a visualização do resultado na forma de um <a href="#pdf-grafos" style=" text-decoration: none;">grafo</a> pode ser observado graficamente quais as turmas possuem alunos em comum e quais dessas turmas acabaram sendo alocadas em um mesmo horário.
</p></div><br><br>
            <div id="graph-container" class="shadow col-sm justify-content-start" style="left: 25%;"></div>
            <br>
            
            <?php
              
                if($corMin[count($cursos)]>0){
            echo('<div class="nova-pagina" ></div>
            <div class="d-none d-print-inline-block desc-tabelas">
                <h2>Provas de segunda chamada</h2>
                <p>
                   A lista a seguir apresenta as turmas que possuem conflitos entre alunos, e os alunos que necessitarão de provas de segunda chamada.
                </p>
            </div>');}
            ?>
            <div id="tabelas" class="col-sm">
                <?php for ($i = 0; $i < count($cursos); $i++) {
                    echo ('<table class="d-none table d-print-none" id="' . $cursos[$i] . '"><thead>
                <tr>
                 
                  <th scope="col" colspan="3" class="bg-white text-dark text-center font-weight-bold"><a name=”' . $cursos[$i] . '″>Alunos de ' . $cursos[$i] . '</a></th>
                </tr>
              </thead><tbody>');
              echo ('<tr class="bg-light">
                        <th scope="row" class="text-muted"><i>#</i></th>
                        <td><i>Nome</i></td>
                        <td><i>Matrícula</i></td>
                      </tr>');
                    $busca_turma->bindValue(":nome_turma", $cursos[$i]);
                    $busca_turma->bindValue(":id_workspace", id_from_nome_workspace($_SESSION['workspace'], $_SESSION['usuario']));
                    $busca_turma->execute();
                    $data = $busca_turma->fetchAll(0);
                    for ($c = 0; $c < count($data); $c++) {
                        $p = $c + 1;
                        echo ('<tr>
                        <th scope="row" class="text-muted">' . $p . '</th>
                        <td>' . $data[$c][0] . '</td>
                        <td><strong>' . $data[$c][1] . '</strong></td>
                      </tr>');
                    }
                    echo ('</tbody></table>');
                } ?>
                <?php for ($i = 0; $i < count($cursos) - 1; $i++) {
                    for ($j = $i + 1; $j < count($cursos); $j++) {
                        $busca_inter->bindValue(":nome_turma1", $cursos[$i]);
                        $busca_inter->bindValue(":nome_turma2", $cursos[$j]);
                        $busca_inter->bindValue(":id_workspace", id_from_nome_workspace($_SESSION['workspace'], $_SESSION['usuario']));
                        $busca_inter->execute();
                        $data = $busca_inter->fetchAll(0);
                        if (count($data) > 0) {
                            echo ('<table class="d-none table d-print-none" id="' . $cursos[$i] . "-" . $cursos[$j] . '">
                                <thead>
                                        <tr>
                                            
                                            <th scope="col" colspan="3" class="text-center bg-white text-dark font-weight-bold"><a name=”' . $cursos[$i] . "-" . $cursos[$j] .  '″>Alunos matriculados em ' . $cursos[$i] . " e " . $cursos[$j] .  '</a></th>  
                                        </tr>
                                </thead>
                                
                                <tbody>');
                echo ('<tr class="bg-light">
                                            <th scope="row" class="text-muted"><i>#</i></th>
                                            <td><i>Nome</i></td>
                                            <td><i>Matrícula</i></td>
                                        </tr>');

                            for ($c = 0; $c < count($data); $c++) {
                                $p = $c + 1;
                                echo ('<tr>
                                            <th scope="row" class="text-muted">' . $p . '</th>
                                            <td>' . $data[$c][0] . '</td>
                                            <td><strong>' . $data[$c][1] . '</strong></td>
                                        </tr>');
                            }
                            echo ('</tbody>
                                </table>');
                        }
                    }
                } ?>
            </div>
        </div>
    </div>
    
    <div class="nova-pagina"></div>
    
    
    <div class="d-none d-print-inline-block" style="page-break-before: always;">
        <h2 id="pdf-solucao">Método de Solução Utilizado</h2>
                <p>
                    Visando permitir o uso do poder computacional na busca de uma solução para o problema, foi necessário modelar o problema de forma matemática.
                </p>
                <p> 
                    Dessa forma foi optado o uso da teoria dos grafos como estrutura matemática
visando modelar o problema.
                </p>
                <p> 
                    <br>
                     <h4 id="pdf-grafos">O que é Teoria dos Grafos?</h4>
                     <br>
                     <p> Um <strong>grafo</strong> é definido por <a href="#ref-szwarcifter86" style=" text-decoration: none;">Szwarcifter (1986)</a> como sendo uma estrutura matemática composta por um conjunto finito não vazio de vértices V e um conjunto E de pares, não ordenados, de diferentes vértices denominados arestas. </p>
                     <p> Um grafo é composto por uma série de elementos entre os quais se destacam:</p>
                <ul>
                    
                    <li><strong>Vértices</strong>: um vértice também é chamado de V e representado graficamente através de um ponto, a quantidade dos vértices de um grafo é expressa por <i>|V|</i>, onde um grafo com <i>|V| = 1</i> é classificado como um grafo trivial;</li>
                    <li><strong>Arestas</strong>: uma aresta <i>e</i> é formada por um par de vértices, com isso <i>e = (v, w)</i>. Dessa forma os vértices <i>v</i> e <i>w</i> estão conectados as extremidades da aresta e dessa forma são denominados adjacentes. Já uma aresta é denominada incidente aos vértices em seus extremos <i>v</i> e <i>w</i>;</li>                    
                </ul>
                </p>
                <br>
                <p>
                    <h4 id="pdf-grafos-intersecao">Como transformamos as turmas em Grafos?</h4>
                     <br>
                    <p>Para utilizar a teoria dos grafos para modelar esse problema foi necessário a utilização dos grafos de interseção.</p>
                    <p><a href="#ref-pinto18" style=" text-decoration: none;">Pinto (2018)</a> define um Grafo de Interseção, quando seja possível esse grafo G(V, E) representar as relações entre elementos de um conjunto através das relações entre seus vértices v ∈ V.</p> 
                    <p>Dessa forma iremos relacionar os alunos das turmas aos vértices do Grafo, e criaremos arestas que indique a presença de alunos que componham ambas as turmas. Com isso teremos a turma como um grafo, que inclusive pode ser visualizada em sua forma geométrica.</p>
                </p>
                <p>
                    <br>
                    <h4 id="pdf-horarios">Definindo os horários de forma automática. </h4>
                     <br>
                    <p>Após realizar a modelagem na forma de um problema de grafo, iremos utilizar essa estrutura para criar uma grade de horário de provas.</p>
                    <p>Para definir quais provas poderão ser aplicadas em um mesmo horário, iremos considerar os alunos pertencentes á ambas turmas. Com isso, caso duas turmas não possuam alunos em comum, elas poderão realizar seus exames em um mesmo horário.</p>
                    <p>Agora, para realizarmos a atribuição das turmas em horários aproveitaremos a
forma geométrica do grafo, atribuindo uma cor a cada horário e pintando o vértice da cor correspondente ao horário.</p>
                    <p>A partir desse momento iremos atribuir á primeira turma o primeiro horário, dessa forma podemos pintar o primeiro vértice da primeira cor (vermelho, por exemplo).</p>
                    <p>Ao pintar o próximo vértice, poderemos ter um caso onde ele possua alunos em comum com a turma anteriormente pintada, nesse caso iremos pinta-lo com nossa segunda cor (azul, por exemplo). Mas se as turmas não possuírem alunos em comum (ou seja, não sejam ligadas por uma aresta) poderemos usar a mesma cor para pinta-la.</p>
                    <p>Seguiremos repetindo esse procedimento de olhar em que horário estão as turmas que possuem alunos em comum para não colocarmos ambas as turmas no mesmo horário, o que causaria a necessidade de se aplicar uma prova de segunda chamada para os alunos prejudicados.</p>
                    <p>Esse processo de pintar os vértices do grafo, de forma que vértices adjacentes não recebam mesma cor, consiste em uma área muito estudada dentro da Teoria de Grafos, que é a Coloração de Grafos.</p>
                </p>
                <p>
                    <br>
                    <h4 id="pdf-coloracao">O que é Coloração de Grafos?</h4>
                    <br>
                    <p>Colorir um grafo G propriamente é definido por <a href="#ref-goldbarg12" style=" text-decoration: none;">Goldbarg e Goldbarg (2012)</a> como, atribuir cores aos seus vértices de forma que vértices adjacentes recebam cores distintas.</p>
                    <p>O principal problema em se colorir um grafo propriamente consiste em determinar qual o menor número possível para se colorir o grafo.</p>
                    <p>Esse número é chamado de número cromático do grafo ou χ(G). É um problema classificado como NP-Completo, sendo um dos problemas cuja solução não pode ser obtida em tempo polinomial de execução.</p>
                    <p>Contudo, a solução do problema de exames universitários por meio da coloração própria de vértices, não resolverá todos os casos possíveis, já que é possível existir um caso onde a quantidade de horários disponíveis para realização da prova é menor que o número cromático do grafo.</p>
                    <p>Nesse caso, como uma coloração própria não será suficiente, adotaremos uma nova forma de solução.</p>
                    <p>Considerando que não será possível separar todas as turmas que possuem alunos em comum em horários de forma que não gere conflitos, iremos buscar uma solução que minimize a quantidade de provas de segunda chamada, ou seja, a número de alunos prejudicados.</p>
                    <p>Para sabermos quantos alunos estarão sendo prejudicados precisaremos incluir mais uma etapa em nossa modelagem.</p>
                    <p>Iremos atribuir às arestas do grafo um peso, correspondente a quantidade de alunos que pertencem às duas turmas. Dessa forma teremos um <strong>Grafo Ponderado em Arestas</strong>.</p>
                    <p>Colorir o grafo agora consistirá em encontrar uma coloração não própria cuja soma dos pesos das arestas incidentes em vértices coloridos com mesma cor seja o menor possível. </p>
                    <p>Esse processo é chamado de Generalized Graph Coloring, onde efetuamos um tipo especial de coloração de modo a atingir algum objetivo pré-estabelecido.</p>
                </p>
                <p>
                    <br>
                    <h4 id="pdf-ggcp">Generalized Graph Coloring Problem?</h4>
                    <br>
                    <p>Definido por <a href="#ref-vredeveld02" style=" text-decoration: none;">Vredeveld (2002)</a>, o k-GGCP é um problema que consiste em um grafo G = (V, E), uma função de peso <i>z : E −> Z</i> nas arestas, e um número inteiro <i>k >= 2</i>.</p>
                    <p>Em que deseja-se encontrar uma atribuição de cores <i>c : V −> {1, ..., k}</i> dos vértices que minimize o peso total das arestas monocromáticas do grafo, isto é, arestas que incidem em vértices com mesma cor.</p>
                </p>
                <p>
                    <br>
                    <h4 id="pdf-resultado">Enfim o Resultado!</h4>
                    <br>
                    <p>Ao buscar a distribuição que cause o menor número de conflitos chegaremos à
coloração que será o resultado desejado para o problema. Assim como o obtido pelo robô no sistema.</p>
                </p>
    
                    <br>
                    <br>
        <h2 id="pdf-software">O Software de Agendamento de Horários de Prova</h2>
                    <br>
        <p>
         Este sistema foi desenvolvido por <strong>Filipe Rodrigues Cardoso da Silva</strong>. A partir do ano de 2019, com objetivo de ser um protótipo funcional para o Trabalho de Conclusão de Curso de Análise de Sistemas Informatizados, intitulado de <strong><a href="#ref-silva20" style=" text-decoration: none;">"Utilizando Coloração de Grafos de Interseção para Resolver o Problema de Programação de Horários de Exames Universitários"</a></strong>  vinculado a Faculdade de Educação Tecnológica do Estado do Rio de Janeiro - FAETERJ-Rio.
        </p>
        <p>
         O Agendador tem como finalidade criar horários de provas universitárias de forma que o menor número possível de alunos tenham que realizar provas de segunda chamada, em decorrência de ter duas ou mais provas de diferentes turmas num mesmo horário.
        </p>
        <p>
        O sistema foi desenvolvido usando MariaDB para o banco de dados, PHP no backend e HTML, CSS e JavaScript no frontend. Utilizando o framework Bootstrap para criar uma interface mais coesa e simples, e a biblioteca Cytoscape.js para possibilitar gerar grafos interativos.
        </p>
        <p>
        Todo o código do sistema, a integra do trabalho escrito e os slides da apresentação podem ser obtidos através do repositório oficial do trabalho no Github: <a href="https://github.com/FilipeRodrigues3003/TCC">https://github.com/FilipeRodrigues3003/TCC</a>.
        </p>
        <br><br><div class="nova-pagina"></div>
        <h2>REFERÊNCIAS</h2><br>
       <p id="ref-goldbarg12">GOLDBARG, Marco Cesar; GOLDBARG, Elizabeth Ferreira Gouvêa. <strong>Grafos: Conceitos, algoritmos e aplicações.</strong> [S.l.]: Elsevier Editora Ltda, 2012. v. 1.</p> 
       <p id="ref-pinto18">PINTO, José Wilson Coura. <strong>Grafos ORTH[h, s, t]</strong>. 2018. Tese (Tese (Doutorado)) — UFRJ/COPPE, 2018.</p> 
       <p id="ref-szwarcifter86">SZWARCIFTER, Jayme Luiz. <strong>Grafos e Algoritmos Computacionais</strong>. 2. ed. [S.l.]: Campus, 1986. 35-42, 169-195 p.</p> 
       <p id="ref-vredeveld02">VREDEVELD, Tjark. <strong>Combinatorial Approximation Algorithms: Guaranteed versus experimental performance.</strong> 2002. Tese (PhD) — Technische Universiteit Eindhoven, 2002.</p> 
       <p id="ref-silva20">SILVA, Filipe Rodrigues Cardoso da. <strong>Utilizando Coloração de Grafos de Interseção para Resolver o Problema de Programação de Horários de Exames Universitários</strong>. 2020. (Trabalho de Conclusão de Curso - TCC) - Faculdade de Educação Tecnológica do Estado do Rio de Janeiro - FAETERJ-Rio, 2020.</p> 
    </div>
    
    <script type="text/javascript" src="src/jquery.js"></script>
   	<script type="text/javascript" src="src/popper.js"></script>
   	<script type="text/javascript" src="src/bootstrap.js"></script>
   	<script type="text/javascript" src="src/cytoscape.js"></script>
    
    <script>
        var turmas = [ <?php
            for ($i = 0; $i < count($cursos); $i++) {
                echo("'".$cursos[$i].
                    "'");
                if ($i < count($cursos) - 1) {
                    echo(", ");
                }
            } ?>
        ];
        var arestas = [ <?php
        	$pri = 0;
            for ($i = 0; $i < count($cursos) - 1; $i++) {
                for ($j = $i + 1; $j < count($cursos); $j++) {
                    if ($matrix[$i][$j] != 0) {
                    	if($pri > 0){
                    		echo(",");
                    	}else{
                    		$pri++;
                    	}
                    	
                        echo("'".$cursos[$i].
                            "-".$cursos[$j].
                            "'");
                       
                    }
                }
            } ?>
        ];
        var cy = cytoscape({

            container: document.getElementById('graph-container'), 

            elements: [
                <?php
                
                for($i = 0; $i < count($cursos); $i++) {
                    echo("{ data: { id: '".$cursos[$i].
                        "', color: '".$cores_t[$cursos[$i]].
                        "'} }");
                    if($i<count($cursos)-1){
                    	echo(",");
                    }
                }
                for ($i = 0; $i < count($cursos) - 1; $i++) {
                    for ($j = $i + 1; $j < count($cursos); $j++) {
                    
                        if ($matrix[$i][$j] != 0) {
		                    
				            	
				          	$p = '';  
                            $cor = '#BDBDBD';
                            if ($cores_t[$cursos[$i]] == $cores_t[$cursos[$j]]) {
                                $cor = $cores_t[$cursos[$i]];
                                $p = $matrix[$i][$j];
                            }
                            echo(",{ data: { id: '".$cursos[$i].
                                "-".$cursos[$j].
                                "', source: '".$cursos[$i].
                                "', target: '".$cursos[$j].
                                "', color: '".$cor.
                                "', label: '".$p.
                                "'} }");
                           
                        }
                    }
                }

                ?>

            ],

            style: [ 
                {
                    selector: 'node',
                    style: {
                        'background-color': 'data(color)', 
                        'label': 'data(id)'
                    }
                },

                {
                    selector: 'edge',
                    style: {
                        'width': 3,
                        'line-color': 'data(color)', 
                        'target-arrow-color': '#ccc',
                        'target-arrow-shape': 'triangle',
                        'label': 'data(label)'
                    }
                }
            ],

            layout: {
                name: 'circle',
                animate: true,
                animationDuration: 2000,
                animationEasing: 'ease-out-quart',
                avoidOverlap: true,
                padding: 30,
             
            },

            maxZoom: 1.8,
            minZoom: 0.8,
            selectionType: 'additive',
        });
        cy.on('click', 'node', function(evt) {
            var element = document.getElementById(this.id());
            if (!element.classList.contains("d-none")) {
                element.classList.add("d-none");
            } else {
                for (var i = 0; i < turmas.length; i++) {
                    var e = document.getElementById(turmas[i]);
                    e.classList.add("d-none");
                }
                for (var i = 0; i < arestas.length; i++) {
                    var e = document.getElementById(arestas[i]);
                    e.classList.add("d-none");
                }
                element.classList.remove("d-none");
                document.getElementById("tabelas").scrollTop = 0;

            }
        });

        cy.on('click', 'edge', function(evt) {
            var element = document.getElementById(this.id());
            if (!element.classList.contains("d-none")) {
                element.classList.add("d-none");
            } else {
                for (var i = 0; i < turmas.length; i++) {
                    var e = document.getElementById(turmas[i]);
                    e.classList.add("d-none");
                }
                for (var i = 0; i < arestas.length; i++) {
                    var e = document.getElementById(arestas[i]);
                    e.classList.add("d-none");
                }
                element.classList.remove("d-none");
                document.getElementById("tabelas").scrollTop = 0;

            }
        });
       
        var element; 
        <?php
		    for ($i = 0; $i < count($cursos) - 1; $i++) {
		        for ($j = $i + 1; $j < count($cursos); $j++) {
		            if ($cores_t[$cursos[$i]] == $cores_t[$cursos[$j]]) {
		                echo(' element = document.getElementById("'.$cursos[$i].
		                    '-'.$cursos[$j].
		                    '");
		                    if (element) {
		                        element.classList.add("d-print-table");
		                        element.classList.remove("d-print-none");
		                    }
		                    ');
		                }
		            }
		        } 
		   ?>
    </script>
    <br><br><br>
    
    <?php 
      if($corMin[count($cursos)]>0){
    echo('
    <div class=" tempo d-none d-print-none alert alert-primary text-center" id="use-robo" style="padding-bottom: 10%;">
        <form action="resultado.php?r='.md5('best').'&q='.$_GET['q'].'" method="POST">
            <label for="tempo">
                <h3>Deseja tentar encontrar um resultado melhor usando nosso robô?</h3>
            </label>
            <div class="input-group  mb-5" style=" width:180px; box-align:center; text-align:center;  position:relative; left:50%; transform: translateX(-50%);">');
            
                echo ('<input class="d-none" id="graph" name="graph" value="' . $_POST["graph"] . '">');
                echo ('<input class="d-none" id="infos" name="infos" value="' . $_POST["infos"] . '">');
                echo ('<input class="d-none" id="k" name="k" value="' . $_POST["k"] . '">');
                
            echo(' </div>
            <button class="btn btn-light bot" data-animation="true" data-placement="right" data-toggle="tooltip" title="Clique em mim para encontrar a melhor solução!" style="left: 50%; width: 100px; height: 100px; bottom: 0%;"><img src="img/robotic.svg" width="60px" heigth="60px"></button>
        </form>
    </div> ');
    }
    ?>
    <footer id="footer test">
		<nav class="navbar navbar-dark bg-dark">
			
			<a class="navbar-brand">
			    <button class="btn btn-primary" onclick="print();">
			       <i class="material-icons">picture_as_pdf</i>
					Imprimir Relatório
			        
			    </button>
			</a>
			<span class="navbar-text navbar-text-custom">
			    Gerencie suas turmas: importar, editar, visualizar e apagar.
			</span>
			<button class="navbar-toggler drag-sm btn-sm border-dark bg-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="material-icons text-dark ">menu</i>
               </button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav mr-auto">
			   		 <li class="nav-item active">
						<a class="navbar-brand">
							<button class="btn btn-dark" onclick="alocar('<?php echo($_GET['q']); ?>');">
								<i class="material-icons">
									bubble_chart
								</i>
								Voltar para <?php echo(workspace_name(base64_decode($_GET["q"]))); ?>
							</button>
						</a>
					</li>
			   		 
			   		 
			   		 
					<li class="nav-item active">
						<a class="navbar-brand">
							<button class="btn btn-dark" onclick="home('<?php echo($_GET['q']); ?>');">
								<i class="material-icons">
									settings
								</i>
								Definições
							</button>
						</a>
					</li>
			        <li class="nav-item active">
			            <a class="nav-link" href="#" >
			                <button class="btn btn-dark" onclick="gerenciar('<?php echo($_GET['q']); ?>');">
			                    <i class="material-icons">
			                        school
			                    </i>
			                    <b>Gerenciar Turmas</b> <span class="sr-only">(current)</span>
			                </button>
			            </a>
			        </li>
			        <li class="nav-item dropdown">

			            <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			                <button class="btn btn-dark dropdown-toggle">
			                    <i class="material-icons">
			                        group_add
			                    </i>
			                    <b>Adicionar...</b>
			                </button>
			            </a>
			            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			                <a class="dropdown-item btn-light" href="#" onclick="criar();">
			                    <button class="btn ">
			                        <i class="material-icons">keyboard</i>
			                        Adicionar Turma Manualmente
			                    </button>
			                </a>
			                <a class="dropdown-item btn-light" href="#" onclick="importar();">
			                    <button class="btn ">
			                        <i class="material-icons">cloud_upload</i>
			                        Importar Turmas de Planilha <span class="nowrap badge badge-success badge-pill">XLSX</span>
			                    </button>
			                </a>
			            </div>
			        </li>
			        
			         <li class="nav-item dropdown">

                            <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <button class="btn btn-dark dropdown-toggle">
                                    <i class="material-icons">
                                        save
                                    </i>
                                    <b>Exportar...</b>
                                </button>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item btn-light" href="#" onclick="export_planilha('workspace');">
                                    <button class="btn nowrap">
                                        <i class="material-icons">cloud_download</i>
                                        Salvar Todas as Turmas de <?php echo(workspace_name(base64_decode($_GET["q"]))); ?> em Planilha <span class="nowrap badge badge-success badge-pill">XLSX</span>
                                    </button>
                                </a>
                                <a class="dropdown-item btn-light" href="#" onclick="save_some();">
                                    <button class="btn nowrap">
                                        <i class="material-icons">library_books</i>
                                        Selecionar Turmas de <?php echo(workspace_name(base64_decode($_GET["q"]))); ?> para salvar em Planilha <span class="nowrap badge badge-success badge-pill">XLSX</span>
                                    </button>
                                </a>
                            </div>
                        </li>
                        
			        
			        <li class="nav-item">
			            <a class="nav-link" href="#">
			                <button class="btn btn-dark" onclick="sobre_robo();">
			                    <i class="material-icons">
			                        help
			                    </i>
			                    <b>Robô</b>
			                </button>
			            </a>
			        </li>
			        
			    </ul>
			</div>

		</nav>
	</footer>
	
	
    
    <?php if($q != md5('best')){ echo ('<script>document.getElementById("div-tempo").classList.add("d-none");</script>'); }?>
    <?php if($q != md5('best')){ echo ('<script>document.getElementById("use-robo").classList.remove("d-none");</script>'); }?>
   	<script>
        var resp = <?php echo($GLOBALS['testable']) ?> ;

        if (resp == '-1') {
            var e = document.getElementById("div-tempo");
            e.classList.add("d-none");
        }
    </script>
    	<script type="text/javascript" src="JS/route.js"></script>
    	<div id="areamodal1"></div>
		<div id="areamodal2"></div>
		<div id="areamodal3"></div>
		<div id="areamodal4"></div>
		<script type="text/javascript" src="JS/modals.js"></script>
		
     
</body>

</html>
