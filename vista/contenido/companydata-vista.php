<?php 
    if($_SESSION["tipo_sbp"]!="Administrador" || $_SESSION["privilegio_sbp"]<1 || $_SESSION["privilegio_sbp"]>2){
	echo $lc->forzar_cierre_session_controlador();
	} 
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-account-circle zmdi-hc-fw"></i> DATOS DE LA EMPRESA</small></h1>
	</div>
	<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
</div>

<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>company/" class="btn btn-info">
	  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVA EMPRESA
	  		</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>companylist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE EMPRESAS
	  		</a>
	  	</li>
	</ul>
</div>

<!-- Panel mis datos -->
<div class="container-fluid">
	<?php 
			$datos=explode("/", $_GET['vista']);
					
	    	require_once "./controladores/empresaControlador.php";
	    	$claseEmpre=new empresaControlador();
	    	$FilasEmpre=$claseEmpre->datos_empresa_controlador("Unico",$datos[1]);
	    	if($FilasEmpre->rowCount()==1){
	    		$Campos=$FilasEmpre->fetch();
	    		//Comprobar si el administrador tiene los privilegios para acceder a los cambios de usuario.
	    		
	    	}
	?>	
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; ACTUALIZAR DATOS DE LA EMPRESA</h3>
			</div>
			<div class="panel-body">
			<form action="<?php echo SERVERURL; ?>ajax/empresaAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
					<input type="hidden" name="codigo" value="<?php echo $datos[1];?>">
			    	<fieldset>
		    		<legend><i class="zmdi zmdi-assignment"></i> &nbsp; Datos básicos</legend>
		    		<div class="container-fluid">
		    			<div class="row">
		    				<div class="col-xs-12 col-sm-6">
						    	<div class="form-group label-floating">
								  	<label class="control-label">NIT/NÚMERO DE REGISTRO *</label>
								  	<input pattern="[0-9-]{1,30}" class="form-control" type="text" name="nit-update" value="<?php echo $Campos['EmpresaCodigo'];?>" required="" maxlength="30">
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
						    	<div class="form-group label-floating">
								  	<label class="control-label">Nombre de la empresa *</label>
								  	<input pattern="[a-zA-Z0-9-áéíóúÁÉÍÓÚñÑ- ]{1,40}" class="form-control" type="text" name="nombre-update" value="<?php echo $Campos['EmpresaNombre'];?>" required="" maxlength="40">
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Teléfono</label>
								  	<input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-update" value="<?php echo $Campos['EmpresaTelefono'];?>" maxlength="15">
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">E-mail</label>
								  	<input class="form-control" type="email" name="email-update" value="<?php echo $Campos['EmpresaEmail'];?>" maxlength="50">
								</div>
		    				</div>
		    				<div class="col-xs-12">
								<div class="form-group label-floating">
								  	<label class="control-label">Dirección</label>
								  	<input class="form-control" type="text" name="direccion-update" value="<?php echo $Campos['EmpresaDireccion'];?>" maxlength="170">
								</div>
		    				</div>
		    			</div>
		    		</div>
		    	</fieldset>
		    	<br>
		    	<fieldset>
		    		<legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Otros datos</legend>
		    		<div class="container-fluid">
		    			<div class="row">
		    				<div class="col-xs-12">
					    		<div class="form-group label-floating">
								  	<label class="control-label">Nombre del gerente o director *</label>
								  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="director-update" required="" value="<?php echo $Campos['EmpresaDirector'];?>" maxlength="50">
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
					    		<div class="form-group label-floating">
								  	<label class="control-label">Telefono *</label>
								  	<input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono2-update" value="<?php echo $Campos['EmpresaDirecTele'];?>" maxlength="15">
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
					    		<div class="form-group label-floating">
								  	<label class="control-label">Año *</label>
								  	<input pattern="[0-9]{4,4}" class="form-control" type="text" name="year-update" required="" value="<?php echo $Campos['EmpresaYear'];?>" maxlength="4">
								</div>
		    				</div>
		    			</div>
		    		</div>
		    	</fieldset>
		    	<br>
				    <p class="text-center" style="margin-top: 20px;">
				    	<button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Actualizar</button>
				    </p>
				    <div class="RespuestaAjax"></div>
			    </form>
			</div>
		</div>
	
	
</div>