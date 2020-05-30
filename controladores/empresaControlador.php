<?php 
	if ($peticionAjax) {
	require_once '../modelos/empresaModelo.php';
	} else {
	require_once './modelos/empresaModelo.php';
	}

class empresaControlador extends empresaModelo{

	//CONTROLADOR PARA AGREGAR EMPRESA
	public function agregar_empresa_controlador(){
		$codigo=mainModel::limpiar_cadena($_POST["cc-reg"]);
		$nombre=mainModel::limpiar_cadena($_POST["nombre-reg"]);
		$telefono=mainModel::limpiar_cadena($_POST["telefono-reg"]);
		$email=mainModel::limpiar_cadena($_POST["email-reg"]);
		$direccion=mainModel::limpiar_cadena($_POST["direccion-reg"]);
		$director=mainModel::limpiar_cadena($_POST["director-reg"]);
		$telefono2=mainModel::limpiar_cadena($_POST["telefono2-reg"]);
		$year=mainModel::limpiar_cadena($_POST["year-reg"]);
		
		
		$consulta1=mainModel::ejecutar_consulta_simple("SELECT EmpresaCodigo FROM empresa WHERE EmpresaCodigo='$codigo'");
				
			if ($consulta1->rowCount()<=0){

				$consulta2=mainModel::ejecutar_consulta_simple("SELECT EmpresaNombre FROM empresa WHERE EmpresaNombre='$nombre'");	

				if($consulta2->rowCount()<=0){
					$datosEmpresa=[
						"Codigo"=>$codigo,
						"Nombre"=>$nombre,
						"Telefono"=>$telefono,
						"Email"=>$email,
						"Direccion"=>$direccion,
						"Director"=>$director,
						"Telefono2"=>$telefono2,
						"Year"=>$year
						];
					$guardarEmpresa=empresaModelo::agregar_empresa_modelo($datosEmpresa);
					if($guardarEmpresa->rowCount()>=1){
						$alerta=[
							"Alertas"=>"recargar",
							"Titulo"=>"Registro exitoso",
							"Texto"=>"Se ha registrado la empresa en el sistema",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alertas"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No se ha podido registrar la Empresa en el sistema",
							"Tipo"=>"error"
							];
					}
				}else{
					$alerta=[
					"Alertas"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El nombre de la empresa que acaba de ingresar ya se encuentra resgitrada en el sistema",
					"Tipo"=>"error"
					];
				}

			}else{
				$alerta=[
					"Alertas"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El NIT que acaba de ingresar ya se encuentra resgitrada en el sistema",
					"Tipo"=>"error"
					];
			}
			return mainModel::sweet_alert($alerta);
	}

	//CONTROLADOR DE DATOS DE LA EMPRESA
	public function datos_empresa_controlador($tipo,$codigo){
		$codigo=mainModel::decryption($codigo);
		$tipo=mainModel::limpiar_cadena($tipo);

		return empresaModelo::datos_empresa_modelo($tipo,$codigo);
	}


	//CONTROLADOR PARA GESTIONAR EL CRUD DE LA EMPRESA
	public function crud_empresa_controlador($pagina,$registros,$privilegio,$codigo){

		$pagina=mainModel::limpiar_cadena($pagina);
		$registros=mainModel::limpiar_cadena($registros);
		$privilegio=mainModel::limpiar_cadena($privilegio);
		$codigo=mainModel::limpiar_cadena($codigo);
		$tabla="";
		$pagina= (isset($pagina) && $pagina>0) ? (int)$pagina : 1;
		$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) :0;

		$conexion=mainModel::conectar();

		$datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS * FROM empresa ORDER BY EmpresaNombre ASC LIMIT $inicio, $registros");

		$paginaurl="companylist";

		
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
						<th class="text-center">CÓDIGO DE REGISTRO</th>
						<th class="text-center">NOMBRE</th>
						<th class="text-center">EMAIL</th>
						<th class="text-center">TELÉFONO</th>';
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
						<td>'.$rows['EmpresaCodigo'].'</td>
						<td>'.$rows['EmpresaNombre'].'</td>
						<td>'.$rows['EmpresaEmail'].'</td>
						<td>'.$rows['EmpresaTelefono'].'</td>';
						if($privilegio<=2){
							$tabla.='
								<td>
									<a href="'.SERVERURL.'companydata/'.mainModel::encryption($rows['id']).'/" class="btn btn-success btn-raised btn-xs">
										<i class="zmdi zmdi-refresh"></i>
									</a>
								</td>';
					    }
					    if($privilegio==1){
							$tabla.='
								<td>
									<form action="'.SERVERURL.'ajax/empresaAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="myltipart/form-data" autocomplete="off">
										<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['EmpresaCodigo']).'">
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
								<td colspan="6 "> 
									<a href="'.SERVERURL.$paginaurl.'" class="btn btn-sm btn-info btn-raised">
										Haga clic para recargar el contenido.
									</a>
								</td>
							</tr>
						';
					}else{
						$tabla.='
					<tr>
						<td colspan="6"> No hay registros en el sistema</td>
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
							$tabla.= '<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina-1).'/"><i class="zmdi zmdi-arrow-left"></i></a></li>';
						}
							for ($i=1; $i<=$Npaginas; $i++){ 
							if ($Npaginas==$i){
								$tabla.= '<li class="active"><a href="'.SERVERURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>';
							}else{
								$tabla.= '<li><a href="'.SERVERURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>';
							}
						}
						if($pagina==$Npaginas){
							$tabla.= '<li class="disabled"><a><i class="zmdi zmdi-arrow-right"></i></a></li>';
						}else{
							$tabla.= '<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina+1).'/"><i class="zmdi zmdi-arrow-right"></i></a></li>';
						}
					$tabla.= '</ul></nav>';
				}
				return $tabla;
	}

	//CONTROLADOR PARA ELIMINAR EMPRESA
	public function eliminar_empresa_controlador(){

		$codigo=mainModel::decryption($_POST['codigo-del']);
		$Privilegio=mainModel::decryption($_POST['privilegio-admin']);

		$codigo=mainModel::limpiar_cadena($codigo);
		$Privilegio=mainModel::limpiar_cadena($Privilegio);

		if($Privilegio==1){

			$consulta1=mainModel::ejecutar_consulta_simple("SELECT EmpresaCodigo FROM libro WHERE EmpresaCodigo='$codigo'");

			
			if($consulta1->rowCount()<=0){
				$ElimEmp=empresaModelo::eliminar_empresa_modelo($codigo);
				
				if($ElimEmp->rowCount()==1){
					$alerta=[
							"Alertas"=>"recargar",
							"Titulo"=>"Empresa Eliminada",
							"Texto"=>"Se elimino la empresa de manera satisfactoria",
							"Tipo"=>"success"
						];	
				}else{
					$alerta=[
					"Alertas"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Lo sentimos no se puede eliminar la empresa, ",
					"Tipo"=>"error"
					];
				}	
			}else{
				$alerta=[
				"Alertas"=>"simple",
				"Titulo"=>"Ocurrio un error inesperado",
				"Texto"=>"No se puede eliminar la empresa, teniendo en cuenta que hay libros asociados a esta empresa",
				"Tipo"=>"error"
			];
			}
		}else{
				$alerta=[
				"Alertas"=>"simple",
				"Titulo"=>"Ocurrio un error inesperado",
				"Texto"=>"No se puede eliminar la empresa.",
				"Tipo"=>"error"
			];
		}
		return mainModel::sweet_alert($alerta);
		
	}

	//CONTROLADOR PARA ACTUALIZAR DATOS DE LA EMPRESA
	public function actualizar_empresa_controlador(){
		
		$cuenta= mainModel::decryption($_POST['codigo']);
		$nit= mainModel::limpiar_cadena($_POST['nit-update']);
		$nombre= mainModel::limpiar_cadena($_POST['nombre-update']);
		$telefono= mainModel::limpiar_cadena($_POST['telefono-update']);
		$email= mainModel::limpiar_cadena($_POST['email-update']);
		$direccion= mainModel::limpiar_cadena($_POST['direccion-update']);
		$director= mainModel::limpiar_cadena($_POST['director-update']);
		$telefono2= mainModel::limpiar_cadena($_POST['telefono2-update']);
		$year= mainModel::limpiar_cadena($_POST['year-update']);
		

		$consulta1=mainModel::ejecutar_consulta_simple("SELECT * FROM empresa WHERE id='$cuenta'");
		$datosEmpresa=$consulta1->fetch();

			if($nit!=$datosEmpresa['EmpresaCodigo']){
				$const1=mainModel::ejecutar_consulta_simple("SELECT EmpresaCodigo FROM empresa WHERE EmpresaCodigo='$nit'");
				if($const1->rowCount()>=1){
					$alerta=[
						"Alertas"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"La Empresa que acaba de actualizar ya se encuenta registrada.",
						"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
				}
			}
				$datosEmpresaAct=[
					"Nit"=>$nit,
					"Nombre"=>$nombre,
					"Telefono"=>$telefono,
					"Email"=>$email,
					"Direccion"=>$direccion,
					"Director"=>$director,
					"Telefono2"=>$telefono2,
					"Year"=>$year,
					"Id"=>$cuenta
				];

				if(empresaModelo::actualizar_empresa_modelo($datosEmpresaAct)){
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

