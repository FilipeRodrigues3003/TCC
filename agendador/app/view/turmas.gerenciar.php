<!doctype html>
<html lang="pt-br">

<head>
    <title>Alocar Turmas em Horários de Prova</title>
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

<body>



    <?php
   		include '../model/conection.php';
		include '../controller/ini_session.php';
		
		user_identidade();
		if(isset($_GET['q']) && $_SESSION["workspace"] == ""){
			$_SESSION["workspace"] = workspace_name(base64_decode($_GET['q']));
		}else{
		     identidade(workspace_name(base64_decode($_GET['q'])));
		}
	
		
	?>
	<nav class="navbar  navbar-expand-sm navbar-dark bg-dark">
		
	  	<a class="navbar-brand" href="#">	
	  		<button class="btn btn-dark btn-lg" disabled>
		    		<i class="material-icons">school</i>
				Gerenciar Turmas
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
		
 	<div class="card-deck ">
   		<div class="card bg-info text-light">
        	<div class="capa" alt="Imagem de capa do card">
        		<div class="card-icon">
                    <img src="img/school.svg" width="90px" heigth="90px">
                </div>
            </div>
            <div class="card-body ">
                <h5 class="card-title text-center"> <i class="material-icons" style="transform: translate(0%, 12%);">group</i> Adicionar Turma</h5>
                <p class="card-text">

                </p>
                <div class="btn-group " role="group" aria-label="Button group with nested dropdown">
                    <button id="add" type="button" class="btn btn-primary drag" onclick="criar('<?php echo($_GET["q"]); ?>');">
                        <i class="material-icons"  style="transform: translate(0%, -12%);">add</i> Adicionar
                    </button>
                    <button id="import" type="button" class="btn btn-success drag" onclick="importar('<?php echo($_GET["q"]); ?>');">
                        <i class="material-icons"  style="transform: translate(0%, -12%);">cloud_upload</i>  Importar
                    </button>
                </div>
                </div>
                <div class="card-footer ">
                    <small class="">Adicione Manualmente ou Importe Turmas para <?php echo($_SESSION['workspace']); ?> </small>
                </div>
            </div>
           	<?php
           		$turmas = nome_turmas_from_workspace( id_from_nome_workspace($_SESSION['workspace'], $_SESSION['usuario'] ) );
				if($turmas[0]!=''){
				foreach($turmas as $row) {
            
					echo ('<div class="card ">
						        <div class="capa" alt="Imagem de capa do card">
						            <div class="card-icon">
						                <img src="img/school.svg" width="90px" heigth="90px">
						            </div>
						        </div>
						        <div class="card-body ">
						            <h5 class="card-title ">' . $row . '</h5>
						            <p class="card-text">

						            </p>
						            <div class="btn-group " role="group" aria-label="Button group with nested dropdown">
						                <button id="' . $row . '" type="button" class="btn btn-dark drag" onclick="ver(id, \''. $_GET["q"] .'\');">
						                    <i class="material-icons"  style="transform: translate(0%, -12%);">pageview</i> Visualizar
						                </button>
						                <button id="' . $row . '" type="button" class="btn btn-dark drag" onclick="editar(id, \''. $_GET["q"] .'\');">
						                    <i class="material-icons" style="transform: translate(0%, -12%);">edit</i> Editar
						                </button>
						                <button id="' . $row . '" type="button" class="btn btn-danger drag btn-confirm" onclick="exclui(event, \''. $_GET["q"] .'\')">
						                    <i class="material-icons" style="transform: translate(0%, -12%);">delete_forever</i> Apagar
						                </button></div>
						        </div>
						        <div class="card-footer">
						            <small class="text-muted">Pertencente à '.$_SESSION['workspace'].'</small>
						        </div>
						    </div>');


				}}
    			echo ('</div>');
    
    		?>


		<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
			<div class="modal-dialog modal-sm">
			    <div class="modal-content ">
			        <div style="text-align: center;">
			            <div class="modal-header">
			              
			                <h5 class="modal-title" id="myModalLabel">
			                    <div class=" btn-warning">
			                        <i class="material-icons" style="transform: translate(25%,25%); margin-right: 15px;">
			                            report_problem
			                        </i> Atenção</div><br>
			                    Deseja remover permanentemente essa turma do sistema?
			                </h5>

			            </div>

			            <div class="modal-footer">

			                <button type="button" class="btn btn-danger" id="modal-btn-si">
			                    <i class="material-icons">delete_outline</i>
			                    Sim
			                </button>
			                <button type="button" class="btn btn-light" id="modal-btn-no" autofocus>
			                    <i class="material-icons">cancel</i>
			                    Não
			                </button>
			            </div>
			        </div>
			    </div>
			</div>
		</div>

		<div class="alert" role="alert" id="result"></div>


	<footer id="footer">
		<nav class="navbar navbar-dark bg-dark">
			<a class="navbar-brand">
			    <button class="btn btn-primary" onclick="alocar('<?php echo($_GET['q']); ?>');">
			        <i class="material-icons">
			            bubble_chart
			        </i>
			        Criar Tabela de Horários de Prova
			    </button>
			</a>
			<ol class="breadcrumb bg-dark" style="margin-bottom: -5px;">
                <li class="breadcrumb-item"><a class="text-reset" href="#" onclick="home('<?php echo($_GET['q']); ?>');">Definições</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gerenciar Turmas</li>
              </ol>
			<button class="navbar-toggler drag-sm btn-sm border-dark bg-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="material-icons text-dark ">menu</i>
               </button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav mr-auto">
			   		 
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
			                <button class="btn btn-dark" disabled>
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
                                <a class="dropdown-item btn-light" href="#" onclick="export_planilha('<?php echo($_GET['q']); ?>');">
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

    <script type="text/javascript" src="src/jquery.js"></script>
   	<script type="text/javascript" src="src/popper.js"></script>
   	<script type="text/javascript" src="src/bootstrap.js"></script>
   	<script type="text/javascript" src="JS/turmas.js"></script>
    <script type="text/javascript" src="JS/route.js"></script>
       <div id="areamodal1"></div>
		<div id="areamodal2"></div>
		<div id="areamodal3"></div>
		<div id="areamodal4"></div>
		<script type="text/javascript" src="JS/modals.js"></script>
</body>

</html>
