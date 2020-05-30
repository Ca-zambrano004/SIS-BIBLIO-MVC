<?php 

	require_once "./modelos/vistasModelo.php";

	class vistasControlador extends vistasModelo{
	
	public function obtener_plantilla_controlador(){
		return require_once './vista/plantilla.php';
		}	

	public function obtener_vistas_controlador(){
		if (isset($_GET["vista"])){
			$ruta=explode("/", $_GET["vista"]);
			$respuesta=vistasModelo::obtener_vistas_modelo($ruta[0]);
		}
		else{
			$respuesta="login";
			}
			return $respuesta;
		}

	}