<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-account-circle zmdi-hc-fw"></i> MIS DATOS</small></h1>
	</div>
	<p class="lead"><b>	Actualiza tu datos cuando lo desees</b></p>
</div>

<!-- Panel mis datos -->
<div class="container-fluid">
	<?php 
			$datos=explode("/", $_GET['vista']);
			
			//Administrador
		if($datos[1]=="admin"){
		   if($_SESSION["tipo_sbp"]!="Administrador"){
	        echo $lc->forzar_cierre_session_controlador();
	    	}
	    	require_once "./controladores/administradorControlador.php";
	    	$claseadmin=new administradorControlador();
	    	$FilasAdmin=$claseadmin->datos_administrador_controlador("Unico",$datos[2]);
	    	if($FilasAdmin->rowCount()==1){
	    		$Campos=$FilasAdmin->fetch();
	    		//Comprobar si el administrador tiene los privilegios para acceder a los cambios de usuario.
	    		if($Campos['CuentaCodigo']!=$_SESSION["codigo_cuenta_sbp"]){
	    			if($_SESSION["privilegio_sbp"]<1 || $_SESSION["privilegio_sbp"]>2){
	    				echo $lc->forzar_cierre_session_controlador();
	    			}
	    		}

	?>	
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; MIS DATOS</h3>
			</div>
			<div class="panel-body">
			<form action="<?php echo SERVERURL; ?>ajax/administradorAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
					<input type="hidden" name="cuenta_update" value=" <?php echo $datos[2];?>">
			    	<fieldset>
			    		<legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información personal</legend>
			    		<div class="container-fluid">
			    			<div class="row">
			    				<div class="col-xs-12">
							    	<div class="form-group label-floating">
									  	<label class="control-label">CEDULA *</label>
									  	<input pattern="[0-9-]{1,30}" class="form-control" type="text" name="CC-update" value="<?php echo $Campos['AdminCC'];?>" required="" maxlength="30">
									</div>
			    				</div>
			    				<div class="col-xs-12 col-sm-6">
							    	<div class="form-group label-floating">
									  	<label class="control-label">Nombres *</label>
									  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-update" value="<?php echo $Campos['AdminNombre'];?>" required="" maxlength="30">
									</div>
			    				</div>
			    				<div class="col-xs-12 col-sm-6">
									<div class="form-group label-floating">
									  	<label class="control-label">Apellidos *</label>
									  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="apellido-update" value=" <?php echo $Campos['AdminApellido'];?>" required="" maxlength="30">
									</div>
			    				</div>
			    				<div class="col-xs-12 col-sm-6">
									<div class="form-group label-floating">
									  	<label class="control-label">Teléfono</label>
									  	<input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-update" value="<?php echo $Campos['AdminTelefono'];?>" maxlength="15" required="">
									</div>
			    				</div>
			    				<div class="col-xs-12">
									<div class="form-group label-floating">
									  	<label class="control-label">Dirección</label>
									  	<textarea name="direccion-update" class="form-control" rows="2" maxlength="100" required=""><?php echo $Campos['AdminDireccion'];?>
									  	</textarea>
									</div>
			    				</div>
			    			</div>
			    		</div>
			    	</fieldset>
				    <p class="text-center" style="margin-top: 20px;">
				    	<button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Actualizar</button>
				    </p>
				    <div class="RespuestaAjax"></div>
			    </form>
			</div>
		</div>
	<?php
	    	}else{
	?>	
		<!-- CREAR ALERTAS EN HTML CREATIVA -->
		<!-- MUESTRA UNA ALERTA CUANDO CAMBIAMOS EL USUARIO EN LA URL POR UN DATO NO EXISTENTE -->
		   	<div class="alert alert-dismissible alert-warning text-center">
			<button type="button" class="close" data-dismiss="alert">X</button>
			<i class="zmdi zmdi-alert-triangle zmdi-hc-5x"></i>
			<h2>Error</h2>
			<h3>Termino de busqueda no encontrado</h3>
			<P>No se puede mostar la informacion deseada</P>	
			</div>
	<?php
			}
			//Usuarios
			}elseif($datos[1]=="user"){
				require_once "./controladores/clienteControlador.php";
			
				$clasecliente=new clienteControlador();
		    	$Filascliente=$clasecliente->datos_cliente_controlador("Unico",$datos[2]);
		    	if($Filascliente->rowCount()==1){
		    		$Campos=$Filascliente->fetch();
		    		//Comprobar si el administrador tiene los privilegios para acceder a los cambios de usuario.
		    		if($Campos['CuentaCodigo']!=$_SESSION["codigo_cuenta_sbp"]){
		    			if($_SESSION["privilegio_sbp"]<1 || $_SESSION["privilegio_sbp"]>2){
		    				echo $lc->forzar_cierre_session_controlador();
		    			}
		    		}
	?>	
	<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; ACTUALIZAR CLIENTE</h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo SERVERURL; ?>ajax/clienteAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
			    	<input type="hidden" name="cuenta_update" value=" <?php echo $datos[2];?>">
			    	<fieldset>
			    		<legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información personal</legend>
			    		<div class="container-fluid">
			    			<div class="row">
			    				<div class="col-xs-12">
							    	<div class="form-group label-floating">
									  	<label class="control-label">CEDULA *</label>
									  	<input pattern="[0-9-]{1,30}" class="form-control" type="text" name="CC-update" value="<?php echo $Campos['ClienteCC'];?>" required="" maxlength="30">
									</div>
			    				</div>
			    				<div class="col-xs-12 col-sm-6">
							    	<div class="form-group label-floating">
									  	<label class="control-label">Nombres *</label>
									  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-update" required="" value="<?php echo $Campos['ClienteNombre'];?>"maxlength="30">
									</div>
			    				</div>
			    				<div class="col-xs-12 col-sm-6">
									<div class="form-group label-floating">
									  	<label class="control-label">Apellidos *</label>
									  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="apellido-update" value="<?php echo $Campos['ClienteApellido'];?>" required="" maxlength="30">
									</div>
			    				</div>
			    				<div class="col-xs-12 col-sm-6">
									<div class="form-group label-floating">
									  	<label class="control-label">Teléfono</label>
									  	<input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-update" value="<?php echo $Campos['ClienteTelefono'];?>" maxlength="15" required="">
									</div>
			    				</div>
			    				<div class="col-xs-12 col-sm-6">
									<div class="form-group label-floating">
									  	<label class="control-label">Cargo/Ocupación *</label>
									  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="ocupacion-update" value="<?php echo $Campos['ClienteOcupacion'];?>" required="" maxlength="30">
									</div>
			    				</div>
			    				<div class="col-xs-12">
									<div class="form-group label-floating">
									  	<label class="control-label">Dirección</label>
									  	<textarea name="direccion-update" class="form-control" rows="2" maxlength="100" required=""><?php echo $Campos['ClienteDireccion'];?></textarea>
									</div>
			    				</div>
			    			</div>
			    		</div>
			    	</fieldset>
				    <p class="text-center" style="margin-top: 20px;">
				    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Actualizar</button>
				    </p>
				    <div class="RespuestaAjax"></div>
			    </form>
			</div>
	</div>
	<?php }else{ ?>	
		<!-- CREAR ALERTAS EN HTML CREATIVA -->
		<!-- MUESTRA UNA ALERTA CUANDO CAMBIAMOS EL USUARIO EN LA URL POR UN DATO NO EXISTENTE -->
		   	<div class="alert alert-dismissible alert-warning text-center">
			<button type="button" class="close" data-dismiss="alert">X</button>
			<i class="zmdi zmdi-alert-triangle zmdi-hc-5x"></i>
			<h2>Error</h2>
			<h3>Termino de busqueda no encontrado</h3>
			<P>No se puede mostar la informacion del cliente deseada</P>	
			</div>
	<?php
			}
			//Error
				}else{
		?>	
		<!-- CREAR ALERTAS EN HTML CREATIVA -->
		<!-- MUESTRA UNA ALERTA CUANDO CAMBIAMOS EL USUARIO EN LA URL POR UN DATO NO EXISTENTE -->
			<div class="alert alert-dismissible alert-warning text-center">
			<button type="button" class="close" data-dismiss="alert">X</button>
			<i class="zmdi zmdi-alert-triangle zmdi-hc-5x"></i>
			<h2>Error</h2>
			<h3>Termino de busqueda no encontrado</h3>
			<P>No se puede mostar la informacion deseada</P>	
			</div>
		<?php } ?>	
</div>