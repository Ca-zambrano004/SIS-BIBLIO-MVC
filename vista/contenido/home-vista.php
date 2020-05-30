<?php 
    if($_SESSION["tipo_sbp"]!="Administrador"){
        echo $lc->redireccionar_usuario_controlador($_SESSION["tipo_sbp"]);
    }
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles">Usuarios <small>Registrados</small></h1>
	</div>
</div>
<div class="full-box text-center" style="padding: 30px 10px;">
<?php  
    require "./controladores/administradorControlador.php";
    $instadmin=new administradorControlador();
    $contadmin=$instadmin->datos_administrador_controlador("Conteo",0);
    ?>
	<article class="full-box tile">
		<div class="full-box tile-title text-center text-titles text-uppercase">
			Administrador
		</div>
		<div class="full-box tile-icon text-center">
			<i class="zmdi zmdi-account"></i>
		</div>
		<div class="full-box tile-number text-titles">
			<p class="full-box"><?php echo $contadmin->rowCount(); ?></p>
			<small>Registrados</small>
		</div>
	</article>
	<?php  
    require "./controladores/empresaControlador.php";
    $instEmpresa=new empresaControlador();
    $contEmpresa=$instEmpresa->datos_empresa_controlador("Conteo",0);
    ?>
    <article class="full-box tile">
		<div class="full-box tile-title text-center text-titles text-uppercase">
			Empresas
		</div>
		<div class="full-box tile-icon text-center">
			<i class="zmdi zmdi-balance"></i>
		</div>
		<div class="full-box tile-number text-titles">
			<p class="full-box"><?php echo $contEmpresa->rowCount(); ?></p>
			<small>Registrados</small>
		</div>
	</article>
    <?php  
    require "./controladores/clienteControlador.php";
    $instCliente=new clienteControlador();
    $contCliente=$instCliente->datos_cliente_controlador("Conteo",0);
    ?>
	<article class="full-box tile">
		<div class="full-box tile-title text-center text-titles text-uppercase">
			Estudiantes
		</div>
		<div class="full-box tile-icon text-center">
			<i class="zmdi zmdi-face"></i>
		</div>
		<div class="full-box tile-number text-titles">
			<p class="full-box"><?php echo $contCliente->rowCount(); ?></p>
			<small>Registrados</small>
		</div>
	</article>
	<?php  
    require "./controladores/categoriaControlador.php";
    $instCategoria=new categoriaControlador();
    $contCategoria=$instCategoria->datos_categoria_controlador("Conteo",0);
    ?>
	<article class="full-box tile">
		<div class="full-box tile-title text-center text-titles text-uppercase">
			Categoria
		</div>
		<div class="full-box tile-icon text-center">
			<i class="zmdi zmdi-labels"></i>
		</div>
		<div class="full-box tile-number text-titles">
			<p class="full-box"><?php echo $contCategoria->rowCount(); ?></p>
			<small>Registrados</small>
		</div>
	</article>
	  <?php  
    require "./controladores/proveedorControlador.php";
    $instProveedor=new proveedorControlador();
    $contProveedor=$instProveedor->datos_proveedor_controlador("Conteo",0);
    ?>
	<article class="full-box tile">
		<div class="full-box tile-title text-center text-titles text-uppercase">
			Proveedores
		</div>
		<div class="full-box tile-icon text-center">
			<i class="zmdi zmdi-truck"></i>
		</div>
		<div class="full-box tile-number text-titles">
			<p class="full-box"><?php echo $contProveedor->rowCount(); ?></p>
			<small>Registrados</small>
		</div>
	</article>

	  <?php  
    require "./controladores/librosControlador.php";
    $instLibros=new librosControlador();
    $contLibros=$instLibros->datos_libros_controlador("Conteo",0);
    ?>
	<article class="full-box tile">
		<div class="full-box tile-title text-center text-titles text-uppercase">
			Libros
		</div>
		<div class="full-box tile-icon text-center">
			<i class="zmdi zmdi-book"></i>
		</div>
		<div class="full-box tile-number text-titles">
			<p class="full-box"><?php echo $contLibros->rowCount(); ?></p>
			<small>Registrados</small>
		</div>
	</article>

</div>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles">Usuarios <small>En linea</small></h1>
	</div>
	<section id="cd-timeline" class="cd-container">
    <?php 
     require_once './controladores/bitacoraControlador.php';
        $InstBitacora= new bitacoraControlador();
            echo $InstBitacora->listado_bitacora_controlador(10); 
    ?>
    </section>
</div>