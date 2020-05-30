<?php 
    if($_SESSION["tipo_sbp"]!="Administrador"){
        echo $lc->forzar_cierre_session_controlador();
    }
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-labels zmdi-hc-fw"></i> Administración <small>CATEORÍAS</small></h1>
	</div>
	<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
</div>

<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>category/" class="btn btn-info">
	  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVA CATEORÍA
	  		</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>categorylist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE CATEORÍAS
	  		</a>
	  	</li>
	</ul>
</div>

<?php
	require_once "./controladores/categoriaControlador.php";
		$insCategoria=new categoriaControlador();

?>

<!-- Panel listado de categorias -->
<div class="container-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE CATEORÍAS</h3>
		</div>
		<div class="panel-body">
			<?php
				$pagina=explode("/", $_GET["vista"]);
				echo $insCategoria->crud_categoria_controlador($pagina[1],2,$_SESSION["privilegio_sbp"],$_SESSION["codigo_cuenta_sbp"],"");
			?>
		</div>
	</div>
</div>