<?php 
	$peticionAjax = true;
	require_once '../core/configGenerales.php';
	if(isset($_POST["nombre-reg"])){
			require_once '../controladores/contactoControlador.php';
			$insContacto = new contactoControlador();

			if(isset($_POST["nombre-reg"]) && isset($_POST["telefono-reg"])){
			echo $insContacto->enviar_contacto_controlador();
			}

	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo "<script> window.location.href='".SERVERURL."login/'</script>";
	}