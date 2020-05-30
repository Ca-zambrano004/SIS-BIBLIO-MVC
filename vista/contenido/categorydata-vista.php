<?php 
    if($_SESSION["tipo_sbp"]!="Administrador"){
        echo $lc->forzar_cierre_session_controlador();
    }
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-account-circle zmdi-hc-fw"></i> DATOS DE LA CATEGORIA</small></h1>
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
		$datos=explode("/", $_GET['vista']);
				
		require_once "./controladores/categoriaControlador.php";
		$claseCate=new categoriaControlador();
		$FilasCate=$claseCate->datos_categoria_controlador("Unico",$datos[2]);
		if($FilasCate->rowCount()==1){
			$Campos=$FilasCate->fetch();
			//Comprobar si el administrador tiene los privilegios para acceder a los cambios de usuario.
			
		}
	?>	
<!-- Panel nueva categoria -->
<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; DATOS DE LA CATEGORIA</h3>
			</div>
			<div class="panel-body">
			<form action="<?php echo SERVERURL; ?>ajax/categoriaAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
					<input type="hidden" name="cuenta_update" value=" <?php echo $datos[2];?>">
		    		<legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Información de la categoría</legend>
		    		<div class="container-fluid">
		    			<div class="row">
		    				<div class="col-xs-12 col-sm-6">
						    	<div class="form-group label-floating">
								  	<label class="control-label">Código *</label>
								  	<input pattern="[0-9]{1,7}" class="form-control" type="text" name="cc-update" value="<?php echo $Campos['CategoriaCodigo'];?>" required="" maxlength="7">
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
						    	<div class="form-group label-floating">
								  	<label class="control-label">Nombre *</label>
								  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-update" value="<?php echo $Campos['CategoriaNombre'];?>" required="" maxlength="30">
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
</div>