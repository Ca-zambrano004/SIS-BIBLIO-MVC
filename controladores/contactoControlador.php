<?php 
	if ($peticionAjax) {
	require_once '../modelos/contactoModelo.php';
	} else {
	require_once './modelos/contactoModelo.php';
	}

class contactoControlador extends contactoModelo{

	//CONTROLADOR PARA ENVIAR CONTACTO
	public function enviar_contacto_controlador(){

		$nombre   =  mainModel::limpiar_cadena($_POST["nombre-reg"]);
		$telefono =  mainModel::limpiar_cadena($_POST["telefono-reg"]);
		$asunto   =  mainModel::limpiar_cadena($_POST["asunto-reg"]);
		$email    =  mainModel::limpiar_cadena($_POST["email-reg"]); 
		$mensaje  =  mainModel::limpiar_cadena($_POST["resumen-reg"]);

		$consulta1=mainModel::ejecutar_consulta_simple("SELECT TelefonoContacto FROM contacto WHERE TelefonoContacto='$telefono'");	

				if($consulta1->rowCount()<=0){
					$datosContacto=[
						"Nombre"=>$nombre,
						"Telefono"=>$telefono,
						"Asunto"=>$asunto,
						"Email"=>$email,
						"Mensaje"=>$mensaje
						];
					$guardarContacto=contactoModelo::enviar($datosContacto);
					if($guardarContacto->rowCount()>=1){
						$destinatario = "carloszambranolamar@hotmail.com";
						$asunto = "Mensaje desde nuestra Biblioteca Virtual";

						$carta = "De: $nombre \n";
						$carta .= "Telefono: $telefono \n";
						$carta .= "Correo: $email \n";
						$carta .= "Resumen: $resumen\n";
						$carta .= "Enviado el: " . date('d/m/Y', time());

						$Email= mail($destinatario, $asunto, $carta);

					$alerta=[
							"Alertas"=>"recargar",
							"Titulo"=>"Mensaje Enviado.",
							"Texto"=>"Gracias por su opinión!.",
							"Tipo"=>"success"
							];
					}else{
						$alerta=[
							"Alertas"=>"simple",
							"Titulo"=>"Ocurrio un error en el envio.",
							"Texto"=>"No se ha podido enviar el mensaje, por favor intente nuevamente.",
							"Tipo"=>"error"
							];
					}
				}else{
					$alerta=[
					"Alertas"=>"simple",
					"Titulo"=>"Ocurrio un error en el envio del mensaje.",
					"Texto"=>"Su telefono ya se encuentra registrado en el sistema, por favor intente nuevamente.",
					"Tipo"=>"error"
					];
				}
		return mainModel::sweet_alert($alerta);
	}
			
}