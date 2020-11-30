<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Login</title>
		<meta content="text/html; charset=UTF-8" http-equiv="content-type" />
		<meta name="viewport" content="width=1024" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" href="src/bootstrap.min.css" />
        <link rel="stylesheet" href="src/roboto.css" />
        <link rel="stylesheet" href="src/icon.css" />
        <link rel="stylesheet" href="style/main.css" />
		<link rel="stylesheet" href="style/tests.css" />
	</head>
	<body class="no-roll" style="background-image: url('img/img7.jpg'); background-repeat: no-repeat; background-position: center; background-color: #C0C0C0; background-size: cover;">	
		<?php
		 	if(isset($_GET['err'])){
		 		echo('	<div class="d-print-none alert alert-danger border-dark alert-dismissible fade show" role="alert">
		 					<button class="btn btn-danger brn-sm">
		 						<i class="material-icons">
		 							error_outline
		 						</i>
		 					</button> 
		 					<strong>Erro:</strong> '. base64_decode($_GET["err"]) .'
		 					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						  </button>
		 				</div>
		 		');
		 	}
		?>
		
		<div class="container vertical-center">
			<div class="row col-12 justify-content-around horizontal-center">
				
					<div class="col-6 card">
						<div class="card-body">
						 	<h5 class="card-title  text-muted"><img src="img/icon.png" width="4%" class="muted in-line"> Acesse sua conta!</h5>
						 	<form class="needs-validation" action="../model/model_login.php" method="post" novalidate>
							 	<div class="form-group">
									<p class="card-text">
										<label for="email"><i class="material-icons" style="transform: translateY(20%);">mail</i> E-mail </label> 
										<input type="email" class="form-control" id="email"  placeholder="email@dominio.com" name="login" autofocus required />
										
									</p>
									
								</div>
								<div class="form-group">
									<p class="card-text">
										<label for="password" ><i class="material-icons " style="transform: translateY(20%);">lock</i>Senha </label>
										<input type="password"  class="form-control" aria-describedby="emailHelp" id="password" placeholder="" name="senha" required />
									</p>
									<small id="emailHelp" class="form-text text-muted">Utilize o mesmo email e senha cadastrados no sistema.</small>
								</div>
								<button class="btn btn-success" type="submit" ><i class="material-icons">thumb_up</i> Entrar</button>
							</form>
						</div>
						<div class="card-footer text-muted">
							Caso não possua conta <button class="btn btn-primary btn-sm" onclick="view_cadastro();"><i class="material-icons">emoji_people</i> Cadastre-se!</button>
	  					</div>
					</div>
				
			</div>
		
		</div>
		<?php
			header("Pragma: no-cache");
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-cache, cachehack=".time());
			header("Cache-Control: no-store, must-revalidate");
			header("Cache-Control: post-check=-1, pre-check=-1", false);
		?>
		<script type="text/javascript" src="src/jquery.js"></script>
	   	<script type="text/javascript" src="src/popper.js"></script>
	   	<script type="text/javascript" src="src/bootstrap.js"></script>
	   	<script type="text/javascript" src="JS/route.js"></script>
	   	<script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
        </script>
   		
	</body>
</html>
