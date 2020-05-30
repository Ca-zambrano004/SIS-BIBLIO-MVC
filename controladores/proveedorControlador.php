<?php 
	if ($peticionAjax) {
	require_once '../modelos/proveedorModelo.php';
	} else {
	require_once './modelos/proveedorModelo.php';
	}

class proveedorControlador extends proveedorModelo{

	//CONTROLADOR PARA AGREGAR PROVEEDOR
	public function agregar_proveedor_controlador(){
		$nombre=mainModel::limpiar_cadena ($_POST["nombre-reg"]);
		$responsable=mainModel::limpiar_cadena ($_POST["responsable-reg"]);
		$telefono=mainModel::limpiar_cadena ($_POST["telefono-reg"]);
		$email=mainModel::limpiar_cadena ($_POST["email-reg"]);
		$direccion=mainModel::limpiar_cadena ($_POST["direccion-reg"]);
		
		$consulta=mainModel::ejecutar_consulta_simple("SELECT id FROM proveedor");
		$numero=($consulta->rowCount())+1;
		$codigo=mainModel::generar_codigo_aleatorio ("AC",7,$numero);

		$consulta1=mainModel::ejecutar_consulta_simple ("SELECT ProveedorNombre FROM proveedor WHERE ProveedorNombre='$nombre'");

		$consulta2=mainModel::ejecutar_consulta_simple ("SELECT ProveedorEmail FROM proveedor WHERE ProveedorEmail= '$email'" );
		
				if($consulta2->rowCount()<=0){
					$datosProveedor=[
						"Codigo"=>$codigo,
						"Nombre"=>$nombre,
						"Responsable"=>$responsable,
						"Telefono"=>$telefono,
						"Email"=>$email,
						"Direccion"=>$direccion,
						];

					$guardarProveedor=proveedorModelo::agregar_proveedor_modelo($datosProveedor);

					if($guardarProveedor->rowCount()>=1){
						$alerta=[
							"Alertas"=>"recargar",
							"Titulo"=>"Registro exitoso",
							"Texto"=>"Se ha registrado el Proveedor en el sistema",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alertas"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No se ha podido registrar el Proveedor en el sistema",
							"Tipo"=>"error"
							];
					}
				}else{
					$alerta=[
					"Alertas"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El email del Proveedor que acaba de ingresar ya se encuentra resgitrada en el sistema",
					"Tipo"=>"error"
					];
				}

			
			return mainModel::sweet_alert($alerta);
	}

	//CONTROLADOR DE DATOS DEL PROVEEDOR
	public function datos_proveedor_controlador($tipo,$codigo){
		$codigo=mainModel::decryption($codigo);
		$tipo=mainModel::limpiar_cadena($tipo);

		return ProveedorModelo::datos_proveedor_modelo($tipo,$codigo);
	}

	//CONTROLADOR PARA GESTIONAR EL CRUD DEL PROVEEDOR
	public function crud_proveedor_controlador($pagina,$registros,$privilegio,$codigo){

		$pagina=mainModel::limpiar_cadena($pagina);
		$registros=mainModel::limpiar_cadena($registros);
		$privilegio=mainModel::limpiar_cadena($privilegio);
		$codigo=mainModel::limpiar_cadena($codigo);
		$tabla="";
		$pagina= (isset($pagina) && $pagina>0) ? (int)$pagina : 1;
		$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) :0;

		$conexion=mainModel::conectar();

		$datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS * FROM proveedor ORDER BY ProveedorNombre ASC LIMIT $inicio, $registros");
		$datos=$datos->fetchAll();
		$total=$conexion->query("SELECT FOUND_ROWS()");
		$total=(int) $total->fetchColumn();

		$Npaginas=ceil($total/$registros);

		$tabla.='
		<div class="table-responsive">
			<table class="table table-hover text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">NOMBRE</th>
						<th class="text-center">TELÉFONO</th>
						<th class="text-center">EMAIL</th>';
					if($privilegio<=2){
						$tabla.='
						<th class="text-center">ACTUALIZAR</th>
						';
					}
					if($privilegio==1){
						$tabla.='
						<th class="text-center">ELIMINAR</th>
						';
					}

		$tabla.='</tr>
				</thead>
				<tbody>
		';

		if($total>=1 && $pagina<=$Npaginas){
			$contador=$inicio+1;
			foreach ($datos as $rows) {
				$tabla.='
					<tr>
						<td>'.$contador.'</td>
						<td>'.$rows['ProveedorNombre'].'</td>
						<td>'.$rows['ProveedorTelefono'].'</td>
						<td>'.$rows['ProveedorEmail'].'</td>';
						if($privilegio<=2){
							$tabla.='
								<td>
									<a href="'.SERVERURL.'providerdata/admin/'.mainModel::encryption($rows['ProveedorCodigo']).'/" class="btn btn-success btn-raised btn-xs">
										<i class="zmdi zmdi-refresh"></i>
									</a>
								</td>';
					    }
					    if($privilegio==1){
							$tabla.='
								<td>
									<form action="'.SERVERURL.'ajax/proveedorAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="myltipart/form-data" autocomplete="off">
										<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['ProveedorCodigo']).'">
										<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">
										<button type="submit" class="btn btn-danger btn-raised btn-xs">
										<i class="zmdi zmdi-delete"></i>
										</button>
										<div class="RespuestaAjax"></div>
									</form>
								</td>
							';
						}
					
					$tabla.='</tr>';
					$contador++;
					}
				}else{
					if($total>=1){
						$tabla.='
							<tr>
								<td colspan="8"> 
									<a href="'.SERVERURL.'proveedorlist/" class="btn btn-sm btn-info btn-raised">
										Haga clic para recargar el contenido.
									</a>
								</td>
							</tr>
						';
					}else{
						$tabla.='
					<tr>
						<td colspan="7"> No hay registros en el sistema</td>
					</tr>
					';
					}
				}
				
				$tabla.= '</tbody></table></div>';

				if($total>=1 && $pagina<=$Npaginas){
					$tabla.= '
						<nav class="text-center">
						<ul class="pagination pagination-sm">
					';
						if($pagina==1){
							$tabla.= '<li class="disabled"><a><i class="zmdi zmdi-arrow-left"></i></a></li>';
						}else{
							$tabla.= '<li><a href="'.SERVERURL.'proveedorlist/'.($pagina-1).'/"><i class="zmdi zmdi-arrow-left"></i></a></li>';
						}
							for ($i=1; $i<=$Npaginas; $i++){ 
							if ($Npaginas==$i){
								$tabla.= '<li class="active"><a href="'.SERVERURL.'proveedorlist/'.$i.'/">'.$i.'</a></li>';
							}else{
								$tabla.= '<li><a href="'.SERVERURL.'proveedorlist/'.$i.'/">'.$i.'</a></li>';
							}
						}
						if($pagina==$Npaginas){
							$tabla.= '<li class="disabled"><a><i class="zmdi zmdi-arrow-right"></i></a></li>';
						}else{
							$tabla.= '<li><a href="'.SERVERURL.'proveedorlist/'.($pagina+1).'/"><i class="zmdi zmdi-arrow-right"></i></a></li>';
						}
					$tabla.= '</ul></nav>';
				}
				return $tabla;
	}

	//CONTROLADOR PARA ELIMINAR PROVEEDOR
	public function eliminar_proveedor_controlador(){

		$codigo=mainModel::decryption($_POST['codigo-del']);
		$Privilegio=mainModel::decryption($_POST['privilegio-admin']);

		$codigo=mainModel::limpiar_cadena($codigo);
		$Privilegio=mainModel::limpiar_cadena($Privilegio);

		if($Privilegio==1){
			$ElimProveedor=proveedorModelo::eliminar_proveedor_modelo($codigo);
				
			if($ElimProveedor->rowCount()>=1){
				$ElimProve=proveedorModelo::eliminar_proveedor_modelo($codigo);
				$alerta=[
							"Alertas"=>"recargar",
							"Titulo"=>"Proveedor Eliminado",
							"Texto"=>"Se elimino el proveedor de manera satisfactoria",
							"Tipo"=>"success"
						];			
			}else{
				$alerta=[
				"Alertas"=>"simple",
				"Titulo"=>"Ocurrio un error inesperado",
				"Texto"=>"No se puede eliminar el proveedor.",
				"Tipo"=>"error"
			];
			}
		}else{
				$alerta=[
				"Alertas"=>"simple",
				"Titulo"=>"Ocurrio un error inesperado",
				"Texto"=>"No se puede eliminar el proveedor.",
				"Tipo"=>"error"
			];
		}
		return mainModel::sweet_alert($alerta);
		
	}

	//CONTROLADOR PARA ACTUALIZAR DATOS DEL PROVEEDOR
	public function actualizar_proveedor_controlador(){
		$cuenta= mainModel::decryption($_POST['cuenta_update']);
		$nombre= mainModel::limpiar_cadena($_POST['nombre-update']);
		$responsable= mainModel::limpiar_cadena($_POST['responsable-update']);
		$telefono= mainModel::limpiar_cadena($_POST['telefono-update']);
		$email= mainModel::limpiar_cadena($_POST['email-update']);
		$direccion= mainModel::limpiar_cadena($_POST['direccion-update']);
		

		$consulta1=mainModel::ejecutar_consulta_simple("SELECT * FROM proveedor WHERE ProveedorCodigo='$cuenta'");
		$datosProveedor=$consulta1->fetch();

			if($nombre!=$datosProveedor['ProveedorNombre']){
				$const1=mainModel::ejecutar_consulta_simple("SELECT ProveedorNombre FROM proveedor WHERE ProveedorNombre='$nombre'");
				if($const1->rowCount()>=1){
					$alerta=[
						"Alertas"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El proveedor que acaba de actualizar ya se encuenta registrada.",
						"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
				}
			}
				$datosProveedorAct=[
					"Nombre"=>$nombre,
					"Responsable"=>$responsable,
					"Telefono"=>$telefono,
					"Email"=>$email,
					"Direccion"=>$direccion,
					"Codigo"=>$cuenta
				];

				if(proveedorModelo::actualizar_proveedor_modelo($datosProveedorAct)){
					$alerta=[
							"Alertas"=>"recargar",
							"Titulo"=>"Datos actualizados",
							"Texto"=>"Los datos fueron actualizados de manera satisfactoria.",
							"Tipo"=>"success"
							];
				}else{
					$alerta=[
							"Alertas"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"Los datos no han podido ser actualizar los datos, por favor intente nuevamente.",
							"Tipo"=>"error"
							];
							
				}
		return mainModel::sweet_alert($alerta);
	}


}
