<!doctype html>
<html lang="pt-br">

<head>
    <title>Adicionar Nova Turma</title>
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
		identidade(workspace_name(base64_decode($_GET['q'])));
    	?>
    	
    	
    	<nav class="navbar  navbar-expand-sm navbar-dark bg-dark">
		
	  	<a class="navbar-brand" href="#">	
	  		<button class="btn btn-dark btn-lg" disabled>
		    		<i class="material-icons">school</i>
				Cadastrar Turma
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
    	
    	
    	
    <div class="container">
        <div class="panel panel-default">
            <br><br>
            <div class="panel-body">
                <form action="../controller/add.php" method="POST">
                    <label for="turma"> Informe o nome da Turma </label>
                    <input type="text" id="turma" name="turma" class="form-control" placeholder="" style="width: 80%;" autofocus require><br>
                    <div>
                        <div class="control-group input-group" style="margin-top:10px">
                            <div class="input-group-prepend "> <span class="input-group-text bg-secundary text-muted " id="addon1">#</span> </div>
                            <input type="text" name="aluno[]" class="form-control input-aluno bg-secundary col-4 border-right-0" value="Matricula" onclick="alert();" disabled readonly> <input type="text" name="aluno[]" class="form-control  input-aluno bg-secundary  border-left-0" value="Nome" disabled readonly>
                            <div class="input-group-append">
                                <button class="btn btn-dark text-dark remove" type="button" disabled>
                                    <i class="material-icons">clear</i>
                                    Remover</button>
                            </div>

                        </div>
                       </div>
                    <!-- Copy Fields -->
                    <script> var i = 1; function num(i){ $("#basic-addon1").html(i++); return i; }  </script>
                    <div class=" copy d-none">
                        <div class="control-group input-group" style="margin-top:10px">
                            <div class="input-group-prepend "> <span class="input-group-text bg-secundary text-muted " id="basic-addon1"></span> </div>
                            <input type="text" name="aluno_mat[]" class="form-control input-aluno col-4" placeholder="" require>
                            <input type="text" name="aluno_nome[]" class="form-control input-aluno" placeholder="" require>
                            <div class="input-group-append">
                                <button class="btn btn-danger remove" type="button">
                                    <i class="material-icons">clear</i>
                                    Remover</button>
                            </div>

                        </div>
                    </div>

                    <form action="../controller/action.php">
                        <div class="input-group control-group after-add-more d-block">
                            <hr>
                            <div>
                                <button class="btn btn-success d-block add-more btn-cad" type="button" onclick="i = num(i);">
                                    <i class="material-icons">group_add</i>
                                    Adicionar Aluno
                                </button>
                                
                            </div>
                        </div>
                    </form>
                
            </div>
        </div>
    </div>

     <footer id="footer">
		<nav class="navbar navbar-dark bg-dark">
			<a class="navbar-brand">
			<div class="input-group-btn btn-group">
			    
                 <button type="submit" class="btn btn-primary  btn-cad " name="envia">
                     <i class="material-icons">check_circle_outline</i> Criar Turma
                 </button>
                 <button class="btn btn-light " type="button" onclick="gerenciar('<?php echo($_GET['q']); ?>');"> <i class="material-icons">cancel</i><span> Cancelar<span></button>
            </div>
			</a>
			</form>
			<ol class="breadcrumb bg-dark" style="margin-bottom: -5px;">
                <li class="breadcrumb-item"><a class="text-reset" href="#" onclick="home('<?php echo($_GET['q']); ?>');">Definições</a></li>
                <li class="breadcrumb-item"><a class="text-reset" href="#" onclick="gerenciar('<?php echo($_GET['q']); ?>');">Gerenciar Turmas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Adicionar Turma Manualmente</li>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $(".add-more").click(function() {
                var html = $(".copy").html();
                $(".after-add-more").before(html);
            });
            $("body").on("click", ".remove", function() {
                $(this).parents(".control-group").remove();
            });
        });
    </script>
    <div id="areamodal1"></div>
		<div id="areamodal2"></div>
		<div id="areamodal3"></div>
		<div id="areamodal4"></div>
		<script type="text/javascript" src="JS/modals.js"></script>
</body>

</html>