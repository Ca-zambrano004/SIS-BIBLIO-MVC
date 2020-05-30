<?php 
	if ($peticionAjax) {
	require_once '../core/mainModel.php';
	} else {
	require_once './core/mainModel.php';
	}

	class bitacoraControlador extends mainModel{
		
		public function listado_bitacora_controlador($registros){
			$registros=mainModel::limpiar_cadena($registros);

			$datos=mainModel::ejecutar_consulta_simple("SELECT * FROM bitacora ORDER BY id DESC LIMIT $registros");
			
			$contador=1;

			while($filas=$datos->fetch()){
			
				$datosCuenta= mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo='".$filas['CuentaCodigo']."'");
				$datosCuenta=$datosCuenta->fetch();

				if($filas['BitacoraTipo']=="Administrador"){
					$datosUsuario=mainModel::ejecutar_consulta_simple("SELECT AdminNombre, AdminApellido FROM admin WHERE CuentaCodigo='".$filas['CuentaCodigo']."'");
						$datosUsuario=$datosUsuario->fetch();
						$NombreCompleto=$datosUsuario['AdminNombre']." ".$datosUsuario['AdminApellido'];
				}else{
					$datosUsuario=mainModel::ejecutar_consulta_simple("SELECT ClienteNombre, ClienteApellido FROM cliente WHERE CuentaCodigo='".$filas['CuentaCodigo']."'");
						$datosUsuario=$datosUsuario->fetch();
						$NombreCompleto=$datosUsuario['ClienteNombre']." ".$datosUsuario['ClienteApellido'];
				}
				echo '
					<div class="cd-timeline-block">
						<div class="cd-timeline-img">

							<img src="'.$datosCuenta['CuentaFoto'].'" alt="user-picture">
					</div>
					<div class="cd-timeline-content">
						<h4 class="text-center text-titles">'.$contador.' - '.$NombreCompleto.' ('.$datosCuenta['CuentaUsuario'].') </h4>
						<h4 class="text-center text-titles">'.$filas['BitacoraTipo'].' </h4>
							<p class="text-center">
								<i class="zmdi zmdi-timer zmdi-hc-fw"></i> Inicio: <em>'.$filas['BitacoraHoraInicio'].'</em> &nbsp;&nbsp;&nbsp; 
									<i class="zmdi zmdi-time zmdi-hc-fw"></i> Fin: <em>'.$filas['BitacoraHoraFinal'].'</em>
							</p>
								<span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i>'.date("d-m-Y",strtotime($filas['BitacoraFecha'])).'</span>
						</div>
					</div> 
				';
				$contador++;
			}	
		}


		
	}