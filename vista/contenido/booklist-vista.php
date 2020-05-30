<?php 
    if($_SESSION["tipo_sbp"]!="Administrador"){
        echo $lc->forzar_cierre_session_controlador();
    }
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Administración <small>LIBROS</small></h1>
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
	require_once "./controladores/librosControlador.php";
		$insLibros=new librosControlador();

?>

<!-- Panel listado de libros -->
<div class="container-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE LIBROS</h3>
		</div>
		<div class="panel-body">
			<?php
				$pagina=explode("/", $_GET["vista"]);
				echo $insLibros->crud_libros_controlador($pagina[1],10,$_SESSION["privilegio_sbp"],$_SESSION["codigo_cuenta_sbp"],"");
			?>		
		</div>
	</div>
</div>