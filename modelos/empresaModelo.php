<?php 
	if ($peticionAjax) {
	require_once '../core/mainModel.php';
	} else {
	require_once './core/mainModel.php';
	}

class empresaModelo extends mainModel{

	//CREACION DEL MODELO DE AGREGAR EMPRESA
	protected function agregar_empresa_modelo ($datos){
		$sql=mainModel::conectar()->prepare("INSERT INTO empresa (EmpresaCodigo,EmpresaNombre,EmpresaTelefono,EmpresaEmail,	EmpresaDireccion,EmpresaDirector,EmpresaDirecTele,EmpresaYear) VALUES (:Codigo,:Nombre,:Telefono,:Email,:Direccion,:Director,:Telefono2,:Year)");
		
		$sql->bindParam(":Codigo",$datos["Codigo"]);
		$sql->bindParam(":Nombre",$datos["Nombre"]);
		$sql->bindParam(":Telefono",$datos["Telefono"]);
		$sql->bindParam(":Email",$datos["Email"]);
		$sql->bindParam(":Direccion",$datos["Direccion"]);
		$sql->bindParam(":Director",$datos["Director"]);
		$sql->bindParam(":Telefono2",$datos["Telefono2"]);
		$sql->bindParam(":Year",$datos["Year"]);
		$sql->execute();
		return $sql;
	}

		//CREACION DEL MODELO DE DATOS DE LAS EMPRESA
	protected function datos_empresa_modelo($tipo, $codigo){
		if($tipo=="Unico"){
			$query=mainModel::conectar()->prepare("SELECT * FROM empresa WHERE id=:Codigo");
			$query->bindParam(":Codigo",$codigo);
		}elseif($tipo=="Conteo"){
			$query=mainModel::conectar()->prepare("SELECT id FROM empresa");
		}elseif($tipo=="select"){
			$query=mainModel::conectar()->prepare("SELECT EmpresaCodigo, EmpresaNombre FROM empresa ORDER BY EmpresaNombre ASC");
		}
		$query->execute();
		return $query;
	}

	//CREACION DEL MODELO DE ELIMINAR EMPRESA
	protected function eliminar_empresa_modelo ($codigo){
		$query=mainModel::conectar()->prepare("DELETE FROM empresa WHERE EmpresaCodigo =:Codigo");
		$query->bindParam(":Codigo",$codigo);
		$query->execute();
		return $query;
	}

	//CREACION DEL MODELO ACTUALIZAR DATOS DE LA EMPRESA
	protected function actualizar_empresa_modelo($datos){
	$query=mainModel::conectar()->prepare("UPDATE empresa SET EmpresaCodigo=:Nit, EmpresaNombre=:Nombre, EmpresaTelefono=:Telefono, EmpresaEmail=:Email, EmpresaDireccion=:Direccion, EmpresaDirector=:Director, EmpresaDirecTele=:Telefono2, EmpresaYear=:Year WHERE id=:Id");
		$query->bindParam(":Nit",$datos['Nit']);
		$query->bindParam(":Nombre",$datos['Nombre']);
		$query->bindParam(":Telefono",$datos['Telefono']);
		$query->bindParam(":Email",$datos['Email']);
		$query->bindParam(":Direccion",$datos['Direccion']);
		$query->bindParam(":Director",$datos['Director']);
		$query->bindParam(":Telefono2",$datos['Telefono2']);
		$query->bindParam(":Year",$datos['Year']);
		$query->bindParam(":Id",$datos['Id']);
		$query->execute();
		return $query;
	}
}