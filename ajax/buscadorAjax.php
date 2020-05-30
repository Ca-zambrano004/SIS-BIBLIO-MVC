<?php 
	session_start(['name'=>'SBP']);
	$peticionAjax = true;
	require_once '../core/configGenerales.php';
	if(isset($_POST)){
		//MODULO ADMINISTRADOR
		//PARA BUSCAR
		if(isset($_POST['busqueda_inicial_admin'])){
			$_SESSION['busqueda_admin']=$_POST['busqueda_inicial_admin'];
		}
		//PARA ELIMINAR LA BUSQUEDA
		if(isset($_POST['eliminar_busqueda_admin'])){
			unset($_SESSION['busqueda_admin']);
			$url="adminsearch";
		}


		//MODULO CLIENTE
		//PARA BUSCAR
		if(isset($_POST['busqueda_cliente_inicial'])){
			$_SESSION['busqueda_cliente']=$_POST['busqueda_cliente_inicial'];
		}
		//PARA ELIMINAR LA BUSQUEDA
		if(isset($_POST['eliminar_busqueda_cliente'])){
			unset($_SESSION['busqueda_cliente']);
			$url="clientsearch";
		}

		//MODULO LIBRO
		//PARA BUSCAR
		if(isset($_POST['busqueda_libro_inicial'])){
			$_SESSION['busqueda_libro']=$_POST['busqueda_libro_inicial'];
		}
		//PARA ELIMINAR LA BUSQUEDA
		if(isset($_POST['eliminar_busqueda_libro'])){
			unset($_SESSION['busqueda_libro']);
			$url="booksearch";
		}

		//MODULO SEARCH
		//PARA ELIMINAR LA BUSQUEDA
		if(isset($_POST['eliminar_busqueda_general_libro'])){
			unset($_SESSION['busqueda_libro']);
			$url="search";
		}


		if(isset($url)){
			echo "<script> window.location.href='".SERVERURL.$url."/'</script>";
		}else{
			echo "<script> location.reload();</script>";
		}
		

	}else{
		session_destroy();
		echo "<script> window.location.href='".SERVERURL."login/'</script>";
	}