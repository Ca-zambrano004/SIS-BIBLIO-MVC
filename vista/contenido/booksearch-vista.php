<?php 
    if($_SESSION["tipo_sbp"]!="Administrador"){
        echo $lc->forzar_cierre_session_controlador();
    }
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> INFORMACIÓN LIBRO</small></h1>
	</div>
	<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
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

<?php
	if(!isset($_SESSION['busqueda_libro']) && empty($_SESSION['busqueda_libro'])):
?>

<div class="container-fluid">
	<form class="well FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off" enctype="multipart/form-data">
			<div class="row">
				<div class="col-xs-12 col-md-8 col-md-offset-2">
					<div class="form-group label-floating">
						<span class="control-label">¿A quién estas buscando?</span>
						<input class="form-control" type="text" name="busqueda_libro_inicial" required="">
					</div>
				</div>
				<div class="col-xs-12">
					<p class="text-center">
						<button type="submit" class="btn btn-primary btn-raised btn-sm"><i class="zmdi zmdi-search"></i> &nbsp; Buscar</button>
					</p>
				</div>
			</div>
		 <div class="RespuestaAjax"></div>
	</form>
</div>
<?php else: ?>
<div class="container-fluid" >
	<form class="well FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off" enctype="multipart/form-data">
			<p class="lead text-center">Su última búsqueda  fue <strong>“<?php echo $_SESSION['busqueda_libro'];?>”</strong></p>
			<div class="row">
				<input class="form-control" type="hidden" name="eliminar_busqueda_libro" value="1">
				<div class="col-xs-12">
					<p class="text-center">
						<button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
					</p>
				</div>
			</div>
		 <div class="RespuestaAjax"></div>
	</form>
</div>

<!-- Panel listado de libros -->
<div class="container-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE LIBROS</h3>
		</div>
		<div class="panel-body">
			<?php
			require_once "./controladores/librosControlador.php";
				$insLibros=new librosControlador();
				$pagina=explode("/", $_GET["vista"]);
				echo $insLibros->crud_libros_controlador($pagina[1],3,$_SESSION["privilegio_sbp"],$_SESSION["codigo_cuenta_sbp"],$_SESSION["busqueda_libro"]);
			?>		
		</div>
	</div>
</div>


<?php endif; ?>