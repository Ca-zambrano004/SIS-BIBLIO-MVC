<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> INFORMACIÓN LIBRO</h1>
	</div>
	<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!
	</p>
</div>
<!-- Panel info libro -->
<div class="container-fluid">
	<?php 
		
		$datos=explode("/", $_GET['vista']);	
		require_once "./controladores/librosControlador.php";
		$claseLibros=new librosControlador();
		$FilasLibros=$claseLibros->datos_libros_controlador("Unico",$datos[1]);
		if($FilasLibros->rowCount()==1){
			$Campos=$FilasLibros->fetch();	
		}
	?>		
<div class="container-fluid">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-info"></i> &nbsp; NOMBRE LIBRO</h3>
		</div>
		<div class="panel-body">
			
			<fieldset>
				<legend><i class="zmdi zmdi-library"></i> &nbsp; Información básica</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-12">
					    	<div class="form-group label-floating">
							  	<span>Título</span>
							  		<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text"  value="<?php echo $Campos['LibroTitulo'];?>" required="" maxlength="40">
							</div>
	    				</div>
	    				<form action="" method="" enctype="multipart/form-data">
	    				<div class="col-xs-12 col-sm-6">
						<?php 
						$ruta = $Campos['LibroImagen'];	
						$ruta = substr($ruta, 8);		
						?>
						<img src='<?php echo SERVERURL; ?>vista<?php echo $ruta;?>' width='450' height='500'>
						</div>
						</form>
	    				<div class="col-xs-12 col-sm-6">
					    	<div class="container-fluid">
					    		<div class="row">
				    				<div class="col-xs-12">
								    	<div class="form-group label-floating">
										  	<span>Autor</span>
										  	<input class="form-control" name="autor-up" value="<?php echo $Campos['LibroAutor'];?>" readonly="">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span>País</span>
									  		<input class="form-control" name="pais-up" value="<?php echo $Campos['LibroPais'];?>" readonly="">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span>Fecha de Publicación</span>
											<input class="form-control" name="year-up" value="<?php echo $Campos['LibroYear'];?>" readonly="">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span>Editorial</span>
										  	<input class="form-control" name="editorial-up" value="<?php echo $Campos['LibroEditorial'];?>" readonly="">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span>Edición</span>
										  	<input class="form-control" name="edicion-up" value="<?php echo $Campos['LibroEdicion'];?>" readonly="">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span>Precio</span>
										  	<input class="form-control" name="year-up" value="<?php echo $Campos['LibroPrecio'];?>" readonly="">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span># Paginas</span>
										  	<input class="form-control" name="ejemplares-up" value="<?php echo $Campos['LibroPaginas'];?>" readonly="">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span>Ubicación</span>
										  	<input class="form-control" name="ubicacion-up" value="<?php echo $Campos['LibroUbicacion'];?>" readonly="">
										</div>
				    				</div>
					    		</div>
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
							  	<span>Resumen</span>
							  	<textarea readonly="" name="resumen-up" value=""class="form-control" rows="7"><?php echo $Campos['LibroResumen'];?></textarea>
							</div>
	    				</div>
					</div>
				</div>
			</fieldset>

		</div>
		</div>
	</div>
</div>