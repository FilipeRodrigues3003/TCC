<!doctype html>
<html lang="pt-br">

<head>
    <title>Exibir Turma</title>
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
		identidade(workspace_name(base64_decode($_GET['q'])));
        
       ?>
       
       <nav class="navbar  navbar-expand-sm navbar-dark bg-dark">
		
	  	<a class="navbar-brand" href="#">	
	  		<button class="btn btn-dark btn-lg" disabled>
		    		<i class="material-icons">school</i>
				Visualizar Alunos
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

    <div class="container btn-group-vertical" style="top: -1; left: 50%;
    margin-right: -50%;
    transform: translate(-50%, 0%);">


       
	
	<?php
		
        $turma = $_GET["turma"];
        echo ('<br><br><div class="card text-dark bg-white border-0"  style="width:100%;"><div class="text-center card-header  display-4">Turma ' . $turma . '</div>');
    	 echo (' <div class="control-group input-group" style="margin-top:10px">
    	 <div class="input-group-prepend "> <span class="input-group-text bg-secundary text-muted " id="basic-addon1">##</span> </div>
               <input type="text" name="aluno[]" class="form-control bg-secundary col-3 border-right-0" value="Matricula" onclick="alert();" disabled readonly> <input type="text" name="aluno[]" class="form-control bg-secundary border-left-0" value="Nome" disabled readonly></div>');
        
        $alunos = alunos_from_turma(id_from_nome_turma($turma, base64_decode($_GET['q']), $_SESSION['usuario']));
        $i = 1;
        foreach ($alunos as $row) {
        	$nome = $row[0];
            $matricula = $row[1];
            echo (' <div class="control-group input-group" style="margin-top:10px">
                        <div class="input-group-prepend ">
                            <span class="input-group-text bg-secundary text-muted" id="basic-addon1">' . sprintf("%02d", $i) . '</span>
                        </div>
                        <input type="text" name="aluno[]" class="form-control bg-light col-3 border-right-0" value="' . $matricula . '" disabled readonly>
                        <input type="text" name="aluno[]" class="form-control bg-light border-left-0" value="' . $nome . '" disabled readonly>
                 </div>  
                    ');
            $i++;
        }
        echo('</div>');
        ?>



        <div class="btn-group" style="margin-top: 5%;">
            <button class="btn btn-success" type="button" onclick="gerenciar('<?php echo($_GET['q']); ?>');"><i class="material-icons">arrow_back</i>
                Voltar</button>
            <button class="btn btn-info" type="button" id="<?php echo ($turma); ?>" onclick="editar(id, '<?php echo($_GET['q']); ?>');"><i class="material-icons">create</i>
                Editar
                <?php echo ($turma); ?></button>

        </div>
    </div>


   <footer id="footer">
		<nav class="navbar navbar-dark bg-dark">
		
			<a class="navbar-brand">
			    
			</a>
			
			
              <ol class="breadcrumb bg-dark" style="margin-bottom: -5px;">
                <li class="breadcrumb-item"><a class="text-reset" href="#" onclick="home('<?php echo($_GET['q']); ?>');">Definições</a></li>
                <li class="breadcrumb-item"><a class="text-reset" href="#" onclick="gerenciar('<?php echo($_GET['q']); ?>');">Gerenciar Turmas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Exibir Alunos</li>
              </ol>
           
			  <!--<span class="navbar-text navbar-text-custom">  Alunos de <?php echo($turma); ?> </span>-->
			
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
   	<script type="text/javascript" src="JS/route.js"></script>
   	<div id="areamodal1"></div>
		<div id="areamodal2"></div>
		<div id="areamodal3"></div>
		<div id="areamodal4"></div>
		<script type="text/javascript" src="JS/modals.js"></script>
</body>

</html>
