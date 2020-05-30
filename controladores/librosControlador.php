<?php 
	if ($peticionAjax) {
	require_once '../modelos/librosModelo.php';
	} else {
	require_once './modelos/librosModelo.php';
	}

class librosControlador extends librosModelo{

		//CONTROLADOR PARA AGREGAR LIBROS
	public function agregar_libros_controlador(){
		$codigo=mainModel::limpiar_cadena($_POST["codigo-reg"]);
		$titulo=mainModel::limpiar_cadena($_POST["titulo-reg"]);
		$autor=mainModel::limpiar_cadena($_POST["autor-reg"]);
		$pais=mainModel::limpiar_cadena($_POST["pais-reg"]);
		$year=mainModel::limpiar_cadena($_POST["year-reg"]);
		$editorial=mainModel::limpiar_cadena($_POST["editorial-reg"]);
		$edicion=mainModel::limpiar_cadena($_POST["edicion-reg"]);
		$precio=mainModel::limpiar_cadena($_POST["precio-reg"]);
		$paginas=mainModel::limpiar_cadena($_POST["paginas-reg"]);
		$ubicacion=mainModel::limpiar_cadena($_POST["ubicacion-reg"]);
		$resumen=mainModel::limpiar_cadena($_POST["resumen-reg"]);
		$categoria=mainModel::limpiar_cadena($_POST["categoria-reg"]);
		$proveedor=mainModel::limpiar_cadena($_POST["proveedor-reg"]);
		$empresa=mainModel::limpiar_cadena($_POST["empresa-reg"]);

			/*=============================================
			VALIDAR IMAGEN
			=============================================*/
			$ruta = "../vista/assets/CaratulaLibro/default/anonymous.png";
			
			if(isset($_FILES["imagen-reg"]["tmp_name"])){

			list($ancho, $alto) = getimagesize($_FILES["imagen-reg"]["tmp_name"]);

			$nuevoAncho = 500;
			$nuevoAlto = 500;

			/*=============================================
			CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
			=============================================*/

			$directorio = "../vista/assets/CaratulaLibro/".$_POST["codigo-reg"]."";

			mkdir($directorio, 0755);

			/*=============================================
			DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
			=============================================*/

			if($_FILES["imagen-reg"]["type"] == "image/jpg"){

			/*=============================================
			GUARDAMOS LA IMAGEN EN EL DIRECTORIO
			=============================================*/

			$aleatorio = mt_rand(100,999);

			$ruta = "../vista/assets/CaratulaLibro/".$_POST["codigo-reg"]."/".$aleatorio.".jpg";

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

			$ruta = "../vista/assets/CaratulaLibro/".$_POST["codigo-reg"]."/".$aleatorio.".jpg";

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

			$ruta = "../vista/assets/CaratulaLibro/".$_POST["codigo-reg"]."/".$aleatorio.".png";

			$origen = imagecreatefrompng($_FILES["imagen-reg"]["tmp_name"]);						

			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			imagepng($destino, $ruta);

			}

			}

			/*=============================================
			GUARDAMOS PDF EN EL DIRECTORIO
			=============================================*/
			$archivo = isset($_FILES["pdf-reg"]) ? $_FILES["pdf-reg"]:NULL;
			if ($archivo) {
			$extension = pathinfo($archivo["name"], PATHINFO_EXTENSION);
			$extension = strtolower($extension);
			$extension_correcta = ($extension == 'doc' or $extension == 'docx' or $extension == 'pdf');
			if ($extension_correcta) {
			$ruta_destino_archivo = "../vista/assets/Librospdf/{$archivo["name"]}";
			$archivo_ok = move_uploaded_file($archivo["tmp_name"], $ruta_destino_archivo);
			}    
			}

		$consulta1=mainModel::ejecutar_consulta_simple("SELECT LibroCodigo FROM libro WHERE LibroCodigo='$codigo'");
				
			if ($consulta1->rowCount()<=0){

				$consulta2=mainModel::ejecutar_consulta_simple("SELECT LibroTitulo FROM libro WHERE LibroTitulo='$titulo'");

				if($consulta2->rowCount()<=0){
					$datoslibros=[
						"Codigo"=>$codigo,
						"Titulo"=>$titulo,
						"Autor"=>$autor,
						"Pais"=>$pais,
						"Year"=>$year,
						"Editorial"=>$editorial,
						"Edicion"=>$edicion,
						"Precio"=>$precio,
						"Paginas"=>$paginas,
						"Ubicacion"=>$ubicacion,
						"Resumen"=>$resumen,
						"Imagen"=>$ruta,
						"Pdf"=>$ruta_destino_archivo,
						"CateCodigo"=>$categoria,
						"ProveCodigo"=>$proveedor,
						"EmpreCodigo"=>$empresa
						];

					$guardarLibros=librosModelo::agregar_libros_modelo($datoslibros);
					if($guardarLibros->rowCount()>=1){
						$alerta=[
							"Alertas"=>"recargar",
							"Titulo"=>"Registro exitoso",
							"Texto"=>"Se ha registrado el libro en el sistema",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alertas"=>"simple",
							"Titulo"=>"Ocurrio un error inesperado",
							"Texto"=>"No se ha podido registrar el libro en el sistema",
							"Tipo"=>"error"
							];
					}
				}else{
					$alerta=[
					"Alertas"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"El Titulo del libro que acaba de ingresar ya se encuentra resgitrada en el sistema",
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

	//CONTROLADOR DE DATOS DE LOS LIBROS
	public function datos_libros_controlador($tipo,$codigo){
		$codigo=mainModel::decryption($codigo);
		$tipo=mainModel::limpiar_cadena($tipo);

		return librosModelo::datos_libros_modelo($tipo,$codigo);
	}

	//CONTROLADOR PARA GESTIONAR EL CRUD DE LOS LIBROS
	public function crud_libros_controlador($pagina,$registros,$privilegio,$codigo, $busqueda){

		$pagina=mainModel::limpiar_cadena($pagina);
		$registros=mainModel::limpiar_cadena($registros);
		$privilegio=mainModel::limpiar_cadena($privilegio);
		$busqueda=mainModel::limpiar_cadena($busqueda);
		$codigo=mainModel::limpiar_cadena($codigo);
		$tabla="";
		$pagina= (isset($pagina) && $pagina>0) ? (int)$pagina : 1;
		$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) :0;

	
		if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM libro WHERE ((LibroCodigo!='$codigo' AND id!='1') AND (LibroTitulo LIKE '%$busqueda%' OR LibroAutor LIKE '%$busqueda%' OR LibroPais LIKE '%$busqueda%' OR LibroEditorial LIKE '%$busqueda%' OR LibroEdicion LIKE '%$busqueda%'))  ORDER BY LibroTitulo ASC LIMIT $inicio, $registros";
				$paginaurl="booksearch";
			}else{  
				$consulta=("SELECT SQL_CALC_FOUND_ROWS * FROM libro ORDER BY LibroCodigo ASC LIMIT $inicio, $registros");
				$paginaurl="booklist";
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
						<th class="text-center">REFERENCIA</th>
						<th class="text-center">TITULO</th>
						<th class="text-center">AUTOR</th>
						<th class="text-center">EDITORIAL</th>
						<th class="text-center">EDICION</th>';
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
						<td>'.$rows['LibroCodigo'].'</td>
						<td>'.$rows['LibroTitulo'].'</td>
						<td>'.$rows['LibroAutor'].'</td>
						<td>'.$rows['LibroEditorial'].'</td>
						<td>'.$rows['LibroEdicion'].'</td>';
						if($privilegio<=2){
							$tabla.='
								<td>
									<a href="'.SERVERURL.'bookconfig/'.mainModel::encryption($rows['id']).'/" class="btn btn-success btn-raised btn-xs">
										<i class="zmdi zmdi-refresh"></i>
									</a>
								</td>';
					    }
					    if($privilegio==1){
							$tabla.='
								<td>
									<form action="'.SERVERURL.'ajax/librosAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="myltipart/form-data" autocomplete="off">
										<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['LibroCodigo']).'">
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
									<a href="'.SERVERURL.$paginaurl.'" class="btn btn-sm btn-info btn-raised">
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

	//CONTROLADOR PARA ACTUALIZAR DATOS DE LOS LIBROS
	public function actualizar_libros_controlador(){

		$cuenta=mainModel::decryption($_POST["codigo"]);
		$ref= mainModel::limpiar_cadena($_POST['referencia-up']);
		$titulo=mainModel::limpiar_cadena($_POST["titulo-up"]);
		$autor=mainModel::limpiar_cadena($_POST["autor-up"]);
		$pais=mainModel::limpiar_cadena($_POST["pais-up"]);
		$editorial=mainModel::limpiar_cadena($_POST["editorial-up"]);
		$edicion=mainModel::limpiar_cadena($_POST["edicion-up"]);
		$year=mainModel::limpiar_cadena($_POST["year-up"]);
		$precio=mainModel::limpiar_cadena($_POST["precio-up"]);
		$paginas=mainModel::limpiar_cadena($_POST["paginas-up"]);
		$ubicacion=mainModel::limpiar_cadena($_POST["ubicacion-up"]);
		$resumen=mainModel::limpiar_cadena($_POST["resumen-up"]);


		$consulta1=mainModel::ejecutar_consulta_simple ("SELECT * FROM libro WHERE id='$cuenta'");
				
				$datosLibros=$consulta1->fetch();

				if($ref!=$datosLibros['LibroCodigo']){
				$const1=mainModel::ejecutar_consulta_simple("SELECT LibroCodigo FROM libro WHERE LibroCodigo='$ref'");
				if($const1->rowCount()>=1){
					$alerta=[
						"Alertas"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"La referencia del libro que acaba de actualizar ya se encuenta registrada.",
						"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alerta);
						exit();
				}
			}


			$datosLibrosAct=[
						"Referencia"=>$ref,
						"Titulo"=>$titulo,
						"Autor"=>$autor,
						"Pais"=>$pais,
						"Year"=>$year,
						"Editorial"=>$editorial,
						"Edicion"=>$edicion,
						"Precio"=>$precio,
						"Paginas"=>$paginas,
						"Ubicacion"=>$ubicacion,
						"Resumen"=>$resumen,
						"Id"=>$cuenta
						];

			if(librosModelo::actualizar_libros_modelo($datosLibrosAct)){
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

		//CONTROLADOR PARA ELIMINAR LIBROS
	public function eliminar_libros_controlador(){

		$codigo=mainModel::decryption($_POST['codigo-del']);
		$Privilegio=mainModel::decryption($_POST['privilegio-admin']);

		$codigo=mainModel::limpiar_cadena($codigo);
		$Privilegio=mainModel::limpiar_cadena($Privilegio);

		if($Privilegio==1){
			$ElimLibros=librosModelo::eliminar_libros_modelo($codigo);
				
			if($ElimLibros->rowCount()>=1){
				$ElimLibros=librosModelo::eliminar_libros_modelo($codigo);
				$alerta=[
							"Alertas"=>"recargar",
							"Titulo"=>"Libro Eliminado.",
							"Texto"=>"Se elimino el libro de manera satisfactoria.",
							"Tipo"=>"success"
						];			
			}else{
				$alerta=[
				"Alertas"=>"simple",
				"Titulo"=>"Ocurrio un error inesperado.",
				"Texto"=>"No se puede eliminar el libro.",
				"Tipo"=>"error"
			];
			}
		}else{
				$alerta=[
				"Alertas"=>"simple",
				"Titulo"=>"Ocurrio un error inesperado",
				"Texto"=>"No se puede eliminar el libro..",
				"Tipo"=>"error"
			];
		}
		return mainModel::sweet_alert($alerta);
		
	}


	//CONTROLADOR PARA GESTIONAR EL CRUD DE LOS LIBROS
	public function crud_mostrar_libros_controlador($pagina,$registros,$privilegio,$codigo,$busqueda){

		$pagina=mainModel::limpiar_cadena($pagina);
		$registros=mainModel::limpiar_cadena($registros);
		$privilegio=mainModel::limpiar_cadena($privilegio);
		$busqueda=mainModel::limpiar_cadena($busqueda);
		$codigo=mainModel::limpiar_cadena($codigo);
		$tabla="";
		$pagina= (isset($pagina) && $pagina>0) ? (int)$pagina : 1;
		$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) :0;

	
		if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM libro WHERE ((LibroCodigo!='$codigo' AND id!='1') AND (LibroTitulo LIKE '%$busqueda%' OR LibroAutor LIKE '%$busqueda%' OR LibroPais LIKE '%$busqueda%' OR LibroEditorial LIKE '%$busqueda%' OR LibroEdicion LIKE '%$busqueda%'))  ORDER BY LibroTitulo ASC LIMIT $inicio, $registros";
				$paginaurl="search";
			}else{  
				$consulta=("SELECT SQL_CALC_FOUND_ROWS * FROM libro ORDER BY LibroTitulo ASC LIMIT $inicio, $registros");
				$paginaurl="catalog";
			}

			$conexion=mainModel::conectar();
			$datos=$conexion->query("$consulta");
			$datos=$datos->fetchAll();
			$total=$conexion->query("SELECT FOUND_ROWS()");
			$total=(int) $total->fetchColumn();

			$Npaginas=ceil($total/$registros);

		$tabla.='
		<div class="table-responsive">
			<table class="table table-hover text-center" >
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">CARATULA</th>
						<th class="text-center">TITULO</th>
						<th class="text-center">AUTOR</th>

						';
					if($privilegio<=4){
						$tabla.='
						<th class="text-center">VER PDF</th>

						';
					}
					if($privilegio<=4){
						$tabla.='
						<th class="text-center">MÁS INFORMACIÓN</th>
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
						<td><img src="'.$rows['LibroImagen'].'"width="90"</td>
						<td>'.$rows['LibroTitulo'].'</td>
						<td>'.$rows['LibroAutor'].'</td>
						<td>
							<button type="submit" class="btn btn-info btn-raised " title="Ver PDF">
								<a href="'.$rows['LibroPDF'].'#toolbar=0&navpanes=0&scrollbar=0" target="_blank" onclick="window.open(this.href,this.target);return false;">
										<i class="zmdi zmdi-collection-pdf"></i>
								</a> 
						</button></td>
						';

						if($privilegio<=4){
							$tabla.='
								<td>
									<a href="'.SERVERURL.'bookinfo/'.mainModel::encryption($rows['id'], $rows['LibroImagen']).'/" class="btn btn-success btn-raised " title="Más información" target="_blank">
										<i class="zmdi zmdi-info"></i>
									</a>
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
								<td colspan="6"> 
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

}
