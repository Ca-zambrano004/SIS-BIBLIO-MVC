<?php 

require_once './core/configGenerales.php';
require_once './controladores/vistasControlador.php';

$plantilla = new vistasControlador();
$plantilla -> obtener_plantilla_controlador();
	

