<?php 
	if ($peticionAjax) {
	require_once '../modelos/clienteModelo.php';
	} else {
	require_once './modelos/clienteModelo.php';
	}

class clienteControlador extends clienteModelo{

		//CONTROLADOR PARA AGREGAR CLIENTES
		public function agregar_cliente_controlador(){
			$cc=mainModel::limpiar_cadena($_POST["cc-reg"]);
			$nombre=mainModel::limpiar_cadena($_POST["nombre-reg"]);
			$apellido=mainModel::limpiar_cadena($_POST["apellido-reg"]);
			$telefono=mainModel::limpiar_cadena($_POST["telefono-reg"]);
			$ocupacion=mainModel::limpiar_cadena($_POST["ocupacion-reg"]);
			$direccion=mainModel::limpiar_cadena($_POST["direccion-reg"]);

			$usuario=mainModel::limpiar_cadena($_POST["usuario-reg"]);
			$password1=mainModel::limpiar_cadena($_POST["password1-reg"]);
			$password2=mainModel::limpiar_cadena($_POST["password2-reg"]);
			$email=mainModel::limpiar_cadena($_POST["email-reg"]);

			$genero=mainModel::limpiar_cadena($_POST["optionsGenero"]);
			$privilegio=4;


		/*=============================================
			VALIDAR IMAGEN
			=============================================*/
			$ruta = "../vista/assets/avatars/default/default.png";
			
			if(isset($_FILES["imagen-reg"]["tmp_name"])){

			list($ancho, $alto) = getimagesize($_FILES["imagen-reg"]["tmp_name"]);

			$nuevoAncho = 300;
			$nuevoAlto = 300;

			/*=============================================
			CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
			=============================================*/

			$directorio = "../vista/assets/avatars/".$_POST["cc-reg"]."";

			mkdir($directorio, 0755);

			/*=============================================
			DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
			=============================================*/

			if($_FILES["imagen-reg"]["type"] == "image/jpg"){

			/*=============================================
			GUARDAMOS LA IMAGEN EN EL DIRECTORIO
			=============================================*/

			$aleatorio = mt_rand(100,999);

			$ruta = "../vista/assets/avatars/".$_POST["cc-reg"]."/".$aleatorio.".jpg";

			$origen = imagecreatefromjpeg($_FILES["imagen-reg"]["tmp_name"]);						

			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			imagejpeg($destino, $ruta);

			}
			
			if($_FILES["imagen-reg"]["type"] == "image/jpeg"){

			/*=============================================
			GUARDAMOS LA IMAGEN EN EL DIRECTORIO
			=============================================*/

			$aleatorio = mt_rand(100,999);

			$ruta = "../vista/assets/avatars/".$_POST["cc-reg"]."/".$aleatorio.".jpg";

			$origen = imagecreatefromjpeg($_FILES["imagen-reg"]["tmp_name"]);						

			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			imagejpeg($destino, $ruta);

			}

			if($_FILES["imagen-reg"]["type"] == "image/png"){

			/*=============================================
			GUARDAMOS LA IMAGEN EN EL DIRECTORIO
			=============================================*/

			$aleatorio = mt_rand(100,999);

			$ruta = "../vista/assets/avatars/".$_POST["cc-reg"]."/".$aleatorio.".png";

			$origen = imagecreatefrompng($_FILES["imagen-reg"]["tmp_name"]);						

			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			imagepng($destino, $ruta);

			}

			}

			if($password1!=$password2){
				$alerta=[
					"Alertas"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Las contraseñas que acabo de ingresar no coinciden, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}else{

				$consulta1=mainModel::ejecutar_consulta_simple("SELECT ClienteCC FROM cliente WHERE ClienteCC='$cc'");
					if ($consulta1->rowCount()>=1) {
						$alerta=[
							"Alertas"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"La Cedula que acaba de ingresar ya se encuentra resgitrada en el sistema",
							"Tipo"=>"error"
					];
				}else{
					if ($email!="") {
						$consulta2=mainModel::ejecutar_consulta_simple("SELECT CuentaEmail FROM cuenta WHERE CuentaEmail= '$email'" );
						$ec=$consulta2->rowCount();
							}else{
								$ec=0;
							}
							if ($ec>=1) {
								$alerta=[
									"Alertas"=>"simple",
									"Titulo"=>"Ocurrio un error inesperado",
									"Texto"=>"El Correo que acaba de ingresar ya se encuentra resgitrada en el sistema",
									"Tipo"=>"error"
								];
							}else{
								$consulta3=mainModel::ejecutar_consulta_simple("SELECT CuentaUsuario FROM cuenta WHERE CuentaUsuario='$usuario'" );
								if ($consulta3->rowCount()>=1) {
									$alerta=[
										"Alertas"=>"simple",
										"Titulo"=>"Ocurrio un error inesperado",
										"Texto"=>"El Usuario que acaba de ingresar ya se encuentra resgitrada en el sistema",
										"Tipo"=>"error"
											];
								}else{
									$consulta4=mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta");
									$numero=($consulta4->rowCount())+1;

									$codigo=mainModel::generar_codigo_aleatorio("AC",7,$numero);

									$clave=mainModel::encryption($password1);

									$dataAC=[
										"Codigo"=>$codigo,
										"Privilegio"=>$privilegio,
										"Usuario"=>$usuario,
										"Clave"=>$clave,
										"Email"=>$email,
										"Estado"=>"Activo",
										"Tipo"=>"Cliente",
										"Genero"=>$genero,
										"Foto"=>$ruta
										];
									$guardarCuenta=mainModel::agregar_cuenta($dataAC);
									if ($guardarCuenta->rowCount()>=1) {
									$dataAD=[
										"CC"=>$cc,
										"Nombre"=>$nombre,
										"Apellido"=>$apellido,
										"Telefono"=>$telefono,
										"Ocupacion"=>$ocupacion,
										"Direccion"=>$direccion,
										"Codigo"=>$codigo
											];
								
										$guardarAdmin=clienteModelo::agregar_cliente_modelo($dataAD);

										if ($guardarAdmin->rowCount()>=1) {
											$alerta=[
												"Alertas"=>"limpiar",
												"Titulo"=>"Registro exitoso",
												"Texto"=>"Se ha registrado el usuario en el sistema",
												"Tipo"=>"success"
												];
											}else{
												mainModel::eliminar_cuenta($codigo);
												$alerta=[
													"Alertas"=>"simple",
													"Titulo"=>"Ocurrio un error inesperado",
													"Texto"=>"No se ha podido registrar el cliente en el sistema",
													"Tipo"=>"error"
												];
											}
										}else{
											$alerta=[
											"Alertas"=>"simple",
											"Titulo"=>"Ocurrio un error inesperado",
											"Texto"=>"No se ha podido registrar el cliente en el sistema",
											"Tipo"=>"error"
											];

									}

								}
					
							}
						}	
					}
					return mainModel::sweet_alert($alerta);
				}

		//CONTROLADOR PARA GESTIONAR EL CRUD DEL CLIENTE
		public function crud_cliente_controlador($pagina,$registros,$privilegio,$busqueda){

			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";
			$pagina= (isset($pagina) && $pagina>0) ? (int)$pagina : 1;
			$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) :0;

			if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente WHERE (ClienteNombre LIKE '%$busqueda%' OR ClienteApellido LIKE '%$busqueda%' OR ClienteCC LIKE '%$busqueda%' OR ClienteTelefono LIKE '%$busqueda%')  ORDER BY ClienteNombre ASC LIMIT $inicio, $registros";
				$paginaURl="clientsearch";
			}else{  
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente ORDER BY ClienteNombre ASC LIMIT $inicio, $registros";
				$paginaURl="clientlist";
			}
			
			$conexion=mainModel::conectar();

			$datos=$conexion->query("$consulta");
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
							<th class="text-center">CEDULA</th>
							<th class="text-center">NOMBRES</th>
							<th class="text-center">APELLIDOS</th>
							<th class="text-center">TELÉFONO</th>';
						if($privilegio<=2){
							$tabla.='
							<th class="text-center">A. CUENTA</th>
							<th class="text-center">A. DATOS</th>
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
							<td>'.$rows['ClienteCC'].'</td>
							<td>'.$rows['ClienteNombre'].'</td>
							<td>'.$rows['ClienteApellido'].'</td>
							<td>'.$rows['ClienteTelefono'].'</td>';
							if($privilegio<=2){
								$tabla.='
									<td>
										<a href="'.SERVERURL.'myaccount/user/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
											<i class="zmdi zmdi-refresh"></i>
										</a>
									</td>
									<td>
										<a href="'.SERVERURL.'mydata/user/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
											<i class="zmdi zmdi-refresh"></i>
										</a>
									</td>';
						    }
						    if($privilegio==1){
								$tabla.='
									<td>
										<form action="'.SERVERURL.'ajax/clienteAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="myltipart/form-data" autocomplete="off">
											<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['CuentaCodigo']).'">
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
										<a href="'.SERVERURL.$paginaURl.'/" class="btn btn-sm btn-info btn-raised">
											Haga clic para recargar el contenido.
										</a>
									</td>
								</tr>
							';
						}else{
							$tabla.='
						<tr>
							<td colspan="8"> No hay registros en el sistema</td>
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
								$tabla.= '<li><a href="'.SERVERURL.$paginaURl.'/'.($pagina-1).'/"><i class="zmdi zmdi-arrow-left"></i></a></li>';
							}
								for ($i=1; $i<=$Npaginas; $i++){ 
								if ($Npaginas==$i){
									$tabla.= '<li class="active"><a href="'.SERVERURL.$paginaURl.'/'.$i.'/">'.$i.'</a></li>';
								}else{
									$tabla.= '<li><a href="'.SERVERURL.$paginaURl.'/'.$i.'/">'.$i.'</a></li>';
								}
							}
							if($pagina==$Npaginas){
								$tabla.= '<li class="disabled"><a><i class="zmdi zmdi-arrow-right"></i></a></li>';
							}else{
								$tabla.= '<li><a href="'.SERVERURL.$paginaURl.'/'.($pagina+1).'/"><i class="zmdi zmdi-arrow-right"></i></a></li>';
							}
						$tabla.= '</ul></nav>';
					}
					return $tabla;
		}
		
		//CONTROLADOR PARA ELIMINAR CLIENTE
		public function eliminar_cliente_controlador(){

			$codigo=mainModel::decryption($_POST['codigo-del']);
			$Privilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$Privilegio=mainModel::limpiar_cadena($Privilegio);

			if($Privilegio==1){
				$ElimCliente=clienteModelo::eliminar_cliente_modelo($codigo);
					mainModel::eliminar_bitacora($codigo);
			
				if($ElimCliente->rowCount()>=1){
					$ElimAdmin=clienteModelo::eliminar_cliente_modelo($codigo);
					mainModel::eliminar_bitacora($codigo);
					if($ElimCliente->rowCount()>=1){
						$Elimcuenta=mainModel::eliminar_cuenta($codigo);
						if($Elimcuenta->rowCount()>=1){
							$alerta=[
								"Alertas"=>"recargar",
								"Titulo"=>"Cliente Eliminado",
								"Texto"=>"Se elimino el cliente de manera satisfactoria",
								"Tipo"=>"success"
							];
						}else{
							$alerta=[
								"Alertas"=>"simple",
								"Titulo"=>"Ocurrio un error inesperado",
								"Texto"=>"No se puedo eliminar esta cuenta administrador.",
								"Tipo"=>"error"
							];
						}
					}else{
						$alerta=[
					"Alertas"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No se puedo eliminar el administrador.",
					"Tipo"=>"error"
				];
					}
				}else{
					$alerta=[
					"Alertas"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No se puede eliminar el cliente.",
					"Tipo"=>"error"
				];
				}
			}else{
				$alerta=[
					"Alertas"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"No cumples con los roles para ejecutar esta acción.",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		
		}

		//CONTROLADOR DE DATOS DE LOS CLIENTE
		public function datos_cliente_controlador($tipo,$codigo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			return clienteModelo::datos_cliente_modelo($tipo,$codigo);
		}

		//CONTROLADOR PARA ACTUALIZAR DATOS DE LOS CLIENTE
		public function actualizar_cliente_controlador(){
			$cuenta= mainModel::decryption($_POST['cuenta_update']);
			$CC= mainModel::limpiar_cadena($_POST['CC-update']);
			$nombre= mainModel::limpiar_cadena($_POST['nombre-update']);
			$apellido= mainModel::limpiar_cadena($_POST['apellido-update']);
			$telefono= mainModel::limpiar_cadena($_POST['telefono-update']);
			$ocupacion= mainModel::limpiar_cadena($_POST['ocupacion-update']);
			$direccion= mainModel::limpiar_cadena($_POST['direccion-update']);

			$consulta1=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE CuentaCodigo='$cuenta'");
			$datosCliente=$consulta1->fetch();

				if($CC!=$datosCliente['ClienteCC']){
					$const1=mainModel::ejecutar_consulta_simple("SELECT ClienteCC FROM cliente WHERE ClienteCC='$CC'");
					if($const1->rowCount()>=1){
						$alerta=[
							"Alertas"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"La Cedula que acaba de actualizar ya se encuenta registrada.",
							"Tipo"=>"error"
							];
							return mainModel::sweet_alert($alerta);
							exit();
					}
				}
					$datosClienteAct=[
						"CC"=>$CC,
						"Nombre"=>$nombre,
						"Apellido"=>$apellido,
						"Telefono"=>$telefono,
						"Ocupacion"=>$ocupacion,
						"Direccion"=>$direccion,
						"Codigo"=>$cuenta
					];

					if(clienteModelo::actualizar_cliente_modelo($datosClienteAct)){
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