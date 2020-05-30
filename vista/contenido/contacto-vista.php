<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Formulario <small>Contacto</small></h1>
	</div>
	<p class="lead">Para nosotros es muy importante conocer la percepción de servicio, que tienen nuestros usuarios sobre los diferentes productos que ofrecemos..!</p>
</div>

<!-- Panel nuevo libro -->
<div class="container-fluid">
	<div class="panel panel-info">
		
		<div class="panel-body">
				<form action="<?php echo SERVERURL; ?>ajax/contactoAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
				<fieldset>
					<legend><i class="zmdi zmdi-library"></i> &nbsp; Enviar Información </legend>
					<div class="container-fluid" >
						
		    				<div class="col-xs-6">
						    	<div class="form-group label-floating">
								  	<label class="control-label">Nombre *</label>
								  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-reg" required="" maxlength="30">
								</div>
		    				</div>
					    		<div class="col-xs-12 col-sm-6">
							<div class="form-group label-floating">
							  	<label class="control-label">Teléfono</label>
							  	<input pattern="[0-9+]{1,15}" class="form-control" type="tel" name="telefono-reg" maxlength="15">
							</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
							<div class="form-group label-floating">
							  	<label class="control-label">Asunto</label>
							  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="asunto-reg" maxlength="15">
							</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">E-mail</label>
								  	<input class="form-control" type="email" name="email-reg" maxlength="50">
								</div>
		    				</div>
		    				<div class="col-xs-9">
							<div class="form-group label-floating">
								<label class="control-label">Informacion *</label>
								<textarea name="resumen-reg" class="form-control" rows="3"></textarea>
								</div>
		    				</div>
						</div>
				</fieldset>
				<br>
			    <p class="text-center" style="margin-top: 20px;">
			    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-check-circle-u"></i> Enviar</button>
			    </p>
			    <div class="RespuestaAjax"></div>
		    </form>
		</div>
	</div>
</div>
