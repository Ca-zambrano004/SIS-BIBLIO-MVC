<?php 
	$peticionAjax = true;
	require_once '../core/configGenerales.php';
	if(isset($_POST["cc-reg"]) || isset($_POST["codigo-del"])|| isset($_POST["codigo"])){
			require_once '../controladores/empresaControlador.php';
			$insEmpresa = new empresaControlador();

			if(isset($_POST["cc-reg"]) && isset($_POST["nombre-reg"]) && isset($_POST["telefono-reg"])){
			echo $insEmpresa->agregar_empresa_controlador();
			}

			if(isset($_POST["codigo-del"]) && isset($_POST["privilegio-admin"])){
			echo $insEmpresa->eliminar_empresa_controlador();

			}
			if(isset($_POST["codigo"]) && isset($_POST['nombre-update']) && isset($_POST['telefono-update'])){
				echo $insEmpresa->actualizar_empresa_controlador();
			}
	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo "<script> window.location.href='".SERVERURL."login/'</script>";
	}