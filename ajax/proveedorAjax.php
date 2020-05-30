<?php 
	$peticionAjax = true;
	require_once '../core/configGenerales.php';
	if(isset($_POST["nombre-reg"]) || isset($_POST["codigo-del"])|| isset($_POST["cuenta_update"])){
			require_once '../controladores/proveedorControlador.php';
			$insProveedor = new proveedorControlador();

			if(isset($_POST["nombre-reg"]) && isset($_POST["responsable-reg"]) && isset($_POST["telefono-reg"])){
			echo $insProveedor->agregar_proveedor_controlador();
			}

			if(isset($_POST["codigo-del"]) && isset($_POST["privilegio-admin"])){
			echo $insProveedor->eliminar_proveedor_controlador();

			}
			if(isset($_POST["cuenta_update"]) && isset($_POST['nombre-update']) && isset($_POST['telefono-update'])){
				echo $insProveedor->actualizar_proveedor_controlador();
			}
	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo "<script> window.location.href='".SERVERURL."login/'</script>";
	}