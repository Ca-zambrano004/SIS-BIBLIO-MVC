<?php 
	$peticionAjax = true;
	require_once '../core/configGenerales.php';
	if(isset($_POST["cc-reg"]) || isset($_POST["codigo-del"])|| isset($_POST["cuenta_update"])){
			require_once '../controladores/clienteControlador.php';
			$insCliente = new clienteControlador();

			if(isset($_POST["cc-reg"]) && isset($_POST["nombre-reg"]) && isset($_POST["apellido-reg"])){
			echo $insCliente->agregar_cliente_controlador();
			}

			if(isset($_POST["codigo-del"]) && isset($_POST["privilegio-admin"])){
			echo $insCliente->eliminar_cliente_controlador();

			}
			if(isset($_POST["cuenta_update"]) && isset($_POST['CC-update'])){
				echo $insCliente->actualizar_cliente_controlador();
			}
	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo "<script> window.location.href='".SERVERURL."login/'</script>";
	}