<?php 
	if ($peticionAjax) {
	require_once '../core/mainModel.php';
	} else {
	require_once './core/mainModel.php';
	}

class contactoModelo extends mainModel{

		//CREACION DEL MODELO DE ENVIAR EMAIL
	protected function enviar ($datos){
		$sql=mainModel::conectar()->prepare("INSERT INTO contacto (NombreContacto, TelefonoContacto,EmailContacto,AsuntoContacto,MensajeContacto) VALUES (:Nombre,:Telefono,:Email,:Asunto,:Mensaje)");

		$sql->bindParam(":Nombre",$datos["Nombre"]);
		$sql->bindParam(":Telefono",$datos["Telefono"]);
		$sql->bindParam(":Email",$datos["Email"]);
		$sql->bindParam(":Asunto",$datos["Asunto"]);
		$sql->bindParam(":Mensaje",$datos["Mensaje"]);
		$sql->execute();
		return $sql;
	}

	}



