<div class="full-box login-container cover">
	<form action="" method="POST" autocomplete="off" class="logInForm">
		<p class="text-center text-muted">
			<img src="<?php echo SERVERURL; ?>vista/assets/img/logo.png" >
		</p>
		<p class="text-center text-muted text-uppercase">INICIAR SESIÓN CON TU CUENTA</p>
		<div class="form-group label-floating">
		  <input required="" class="form-control" id="UserName" name="usuario" type="text" placeholder="&#128583; Usuario">
		  <p class="help-block">Escribe tú nombre de usuario</p>
		</div>
		<div class="form-group label-floating">
		  <input required="" class="form-control" id="UserPass" name="clave" type="password" placeholder="&#128273; Contraseña">
		  <p class="help-block">Escribe tú contraseña</p>
		</div>
		<div class="form-group text-center">
			<input  type="submit" value="Iniciar sesión">
		</div>
	</form>
</div>
<?php  
	if(isset($_POST['usuario']) && isset($_POST['clave'])){
		require_once "./controladores/loginControlador.php";
		
		$login=new loginControlador();
		echo $login->iniciar_sesion_controlador();
	} 
?>