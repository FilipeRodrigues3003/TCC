<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Dashboard - Controle seus Espaços de Trabalho</title>
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
			
			$_SESSION["workspace"] = '';
			
			$data = null;
			
			$data = dashboard_load($_SESSION['usuario']);
			
			if(isset($_GET['err'])){
				
				$mesage = base64_decode($_GET['err']);
				
				echo('	<div class="fixed-top alert alert-danger alert-dismissible fade show" role="alert">
							<button class="btn btn-danger " disabled>
						  		<i class="material-icons">
									error_outline
								</i> 
							</button> 
							'. $mesage .'
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						  </button>
						</div>
				');
			}
		?>

	<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
		
	  	<a class="navbar-brand" href="#">	
	  		<button class="btn btn-dark btn-lg" disabled>
		    		   <i class="material-icons">bookmarks</i>
                   Dashboard
    			</button>
		</a>
 
	  	<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
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
		  		<!--<li class="nav-item">
		   			<a class="nav-link" href="#">
		   				<button class="btn btn-dark btn-sm"  data-toggle="tooltip" data-html="true" title="<?php echo($_SESSION['usuario']); ?>">
			   				<i class="material-icons">account_box</i>
			   				<?php echo(nome_from_login($_SESSION['usuario'])); ?>
		   				</button>
		   			</a>
		  		</li>-->
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
	
	
	
	
	<div class="alert alert-success alert-dismissible fade show" role="alert">
	  <strong>Bem-vindo ao Dashboard.</strong> Crie e acesse seus Espaços de Trabalhos aqui!
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	</div>
	
	
	<div class=" container-fluid row " style="width: 95%; margin: 0 auto; flex-direction: row; align-items: center; " >
	
	
	<div class="col-5 " style="margin: 20px; margin-left: 70px; height: 310px;">
			<div class="col-12  text-center card ">
				<div class="card-body">
					<h5 class="card-title  text-muted">Novo Espaço de trabalho</h5>
					<div class="btn-group " role="group" aria-label="Button group with nested dropdown">
						<button class="btn btn-primary drag drag-btn-primary btn-lg btn-cad bg-primary"><i class="material-icons">open_in_browser</i> Criar Espaço de Trabalho</button>
				     </div>
				</div>
				<div class="card-footer text-center">
					<small class=" text-muted">
						Um Espaço de Trabalho agrupa diferentes turmas, podendo representar uma instituição, um turno ou apenas limitar as turmas que se deseja alocar.
					</small>
				</div>
			</div>
			
		</div>
	
		
		
		
		<?php	
			foreach($data as $space){
				echo('	<div class="col-5 " style="margin: 20px;  margin-left: 70px; height: 310px;">
							<div class="col-12 text-center card">
								<div class="card-body">
									<h5 class="card-title  text-muted">Espaço de trabalho: '.$space['nome_workspace'].'</h5>
									<div class="btn-group " role="group" aria-label="Button group with nested dropdown">
										<button class="btn btn-success drag btn-sm bg-success border-success" onclick="home(\''.base64_encode($space['id_workspace']).'\');">
											<i class="material-icons">input</i>
											Acessar '.$space['nome_workspace'].'</button>
										 <button id="'.$space['nome_workspace'].'" type="button" class="btn btn-danger drag btn-sm btn-confirm-ws btn-confirm" onclick="ev_workspace(event, \''. $_SESSION['usuario'] .'\' )">
								                <i class="material-icons">delete_forever</i> Apagar
								         </button>
								         <button id="drop'.$space['nome_workspace'].'" type="button" class="btn btn-dark drag drag-sm btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								             
								         </button>
								         <div class="dropdown-menu" aria-labelledby="drop'.$space['nome_workspace'].'">
								         	<span class="dropdown-header text-center bg-dark"><button class="btn btn-dark btn-sm" disabled><i class="material-icons">settings</i> Definições</button></span>
											<a class="dropdown-item" href="#" onclick="gerenciar(\''.base64_encode($space['id_workspace']).'\');">Gerenciar Turmas</a>
											<a class="dropdown-item" href="#" onclick="importar(\''.base64_encode($space['id_workspace']).'\');">Importar <span class="nowrap badge badge-success badge-pill">XLSX</span></a>
											<a class="dropdown-item" href="#" onclick="exportar_planilha(\''.base64_encode($space['id_workspace']).'\');">Exportar <span class="nowrap badge badge-success badge-pill">XLSX</span></a>
										  </div>
								         
								     </div>
								</div>
								<div class="card-footer text-center">
									<small class=" text-muted">
										Criado '. data_workspace($space['nome_workspace'], $_SESSION['usuario']) .' 
			  						</small>
		  						</div>
							</div>
							
						</div>');
			}
		?>
			
		</div>
		
		
		
		
		
		
		
		
		
		<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="cad-modal">
			<div class="modal-dialog modal-sm">
			    <div class="modal-content ">
			        <div style="text-align: center;">
			            <div class="modal-header">
			                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
			                <h5 class="modal-title" id="myModalLabel">
			                    
			                    <form method="POST" action="../model/criar_workspace.php">
									<label for="nome">Criar Espaço de Trabalho</label> 
									<input class="form-control" placeholder="Nome espaço de trabalho" name="nome" id="nome"/><br>
												                    
			                </h5>

			            </div>

			            <div class="modal-footer">

			                <button type="submit" class="btn btn-success" id="modal-btn-si">
			                    <i class="material-icons">plus_one</i>
			                    Criar
			                </button>
			                </form>
			                <button type="button" class="btn btn-light" id="modal-btn-no" autofocus>
			                    <i class="material-icons">cancel</i>
			                    Cancelar
			                </button>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
		
		
		
		
		
		
		
		
		
		
		
		
		<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modalExcW">
			<div class="modal-dialog modal-sm">
			    <div class="modal-content ">
			        <div style="text-align: center;">
			            <div class="modal-header">
			                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
			                <h5 class="modal-title" id="myModalLabel">
			                    <div class=" btn-warning">
			                        <i class="material-icons" style="transform: translate(25%,25%); margin-right: 15px;">
			                            report_problem
			                        </i> Atenção</div><br>
			                    Deseja remover permanentemente esse espaço de trabalho do sistema?<br>
			                    <small class="text-muted">Confirmando você perderá os dados das turmas inseridas nesse espaço de trabalho.</small>
			                </h5>

			            </div>

			            <div class="modal-footer">
                           <!-- <form method="POST" > -->
                            
			                    <button type="button" class="btn btn-danger modal-btn-apaga" id="modal-btn-apaga">
			                        <i class="material-icons">delete_outline</i>
			                        Sim
			                    </button>
			                <!--</form>-->
			                <button type="button" class="btn btn-light modal-btn-cancela" id="modal-btn-cancela"  data-dismiss="modal" autofocus>
			                    <i class="material-icons">cancel</i>
			                    Não
			                </button>
			            </div>
			        </div>
			    </div>
			</div>
		</div>

		
		
		
		
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
