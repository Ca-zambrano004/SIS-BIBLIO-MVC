<?php 
	if ($peticionAjax) {
	require_once '../core/mainModel.php';
	} else {
	require_once './core/mainModel.php';
	}

class categoriaModelo extends mainModel{

	//CREACION DEL MODELO DE AGREGAR CATEGORIA
	protected function agregar_categoria_modelo ($datos){
		$sql=mainModel::conectar()->prepare("INSERT INTO categoria (CategoriaCodigo,CategoriaNombre) VALUES (:Codigo,:Nombre)");
		
		$sql->bindParam(":Codigo",$datos["Codigo"]);
		$sql->bindParam(":Nombre",$datos["Nombre"]);
		$sql->execute();
		return $sql;
	}

		//CREACION DEL MODELO DE DATOS DE LAS CATEGORIAS
	protected function datos_categoria_modelo($tipo, $codigo){
		if($tipo=="Unico"){
			$query=mainModel::conectar()->prepare("SELECT * FROM categoria WHERE CategoriaCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
		}elseif($tipo=="Conteo"){
			$query=mainModel::conectar()->prepare("SELECT id FROM categoria");
		}elseif($tipo=="select"){
			$query=mainModel::conectar()->prepare("SELECT CategoriaCodigo, CategoriaNombre FROM categoria ORDER BY CategoriaNombre ASC");
		}
		$query->execute();
		return $query;
	}

	//CREACION DEL MODELO DE ELIMINAR CATEGORIA
	protected function eliminar_categoria_modelo ($codigo){
		$query=mainModel::conectar()->prepare("DELETE FROM categoria WHERE CategoriaCodigo =:Codigo");
		$query->bindParam(":Codigo",$codigo);
		$query->execute();
		return $query;
	}

	//CREACION DEL MODELO ACTUALIZAR DATOS DE LA CATEGORIA
	protected function actualizar_categoria_modelo($datos){
	$query=mainModel::conectar()->prepare("UPDATE categoria SET CategoriaCodigo=:Codigo, CategoriaNombre=:Nombre WHERE CategoriaCodigo=:Codigo");
		$query->bindParam(":Codigo",$datos['Codigo']);
		$query->bindParam(":Nombre",$datos['Nombre']);
		$query->execute();
		return $query;
	}
}