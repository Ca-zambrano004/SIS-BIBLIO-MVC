<?php 
    if($_SESSION["tipo_sbp"]!="Administrador" || $_SESSION["privilegio_sbp"]<1 || $_SESSION["privilegio_sbp"]>2){
	echo $lc->forzar_cierre_session_controlador();
	} 
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-wrench zmdi-hc-fw"></i> GESTIÓN DE LIBRO</small></h1>
	</div>
	<p class="lead"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
</div>

<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>book/" class="btn btn-info">
	  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVO LIBRO
	  		</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>booklist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE LIBROS
	  		</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>booksearch/" class="btn btn-primary">
	  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR LIBROS
	  		</a>
	  	</li>
	</ul>
</div>

<!-- Panel actualizar libro -->
<div class="container-fluid">
	<?php 
		$datos=explode("/", $_GET['vista']);	
		require_once "./controladores/librosControlador.php";
		$claseLibros=new librosControlador();
		$FilasLibros=$claseLibros->datos_libros_controlador("Unico",$datos[1]);
		if($FilasLibros->rowCount()==1){
			$Campos=$FilasLibros->fetch();	
				//Comprobar si el administrador tiene los privilegios para acceder a los cambios de usuario.	
		}
	?>	
	<div class="container-fluid">
		<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; ACTUALIZAR LIBRO</h3>
				</div>
			<div class="panel-body">
				<form action="<?php echo SERVERURL; ?>ajax/librosAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
					<input type="hidden" name="codigo" value=" <?php echo $datos[1];?>">
						<fieldset>
							<legend><i class="zmdi zmdi-library"></i> &nbsp; Información básica</legend>
							<div class="container-fluid">
								<div class="row">

									<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Código de libro *</label>
										  	<input pattern="[a-zA-Z0-9-]{1,50}" class="form-control" type="text" name="referencia-up" value="<?php echo $Campos['LibroCodigo'];?>" required="" maxlength="50">
										</div>
				    				</div>
 				
									<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Título *</label>
										  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="titulo-up" value="<?php echo $Campos['LibroTitulo'];?>" required="" maxlength="50">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Autor *</label>
										 <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="autor-up" value="<?php echo $Campos['LibroAutor'];?>" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">País</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" value="<?php echo $Campos['LibroPais'];?>" name="pais-up" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Fecha de Publicación</label>
										  	<input pattern="[0-9]{1,4}" class="form-control" type="date" value="<?php echo $Campos['LibroYear'];?>" name="year-up" maxlength="4">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Editorial</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="editorial-up" value="<?php echo $Campos['LibroEditorial'];?>"maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Edición</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="edicion-up" value="<?php echo $Campos['LibroEdicion'];?>"maxlength="30">
										</div>
				    				</div>
								</div>
							</div>
						</fieldset>
						<br>
						<fieldset>
							<legend><i class="zmdi zmdi-money-box"></i> &nbsp; Precio, Ejemplares y Ubicación</legend>
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Precio</label>
										  	<input pattern="[0-9.]{1,7}" class="form-control" type="text" name="precio-up" value="<?php echo $Campos['LibroPrecio'];?>" maxlength="7">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label"># Paginas</label>
										  	<input pattern="[0-9]{1,5}" class="form-control" type="text" name="paginas-up" value="<?php echo $Campos['LibroPaginas'];?>"maxlength="5">
										</div>
				    				</div>
				    				<div class="col-xs-12">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Ubicación</label>
										  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ- ]{1,30}" class="form-control" type="text" name="ubicacion-up" value="<?php echo $Campos['LibroUbicacion'];?>"maxlength="30">
										</div>
				    				</div>
								</div>
							</div>
						</fieldset>
						<br>
						<fieldset>
							<legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Resumen del libro</legend>
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12">
										<div class="form-group label-floating">
										  	<label class="control-label">Resumen</label>
										  	<textarea name="resumen-up"class="form-control" rows="7"> <?php echo $Campos['LibroResumen'];?></textarea>
										</div>
				    				</div>
								</div>
							</div>
						</fieldset>
						<br>	
<!--
						<fieldset>
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label class="control-label">¿El archivo PDF será descargable para los clientes?</label>
								<div class="radio radio-primary">
									<label>
										<input type="radio" name="optionsPDF" id="optionsRadios1" value="Si" checked="">
										<i class="zmdi zmdi-cloud-download"></i> &nbsp; Si, PDF descargable
									</label>
								</div>
								<div class="radio radio-primary">
									<label>
										<input type="radio" name="optionsPDF" id="optionsRadios2" value="No">
										<i class="zmdi zmdi-cloud-off"></i> &nbsp; No, PDF no descargable
									</label>
								</div>
							</div>
						</div>
						</fieldset>
-->
						<br>
						<p class="text-center" style="margin-top: 20px;">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
					    </p>
				    <div class="RespuestaAjax"></div>
				</form>
			</div>
		</div>
	</div>
</div>

