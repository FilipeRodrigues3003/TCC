<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Criar Tabela de Horários de Prova</title>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type" />
		<meta name="viewport" content="width=1024" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="src/bootstrap.min.css" />
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="src/roboto.css" />
        <link rel="stylesheet" href="src/icon.css" />
        <link rel="stylesheet" href="style/main.css" />
		<link rel="stylesheet" href="style/tests.css" />
</head>

<body class="horizontal-no-roll">
    <script>
        document.cookie = "temp_user=1; expires=Session; path=/";

        function result(valor) {
            if (valor == '1') {
                $('#idFormulario').attr('action', 'resultado.php?r=<?php echo(md5('best')); ?>&q=<?php echo($_GET['q']); ?> ');
            } else {
                $('#idFormulario').attr('action', 'resultado.php?r=<?php echo(md5('normal')); ?>&q=<?php echo($_GET['q']); ?>');
            }
        }
    </script>

    <script>
        function plus(qtd) {
            var q = (parseInt(qtd) >= 30) ? 30 : parseInt(qtd) + 1;
            window.location.href  = "workspace.php?q= <?php echo($_GET['q']); ?> &horarios=" + q;
        }

        function minus(qtd) {
            var q = (parseInt(qtd) <= 2) ? 2 : parseInt(qtd) - 1;
            window.location.href  = "workspace.php?q= <?php echo($_GET['q']); ?> &horarios=" + q;
        }
    </script>
    <div class="row justify-content-center ant-circulo">
		<div class="d-none  card sticky-top alert alert-dismissible fade show" role="alert" id="circulo">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			 </button>
		    <div class="card-body text-center">
		    
		        <div class="col-12 card-title" data-animation="true" data-placement="left" data-toggle="tooltip" title="Quantidade de Provas de Segunda Chamada!">
		            <input name="inters-s" id="inters-s" class="inters-s " readonly>
		            <p id="i-s" >provas de segunda chamada!</p>
		            
		        </div>
		        <div class=" card-footer col-12 " id="semi-circulo" data-animation="true" data-placement="left" data-toggle="tooltip" title="Índice de Qualidade da Solução!">
		            <input name="inters-t" id="inters-t" class="inters-t" readonly>
		            
		            <p id="i-t">Conflitos Possíveis / Solução Atual * 100.</p>
		            
		        </div>
		    </div>
		</div>
    </div>
    <i id="icon" class="material-icons" style="font-size:20px;color:#FFF;">none</i>
   
    <div class="header" id="titulo-turma">TURMAS
      
    </div>
   
    <div class="boxA" id="turmas" ondrop="return dragDrop(event)" ondragover="return dragOver(event)" data-placement="right" data-toggle="tooltip" title="">
        
        <?php
		include '../model/conection.php';
		include '../controller/ini_session.php';
		
		identidade(workspace_name(base64_decode($_GET['q'])));
		
        $u = $_SESSION['usuario']; 
        $workspace = base64_decode($_GET['q']); 
        try {
            readDB($workspace, $u); 
        } catch (\Throwable $th) {
            throw $th;
        }


        ?> </div>
    <div class="container-h">
        <div class="header" id="titulo-horarios">HORÁRIOS PARA PROVA <br>

            <div class="btn-group btn-group-sm btn-block" style="width: 250px;">
                <?php
                $horarios = (empty($_GET["horarios"])) ? 2 : $_GET["horarios"];
                $horarios = ($horarios >= 30) ? 30 : $horarios;
                $horarios = ($horarios <= 2) ? 2 : $horarios;
                $sit_m = ($horarios == 2) ? 'disabled' : '';
                $sit_p = ($horarios == 30) ? 'disabled' : '';
                echo ('<button id="' . $horarios . '" type="button"
                class="btn btn-danger" onclick="minus(id);" ' . $sit_m . '>
                <i class="material-icons">remove</i>
            </button>');

                echo ('<button id="' . $horarios . '" type="button"
                class="btn btn-success" onclick="plus(id);" ' . $sit_p . '>
                <i class="material-icons">add</i>
            </button>');
                ?></div>
            <div class="circulo-hora" style="border: 3px solid #424242; color: #424242; transform: translate(70%, 10%); text-align: center; vertical-align: center; padding-top: 10px;"> <?php echo($horarios); ?></div>
        </div> <br><br><br>
        <?php
         
        $cores = [
            '#F44336', '#2196F3', '#4CAF50', '#FFEB3B', '#9C27B0', '#3E2723', '#E91E63', '#01579B', '#B71C1C', '#CDDC39',
            '#00E5FF', '#8BC34A', '#FF9800', '#673AB7', '#009688', '#FFC107', '#FF5722', '#2962FF', '#1B5E20', '#AA00FF',
            '#76FF03', '#BF360C', '#F48FB1', '#E6EE9C', '#9FA8DA', '#33691E', '#FFCC80', '#80CBC4', '#000000', '#FFFF00'
        ];  
        for ($i = 1; $i <= $horarios; $i++) {
            echo ('<div class="boxB" id="horario' . $i . '" ondrop="return dragDrop(event)" ondragover="return dragOver(event)" style="background-color: ' . $cores[($i - 1)] . ';"><div class="circulo-hora" style="border: 3px solid ' . $cores[($i - 1)] . '; color: ' . $cores[($i - 1)] . ';">' . $i . '</div></div>');
        }
        ?>
    </div>

    <div id="graph-container" class="" style="text-align: left; margin-top:190px; left: 50%;  width: 500px; height: 380px; z-index: 0; position: fixed;"></div>


    <form id="idFormulario" method="POST">

        <footer id="footer " ondragover="dragOver(event)">
            <div class="progress">
                <div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="">
                </div>
            </div>

            <button class="btn btn-light alert-dark text-muted bot" data-animation="true" data-placement="bottom" data-toggle="tooltip" title="Clique em mim para encontrar a melhor solução!" onclick="result(1);" type="submit" name="envia" style="position: fixed; transform: translate(500px,-135px); z-index: 5;"><img src="img/robotic.svg" width="40px" heigth="40px" style="transform: translate(-8%,0);"></button>
            <input id="graph" class="d-none" name="graph" required>
            <input id="infos" class="d-none" name="infos">
            <input id="k" class="d-none" name="k" value="<?php echo ($horarios); ?>">
            <nav class="navbar navbar-dark bg-dark ">
                <a class="navbar-brand">
                    <button class="btn btn-primary " onclick="result(resultado);" type="submit" name="envia">
                        <i class="material-icons">
                            insert_chart_outlined
                        </i>
                       Gerar Relatório
                    </button>
                </a>
                <span class="navbar-text navbar-text-custom">
                    Mova as turmas para os horários!
                </span>
                <button class="navbar-toggler drag-sm btn-sm border-dark bg-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="material-icons text-dark ">menu</i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    		<li class="nav-item active">
							<a class="navbar-brand">
								<button class="btn btn-dark" disabled>
									<i class="material-icons">
										bubble_chart
									</i>
									<?php echo(workspace_name(base64_decode($_GET["q"]))); ?>
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
					        <a class="nav-link" href="#" onclick="gerenciar('<?php echo($_GET['q']); ?>');" >
					            <button class="btn btn-dark">
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
					            <a class="dropdown-item btn-light" href="#" onclick="criar('<?php echo($_GET['q']); ?>');">
					                <button class="btn ">
					                    <i class="material-icons">keyboard</i>
					                    Adicionar Turma Manualmente
					                </button>
					            </a>
					            <a class="dropdown-item btn-light" href="#" onclick="importar('<?php echo($_GET['q']); ?>');">
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
		                            <a class="dropdown-item btn-light" href="#" onclick="export_planilha(<?php echo($_GET['q']); ?>);">
		                                <button class="btn nowrap">
		                                    <i class="material-icons">cloud_download</i>
		                                    Salvar Todas as Turmas de <?php echo(workspace_name(base64_decode($_GET["q"]))); ?> em Planilha <span class="nowrap badge badge-success badge-pill">XLSX</span>
		                                </button>
		                            </a>
		                            <a class="dropdown-item btn-light" href="#" onclick="save_some('<?php echo($_GET['q']); ?>');">
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
    </form>

   	<script type="text/javascript" src="src/jquery.js"></script>
   	<script type="text/javascript" src="src/popper.js"></script>
   	<script type="text/javascript" src="src/bootstrap.js"></script>
   	<script type="text/javascript" src="src/cytoscape.js"></script>
    <script>
        var cy = cytoscape({
            container: document.getElementById("graph-container"),  

            style: [
            
                {
                    selector: 'node',
                    style: {
                        'background-color': 'data(color)',  
                        label: 'data(id)'
                    }
                },

                {
                    selector: 'edge',
                    style: {
                        width: 3,
                        'line-color': 'data(color)',  
                        'target-arrow-color': '#ccc',
                        'target-arrow-shape': 'triangle',
                        label: 'data(label)'
                    }
                }
            ],

            maxZoom: 1.5,
            minZoom: 0.9
        });
    </script>
  

    <script type="text/javascript" src="JS/aloc.js"></script>
    <script type="text/javascript" src="JS/route.js"></script>
    <script type="text/javascript" src="JS/grab.js"></script>
    <div id="areamodal4"></div>
	<script type="text/javascript" src="JS/modals.js"></script>
</body>

</html>
