<?php @ob_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title><?php echo COMPANY; ?> </title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo SERVERURL; ?>vista/assets/img/web.png">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>vista/css/main.css" >

	<?php include "./vista/modulos/scripts.php"; ?>
	
</head>
<body>
	<?php 
		$peticionAjax = false;

		require_once "./controladores/vistasControlador.php";
		
		$vt = new vistasControlador();
		$vistasR=$vt->obtener_vistas_controlador();
		
		if ($vistasR=="login" || $vistasR=="404"):
			if ($vistasR=="login") {
				require_once "./vista/contenido/login-vista.php";
			}else{
				require_once "./vista/contenido/404-vista.php";
			}
		else:
			session_start(['name'=>'SBP']);

			require_once "./controladores/loginControlador.php";

			$lc=new loginControlador();

			if(!isset($_SESSION['token_sbp']) || !isset($_SESSION['usuario_sbp'])){

				echo $lc->forzar_cierre_session_controlador();
				
			}

	?>

	<!-- SideBar -->
	<?php include 'vista/modulos/navlateral.php'; ?>

	<!-- Content page-->
	<section class="full-box dashboard-contentPage">

	<!-- NavBar -->
	 <?php include "vista/modulos/navbar.php"; ?>	

	<!-- Content page -->
	<?php require_once $vistasR?>
	
	<!-- footer -->
	 <?php include "vista/modulos/footer.php"; ?>

	</section>

	<?php 
		include "./vista/modulos/logoutScript.php"; 
	 endif;?>
	
	<script>
		$.material.init();
	</script>

</body>
</html>
