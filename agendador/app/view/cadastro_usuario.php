<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Cadastre-se</title>
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
	<body class="no-roll" style="background-image: url('img/img7.jpg'); background-repeat: no-repeat; background-position: center; background-color: #C0C0C0; background-size: cover;">
		
		<div class="container vertical-center">
		<div class="row col-12  horizontal-center justify-content-around">	
			<div class="col-6 card">
				<div class="card-body">
				 	<h5 class="card-title  text-muted"><img src="img/icon.png" width="4%" class="muted in-line"> Crie sua conta!</h5>
					<form class="was-validated" action="../model/model_cad_user.php" method="post">
						<div class="form-group">
							<p class="card-text">
								<label for="nome"><i class="material-icons" style="transform: translateY(20%);">portrait</i>  Nome Completo </label> 
								<input type="text" id="nome" name="nome" placeholder="" class="form-control" autofocus required/>
							</p>
						</div>
						<div class="form-group">
							<p class="card-text">
								<label for="email"><i class="material-icons" style="transform: translateY(20%);">mail</i> E-mail </label> 
								<input type="email" class="form-control" id="email"  placeholder="email@dominio.com" name="login" required/>
							</p>
						</div>
						<div class="form-group">
							<p class="card-text">
								<label for="password1"><i class="material-icons" style="transform: translateY(20%);">lock</i> Senha </label> 
								<input type="password" class="form-control" id="password1" placeholder="" name="senha1" required/>
							</p>
						</div>
						<div class="form-group">
							<p class="card-text">
								<label for="password2"><i class="material-icons" style="transform: translateY(20%);">lock</i> Repita a Senha </label> 
								<input type="password"  class="form-control is-invalid" id="password2" placeholder="" name="senha2" onsubmit ="Verifica()" required/>
							</p>
						</div>
						<button class="btn btn-primary" id="botao" type="submit" onclick="test();"><i class="material-icons">account_circle</i> Cadastrar</button>
					</form>
				</div>
				<div class="card-footer text-muted">
    					Caso possua conta <button class="btn btn-success btn-sm" type="button" onclick="view_login();"><i class="material-icons">emoji_people</i> Acesse por aqui</button>
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
	   	    function test(){
	   	        if(document.getElementById("password1").value != document.getElementById("password2").value ){
	   	            alert("Senhas informadas não são iguais!");
	   	            $("#password2").style.borderColor="#f00";
	   	        }
	   	    }
	   	    
	   	</script>
	   	
	</body>
</html>
