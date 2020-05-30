<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-book-image zmdi-hc-fw"></i> CATALOGO</h1>
	</div>
	<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
</div>


<?php
require_once "./controladores/librosControlador.php";
$insLibros=new librosControlador();
?>
<!-- Panel listado de libros -->
<div class="container-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">	
		</div>
		<div class="panel-body">
			<?php
				$pagina=explode("/", $_GET["vista"]);
				echo $insLibros->crud_mostrar_libros_controlador($pagina[1],100,$_SESSION["privilegio_sbp"],$_SESSION["codigo_cuenta_sbp"],"");
			?>		
		</div>
	</div>
</div>




