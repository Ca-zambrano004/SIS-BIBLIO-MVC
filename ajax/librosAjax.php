<?php 
	$peticionAjax = true;
	require_once '../core/configGenerales.php';
	if(isset($_POST["codigo-reg"]) || isset($_POST["codigo"]) || isset($_POST["codigo-del"])){
			
			require_once '../controladores/librosControlador.php';
			$insLibros = new librosControlador();

			if(isset($_POST["codigo-reg"]) && isset($_POST["titulo-reg"])){
			echo $insLibros->agregar_libros_controlador();
			}

			if(isset($_POST["codigo"]) && isset($_POST["titulo-up"])){
			echo $insLibros->actualizar_libros_controlador();

			}

			if(isset($_POST["codigo-del"]) && isset($_POST["privilegio-admin"])){
			echo $insLibros->eliminar_libros_controlador();
			}

	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo "<script> window.location.href='".SERVERURL."login/'</script>";
	}