<?php

	
	(function(){
	    $lifetime=3600; // 60 minutos
	    session_cache_limiter('private');
	    session_start();
	    setcookie(session_name(),session_id(),time()+$lifetime);
	    
	    if (isset($_SESSION['ultima_atividade']) && (time() - $_SESSION['ultima_atividade'] > $lifetime)) {
            session_unset();     // unset $_SESSION  
            session_destroy();   // destroindo session data 
            $err = base64_encode('Logue-se novamente por favor. Sua sessão expirou devido ao tempo de inatividade. <i class="material-icons">access_time</i>');
		    header('Location: ../controller/exit.php?err='. $err);    
        }
        $_SESSION['ultima_atividade'] = time(); // update da ultima atividade
	})();
	
	
	
	
	
	
	
	function workspace_identidade(){
		if(!isset($_SESSION['workspace']) || $_SESSION['workspace'] == ''){
			$err = base64_encode('O workspace não pode ser carregado. Por favor tente novamente em instantes.');
			header('Location: ../view/dashboard.php?err='. $err);
		}
	}	
	
	function user_identidade(){
		if(!isset($_SESSION['usuario'])){
			$err = base64_encode('Não foi possivel confirmar o login');
			header('Location: ../controller/exit.php?err='. $err);    			
		}
	}
	
	function workspace_secure($q){
		if(!isset($q)){
			$err = base64_encode('O workspace não pode ser carregado. Workspace inválido.');
			header('Location: ../view/dashboard.php?err='. $err);
		}
		if($q != $_SESSION['workspace']){
		    $_SESSION['workspace'] = $q;
			//$err = base64_encode('O workspace não pode ser carregado. As informações do workspace não corresponderam. ' . $q .' e '.  $_SESSION['workspace']);
			//header('Location: ../view/dashboard.php?err='. $err);
		}
	}
	
	function identidade($q){
		//user_identidade();
		workspace_identidade();
		workspace_secure($q);
	}
	
