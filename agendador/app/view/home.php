<!doctype html>
<html lang="pt-br">

<head>
    <title>Definições do Espaço de Trabalho</title>
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
		if(isset($_GET['q'])){
			$_SESSION["workspace"] = workspace_name(base64_decode($_GET['q']));
		}
		?>
		
		
		
		
		<nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
		
	  	<a class="navbar-brand" href="#">	
	  		<button class="btn btn-dark btn-lg" disabled>
		    		<i class="material-icons">settings</i>
	    				Definições
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
		
		 <div id="graph-container" class="" style="text-align: left; margin-top:75px; left: 50%;  width: 99%; height: 275px; z-index: 0; position: fixed;"></div>
		<!--<img src="img/grafo-grande.png" width="30%" />-->
		
		
        <footer id="footer" >
            <nav class="navbar navbar-dark bg-dark ">
                   <?php echo(' <a class="navbar-link" href="#" onclick="alocar(\''. $_GET["q"] .'\');" > '); ?>
                   <button class="btn btn-primary">
                        <i class="material-icons">
                            bubble_chart
                        </i>
                        <b> Criar Tabela de Horários de Prova para <?php echo(workspace_name(base64_decode($_GET["q"]))); ?> </b>
                    </button>
                </a>
                <span class="navbar-text navbar-text-custom">
                  
                </span>
               

                <div class=" navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
							<a class="navbar-brand">
								<button class="btn btn-dark" disabled>
									<i class="material-icons">
										settings
									</i>
									Definições
								</button>
							</a>
						</li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="gerenciar('<?php echo($_GET['q']); ?>');">
                                <button class="btn btn-dark">
                                    <i class="material-icons">
                                        school
                                    </i>
                                    <b>Gerenciar Turmas</b>
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
    	<script type="text/javascript" src="src/cytoscape.js"></script>
    <script>
        var cy = cytoscape({
            container: document.getElementById("graph-container"), 

            style: [
              
                {
                    selector: 'node',
                    style: {
                        'background-color': 'data(color)', 
                        label: ' '
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

            maxZoom: 0.8,
            minZoom: 0.8
        });
        
        
    
    	
    function desenha(n){

	var cores = [
		"#F44336",
		"#2196F3",
		"#4CAF50",
		"#FFEB3B",
		"#9C27B0",
		"#3E2723",
		"#E91E63",
		"#01579B",
		"#B71C1C",
		"#CDDC39",
		"#00E5FF",
		"#8BC34A",
		"#FF9800",
		"#673AB7",
		"#009688",
		"#FFC107",
		"#FF5722",
		"#2962FF",
		"#1B5E20",
		"#AA00FF",
		"#76FF03",
		"#BF360C",
		"#F48FB1",
		"#E6EE9C",
		"#9FA8DA",
		"#33691E",
		"#FFCC80",
		"#80CBC4",
		"#000000",
		"#FFFF00"
	];
	var vertices = [];
	for(i=0;i<n;i++){
		vertices[i] = i + 1;
	}
	var cor_subgrafo = [];
	
	
	for(i=0;i<n;i++){
		cor_subgrafo[vertices[i]] = cores[Math.floor(Math.random() * n)];
	}
	
	cy.remove(cy.nodes());
	cy.remove(cy.edges());
	
	for (var vertice of vertices) {
		cy.add({
			group: "nodes",
			data: {
				id: vertice,
				color: cor_subgrafo[vertice],
			}
		});
	}
	for (j = 0; j < n - 1; j++) {
		for (k = j + 1; k < n; k++) {
			var cor = "#ccc";
			var sum = 0;
			sum = Math.floor(Math.random() * n);

			if (sum >= n-2 ) {
				if (cor_subgrafo[vertices[j]] == cor_subgrafo[vertices[k]]) {
					cor = cor_subgrafo[vertices[j]];
				}
				var str = vertices[j] + "-" + vertices[k];
				cy.add({
					group: "edges",
					data: {
						id: str,
						source: vertices[j],
						target: vertices[k],
						color: cor
					}
				});
			}
		}
	}
	var layout = cy.layout({
		name: "random",
		radius: 120,
		animate: true,
        animationEasing: undefined,
        animationDuration: 3000,
        avoidOverlap: false,
        animationThreshold: 250,
	  refresh: 100,
	  fit: true,
	  padding: 0,
	  boundingBox: undefined,
	  nodeDimensionsIncludeLabels: false,
	  randomize: false,
	  componentSpacing: 10,
	  nodeRepulsion: function( node ){ return 0; },
	  nodeOverlap: 1,
	  idealEdgeLength: function( edge ){ return 32; },
	  edgeElasticity: function( edge ){ return 32; },
	  nestingFactor: 1.2,
	  gravity: 1,
	  numIter: 1000,
	  initialTemp: 1000,
	  coolingFactor: 0.99,
	  minTemp: 1.0
	});

	layout.run();
}

var i = 2;                      

function myLoop () {          
   setTimeout(function () {    
      desenha(i);         
      i++;                    
      if (i < 30) {            
         myLoop();          
      }else{
      	i--;
      }                     
   }, 3000)
}

myLoop(); 
    </script>
    <div id="areamodal1"></div>
		<div id="areamodal2"></div>
		<div id="areamodal3"></div>
		<div id="areamodal4"></div>
		<div id="areamodalsearch"></div>
		<script type="text/javascript" src="JS/modals.js"></script>
    
</body>

</html>
