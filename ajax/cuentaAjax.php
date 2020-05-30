<?php 
	$peticionAjax = true;
	require_once '../core/configGenerales.php';
	if(isset($_POST["CodigoCuenta-up"])){
			require_once '../controladores/cuentaControlador.php';
			$insCuenta = new cuentaControlador();

			if(isset($_POST["CodigoCuenta-up"]) && isset($_POST["tipoCuenta-up"]) && isset($_POST["usuarioConfir-up"]) && isset($_POST["passwordConfir-up"])){
			echo $insCuenta->actualizar_cuenta_controlador();
			}
	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo "<script> window.location.href='".SERVERURL."login/'</script>";
	}