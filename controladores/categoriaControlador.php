<?php 
	if ($peticionAjax) {
	require_once '../modelos/categoriaModelo.php';
	} else {
	require_once './modelos/categoriaModelo.php';
	}

class categoriaControlador extends categoriaModelo{

	//CONTROLADOR PARA AGREGAR EMPRESAS
	public function agregar_categoria_controlador(){
		$codigo=mainModel::limpiar_cadena($_POST["cc-reg"]);
		$nombre=mainModel::limpiar_cadena($_POST["nombre-reg"]);
	
		$consulta1=mainModel::ejecutar_consulta_simple("SELECT CategoriaCodigo FROM categoria WHERE CategoriaCodigo='$codigo'");
				
			if ($consulta1->rowCount()<=0){

				$consulta2=mainModel::ejecutar_consulta_simple("SELECT CategoriaNombre FROM categoria WHERE CategoriaNombre='$nombre'");	

				if($consulta2->rowCount()<=0){
					$datosCategoria=[
						"Codigo"=>$codigo,
						"Nombre"=>$nombre
						];
					$guardarCategoria=categoriaModelo::agregar_categoria_modelo($datosCategoria);
					if($guardarCategoria->rowCount()>=1){
						$alerta=[
							"Alertas"=>"recargar",
							"Titulo"=>"Registro exitoso",
							"Texto"=>"Se ha registrado la categoria en el sistema",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alertas"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No se ha podido registrar la categoria en el sistema",
							"Tipo"=>"error"
							];
					}
				}else{
					$alerta=[
					"Alertas"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El nombre de la categoria que acaba de ingresar ya se encuentra resgitrada en el sistema",
					"Tipo"=>"error"
					];
				}

			}else{
				$alerta=[
					"Alertas"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El Codigo que acaba de ingresar ya se encuentra resgitrada en el sistema",
					"Tipo"=>"error"
					];
			}
			return mainModel::sweet_alert($alerta);
	}

	//CONTROLADOR DE DATOS DE LA CATEGORIA
	public function datos_categoria_controlador($tipo,$codigo){
		$codigo=mainModel::decryption($codigo);
		$tipo=mainModel::limpiar_cadena($tipo);

		return categoriaModelo::datos_categoria_modelo($tipo,$codigo);
	}


	//CONTROLADOR PARA GESTIONAR EL CRUD DE LA CATEGORIA
	public function crud_categoria_controlador($pagina,$registros,$privilegio,$codigo){

		$pagina=mainModel::limpiar_cadena($pagina);
		$registros=mainModel::limpiar_cadena($registros);
		$privilegio=mainModel::limpiar_cadena($privilegio);
		$codigo=mainModel::limpiar_cadena($codigo);
		$tabla="";
		$pagina= (isset($pagina) && $pagina>0) ? (int)$pagina : 1;
		$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) :0;

		$conexion=mainModel::conectar();

		$datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS * FROM categoria ORDER BY CategoriaNombre ASC LIMIT $inicio, $registros");
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
						<th class="text-center">CÓDIGO</th>
						<th class="text-center">NOMBRE</th>
						';
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
						<td>'.$rows['CategoriaCodigo'].'</td>
						<td>'.$rows['CategoriaNombre'].'</td>
					';
						if($privilegio<=2){
							$tabla.='
								<td>
									<a href="'.SERVERURL.'categorydata/admin/'.mainModel::encryption($rows['CategoriaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
										<i class="zmdi zmdi-refresh"></i>
									</a>
								</td>';
					    }
					    if($privilegio==1){
							$tabla.='
								<td>
									<form action="'.SERVERURL.'ajax/categoriaAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="myltipart/form-data" autocomplete="off">
										<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['CategoriaCodigo']).'">
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
								<td colspan="5"> 
									<a href="'.SERVERURL.'categorylist/" class="btn btn-sm btn-info btn-raised">
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
							$tabla.= '<li><a href="'.SERVERURL.'categorylist/'.($pagina-1).'/"><i class="zmdi zmdi-arrow-left"></i></a></li>';
						}
							for ($i=1; $i<=$Npaginas; $i++){ 
							if ($Npaginas==$i){
								$tabla.= '<li class="active"><a href="'.SERVERURL.'categorylist/'.$i.'/">'.$i.'</a></li>';
							}else{
								$tabla.= '<li><a href="'.SERVERURL.'categorylist/'.$i.'/">'.$i.'</a></li>';
							}
						}
						if($pagina==$Npaginas){
							$tabla.= '<li class="disabled"><a><i class="zmdi zmdi-arrow-right"></i></a></li>';
						}else{
							$tabla.= '<li><a href="'.SERVERURL.'categorylist/'.($pagina+1).'/"><i class="zmdi zmdi-arrow-right"></i></a></li>';
						}
					$tabla.= '</ul></nav>';
				}
				return $tabla;
	}

	//CONTROLADOR PARA ELIMINAR CATEGORIA
	public function eliminar_categoria_controlador(){

		$codigo=mainModel::decryption($_POST['codigo-del']);
		$Privilegio=mainModel::decryption($_POST['privilegio-admin']);

		$codigo=mainModel::limpiar_cadena($codigo);
		$Privilegio=mainModel::limpiar_cadena($Privilegio);

		if($Privilegio==1){
			$ElimCategoria=categoriaModelo::eliminar_categoria_modelo($codigo);
				
			if($ElimCategoria->rowCount()>=1){
				$ElimCap=categoriaModelo::eliminar_categoria_modelo($codigo);
				$alerta=[
							"Alertas"=>"recargar",
							"Titulo"=>"Categoria Eliminada",
							"Texto"=>"Se elimino la categoria de manera satisfactoria",
							"Tipo"=>"success"
						];			
			}else{
				$alerta=[
				"Alertas"=>"simple",
				"Titulo"=>"Ocurrio un error inesperado",
				"Texto"=>"No se puede eliminar la categoria.",
				"Tipo"=>"error"
			];
			}
		}else{
				$alerta=[
				"Alertas"=>"simple",
				"Titulo"=>"Ocurrio un error inesperado",
				"Texto"=>"No se puede eliminar la categoria.",
				"Tipo"=>"error"
			];
		}
		return mainModel::sweet_alert($alerta);
		
	}

	//CONTROLADOR PARA ACTUALIZAR DATOS DE LA CATEGORIA
	public function actualizar_categoria_controlador(){
		$cuenta= mainModel::decryption($_POST['cuenta_update']);
		$nombre= mainModel::limpiar_cadena($_POST['nombre-update']);
		
		$consulta1=mainModel::ejecutar_consulta_simple("SELECT * FROM categoria WHERE CategoriaCodigo='$cuenta'");
		$datoscategoria=$consulta1->fetch();

			if($nombre!=$datoscategoria['CategoriaNombre']){
				$const1=mainModel::ejecutar_consulta_simple("SELECT CategoriaNombre FROM categoria WHERE CategoriaNombre='$nombre'");
				if($const1->rowCount()>=1){
					$alerta=[
						"Alertas"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"La Categoria que acaba de actualizar ya se encuenta registrada.",
						"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
				}
			}
				$datosCategoriaAct=[
					"Nombre"=>$nombre,
					"Codigo"=>$cuenta
				];

				if(categoriaModelo::actualizar_categoria_modelo($datosCategoriaAct)){
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


