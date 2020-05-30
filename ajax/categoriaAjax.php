<?php 
	$peticionAjax = true;
	require_once '../core/configGenerales.php';
	if(isset($_POST["cc-reg"])|| isset($_POST["codigo-del"])|| isset($_POST["cuenta_update"])){
			require_once '../controladores/categoriaControlador.php';
			$insCategoria = new categoriaControlador();

			if(isset($_POST["cc-reg"]) && isset($_POST["nombre-reg"])){
			echo $insCategoria->agregar_categoria_controlador();
			}

			if(isset($_POST["codigo-del"]) && isset($_POST["privilegio-admin"])){
			echo $insCategoria->eliminar_categoria_controlador();

			}
			if(isset($_POST["cuenta_update"]) && isset($_POST['cc-update']) && isset($_POST['nombre-update'])){
				echo $insCategoria->actualizar_categoria_controlador();
			}
	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo "<script> window.location.href='".SERVERURL."login/'</script>";
	}