<?php 
	if ($peticionAjax) {
	require_once '../core/mainModel.php';
	} else {
	require_once './core/mainModel.php';
	}

class librosModelo extends mainModel{

		//CREACION DEL MODELO DE AGREGAR LIBROS
	protected function agregar_libros_modelo ($datos){
		$sql=mainModel::conectar()->prepare("INSERT INTO libro (LibroCodigo,LibroTitulo,LibroAutor,LibroPais,LibroYear,LibroEditorial,LibroEdicion,LibroPrecio,LibroPaginas,LibroUbicacion,LibroResumen,LibroImagen,LibroPDF,CategoriaCodigo,ProveedorCodigo,EmpresaCodigo) VALUES (:Codigo,:Titulo,:Autor,:Pais,:Year,:Editorial,:Edicion,:Precio,:Paginas,:Ubicacion,:Resumen,:Imagen,:Pdf,:CateCodigo,:ProveCodigo,:EmpreCodigo)");

		$sql->bindParam(":Codigo",$datos["Codigo"]);
		$sql->bindParam(":Titulo",$datos["Titulo"]);
		$sql->bindParam(":Autor",$datos["Autor"]);
		$sql->bindParam(":Pais",$datos["Pais"]);
		$sql->bindParam(":Year",$datos["Year"]);
		$sql->bindParam(":Editorial",$datos["Editorial"]);
		$sql->bindParam(":Edicion",$datos["Edicion"]);
		$sql->bindParam(":Precio",$datos["Precio"]);
		$sql->bindParam(":Paginas",$datos["Paginas"]);
		$sql->bindParam(":Ubicacion",$datos["Ubicacion"]);
		$sql->bindParam(":Resumen",$datos["Resumen"]);
		$sql->bindParam(":Imagen",$datos["Imagen"]);
		$sql->bindParam(":Pdf",$datos["Pdf"]);
		//$sql->bindParam(":Descarga",$datos["Descarga"]);
		$sql->bindParam(":CateCodigo",$datos["CateCodigo"]);
		$sql->bindParam(":ProveCodigo",$datos["ProveCodigo"]);
		$sql->bindParam(":EmpreCodigo",$datos["EmpreCodigo"]);
		$sql->execute();
		return $sql;
	}

		//CREACION DEL MODELO DE DATOS DE LOS LIBROS
	protected function datos_libros_modelo($tipo, $codigo){
		if($tipo=="Unico"){
			$query=mainModel::conectar()->prepare("SELECT * FROM libro WHERE id=:Codigo");
			$query->bindParam(":Codigo",$codigo);
		}elseif($tipo=="Conteo"){
			$query=mainModel::conectar()->prepare("SELECT id FROM libro");
		}elseif($tipo=="select"){
			$query=mainModel::conectar()->prepare("SELECT LibroCodigo, LibroTitulo FROM libro ORDER BY LibroTitulo ASC");
		}
		$query->execute();
		return $query;
	}

	//CREACION DEL MODELO ACTUALIZAR DATOS DE LOS LIBROS
	protected function actualizar_libros_modelo($datos){
		$sql=mainModel::conectar()->prepare("UPDATE libro SET LibroCodigo=:Referencia, LibroTitulo=:Titulo, LibroAutor=:Autor, LibroPais=:Pais, LibroYear=:Year, LibroEditorial=:Editorial, LibroEdicion=:Edicion, LibroPrecio=:Precio, LibroPaginas=:Paginas, LibroUbicacion=:Ubicacion, LibroResumen=:Resumen WHERE id=:Id");
		
		$sql->bindParam(":Referencia",$datos["Referencia"]);
		$sql->bindParam(":Titulo",$datos["Titulo"]);
		$sql->bindParam(":Autor",$datos["Autor"]);
		$sql->bindParam(":Pais",$datos["Pais"]);
		$sql->bindParam(":Year",$datos["Year"]);
		$sql->bindParam(":Editorial",$datos["Editorial"]);
		$sql->bindParam(":Edicion",$datos["Edicion"]);
		$sql->bindParam(":Precio",$datos["Precio"]);
		$sql->bindParam(":Paginas",$datos["Paginas"]);
		$sql->bindParam(":Ubicacion",$datos["Ubicacion"]);
		$sql->bindParam(":Resumen",$datos["Resumen"]);
		$sql->bindParam(":Id",$datos['Id']);
		$sql->execute();
		return $sql;
	}

		//CREACION DEL MODELO DE ELIMINAR EMPRESA
	protected function eliminar_libros_modelo ($codigo){
		$query=mainModel::conectar()->prepare("DELETE FROM libro WHERE LibroCodigo =:Codigo");
		$query->bindParam(":Codigo",$codigo);
		$query->execute();
		return $query;
	}

}



