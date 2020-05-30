<?php 
	if ($peticionAjax) {
	require_once "../core/mainModel.php";
	} else {
	require_once "./core/mainModel.php";
	}

	class cuentaControlador extends mainModel{

		public function datos_cuenta_controlador($codigo, $tipo){
			$codigo=mainModel::decryption($codigo);
			$tipo=mainModel::limpiar_cadena($tipo);

			if($tipo=="admin"){
				$tipo="Administrador";
			}else{
				$tipo="Cliente";
			}
			

			return mainModel::datos_cuenta($codigo,$tipo);
		}

		public function actualizar_cuenta_controlador(){
			//Desencritar el el codigo t el tipo de cuenta que viene en la URL.
			$CuentaCodigo=mainModel::decryption($_POST['CodigoCuenta-up']);
			$CuentaTipo=mainModel::decryption($_POST['tipoCuenta-up']);

			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM  cuenta WHERE CuentaCodigo='$CuentaCodigo'");
			$DatosCuenta=$query1->fetch();
			//limpiar la cadena para evitar inyeccion SQL
			$user=mainModel::limpiar_cadena($_POST["usuarioConfir-up"]);
			$password=mainModel::limpiar_cadena($_POST["passwordConfir-up"]);
			//Encryptar el password porq en nuestra BD esta encrictada.
			$password=mainModel::encryption($password);

			if($user!="" && $password!=""){

				if(isset($_POST['privilegio-up'])){
					$login=mainModel::ejecutar_consulta_simple("SELECT id  FROM cuenta WHERE CuentaUsuario='$user' AND CuentaClave='$password'");
				}else{
					$login=mainModel::ejecutar_consulta_simple("SELECT id  FROM cuenta WHERE CuentaUsuario='$user' AND CuentaClave='$password' AND CuentaCodigo='$CuentaCodigo'");
				}
				if($login->rowCount()==0){
					$alerta=[
						"Alertas"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"los datos que acaba de registar no coinciden con los datos de su cuenta, por favor intente nuevamente.",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
					}
			}else{
				$alerta=[
					"Alertas"=>"simple",
					"Titulo"=>"Ocurrio un error inesperado",
					"Texto"=>"Para actualizar los datos debe registar el Usuario y la Contraseña, ingrese los datos e intente nuevamente.",
					"Tipo"=>"error"
				];
				return mainModel::sweet_alert($alerta);
				exit();
			}

			//VERIFICAR USUARIO
			$CuentaUsuario=mainModel::limpiar_cadena($_POST['usuario-up']);
			if($CuentaUsuario!=$DatosCuenta['CuentaUsuario']){
				$query2=mainModel::ejecutar_consulta_simple("SELECT CuentaUsuario FROM cuenta WHERE CuentaUsuario='$CuentaUsuario'");
				if ($query2->rowCount()>=1){
					$alerta=[
						"Alertas"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El nombre de Usuario ya se encuenta registrado en el sistema, verifique los datos e intente nuevamente.",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}

			//VERIFICAR EMAIL
			$CuentaEmail=mainModel::limpiar_cadena($_POST['email-up']);
			if($CuentaEmail!=$DatosCuenta['CuentaEmail']){
				$query3=mainModel::ejecutar_consulta_simple("SELECT CuentaEmail FROM cuenta WHERE CuentaEmail='$CuentaEmail'");
				if($query3->rowCount()>=1){
					$alerta=[
						"Alertas"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"El correo electronico ya se encuenta registrado en el sistema, verifique los datos e intente nuevamente.",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}

			//VERIFICAR EL GENERO, ESTADO, PRIVILEGIO Y LA FOTO
			$CuentaGenero=mainModel::limpiar_cadena($_POST['optionsGenero-up']);
			if(isset($_POST['optionsEstado-up'])){
					$CuentaEstado=mainModel::limpiar_cadena($_POST['optionsEstado-up']);
			}else{
				$CuentaEstado=$DatosCuenta['CuentaEstado'];
			}

			if($CuentaTipo=="admin"){
				if(isset($_POST['optionsPrivilegio-up'])){
					$CuentaPrivilegio=mainModel::decryption($_POST['optionsPrivilegio-up']);
					}else{
						$CuentaPrivilegio=$DatosCuenta['CuentaPrivilegio'];
					}

		//modificar aca para actualizar la foto del usuario administrador

			/*=============================================
			VALIDAR IMAGEN
			=============================================*/

			
			if(isset($_FILES["imagen-reg"]["tmp_name"])){

			list($ancho, $alto) = getimagesize($_FILES["imagen-reg"]["tmp_name"]);

			$nuevoAncho = 300;
			$nuevoAlto = 300;

			/*=============================================
			CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
			=============================================*/

			$directorio = "../vista/assets/avatars/"."";

		

			/*=============================================
			DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
			=============================================*/

			if($_FILES["imagen-reg"]["type"] == "image/jpg"){

			/*=============================================
			GUARDAMOS LA IMAGEN EN EL DIRECTORIO
			=============================================*/

			$aleatorio = mt_rand(100,999);

			$ruta = "../vista/assets/avatars/".$aleatorio.".jpg";

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

			$ruta = "../vista/assets/avatars/".$aleatorio.".jpg";

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

			$ruta = "../vista/assets/avatars/".$aleatorio.".png";

			$origen = imagecreatefrompng($_FILES["imagen-reg"]["tmp_name"]);						

			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			imagepng($destino, $ruta);

			}

			}
//modificar aca para actualizar la foto del usuario cliente
				}else{
					$CuentaPrivilegio=$DatosCuenta['CuentaPrivilegio'];

					/*=============================================
			VALIDAR IMAGEN
			=============================================*/

			
			if(isset($_FILES["imagen-reg"]["tmp_name"])){

			list($ancho, $alto) = getimagesize($_FILES["imagen-reg"]["tmp_name"]);

			$nuevoAncho = 300;
			$nuevoAlto = 300;

			/*=============================================
			CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
			=============================================*/

			$directorio = "../vista/assets/avatars/"."";

		

			/*=============================================
			DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
			=============================================*/

			if($_FILES["imagen-reg"]["type"] == "image/jpg"){

			/*=============================================
			GUARDAMOS LA IMAGEN EN EL DIRECTORIO
			=============================================*/

			$aleatorio = mt_rand(100,999);

			$ruta = "../vista/assets/avatars/".$aleatorio.".jpg";

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

			$ruta = "../vista/assets/avatars/".$aleatorio.".jpg";

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

			$ruta = "../vista/assets/avatars/".$aleatorio.".png";

			$origen = imagecreatefrompng($_FILES["imagen-reg"]["tmp_name"]);						

			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			imagepng($destino, $ruta);

			}

			}
				}

			//VERIFICAR EL CAMBIO DE CONTRASEÑAS
			$PasswordN1=mainModel::limpiar_cadena($_POST['newPassword1-up']);
			$PasswordN2=mainModel::limpiar_cadena($_POST['newPassword2-up']);
			if($PasswordN1!="" || $PasswordN2!=""){
				if($PasswordN1==$PasswordN2){
					$CuentaClave=mainModel::encryption($PasswordN1);
				}else{
					$alerta=[
						"Alertas"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"Las contraseñas no coinciden, verifique los datos e intente nuevamente.",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}else{
				$CuentaClave=$DatosCuenta['CuentaClave'];
			}

			//ENVIANDO DATOS AL MODELO
			$DatosActualizados=[
				"CuentaPrivilegio"=>$CuentaPrivilegio,
				"CuentaCodigo"=>$CuentaCodigo,
				"CuentaUsuario"=>$CuentaUsuario,
				"CuentaClave"=>$CuentaClave,
				"CuentaEmail"=>$CuentaEmail,
				"CuentaEstado"=>$CuentaEstado,
				"CuentaGenero"=>$CuentaGenero,
				"CuentaFoto"=>$ruta
			];
	
			if(mainModel::actualizar_datos_cuenta($DatosActualizados)){
				if(!isset($_POST['privilegio-up'])){
					session_start(['name'=>'SBP']);
					$_SESSION["usuario_sbp"]=$CuentaUsuario;
					$_SESSION["foto_sbp"]=$ruta;
				}
					$alerta=[
							"Alertas"=>"recargar",
							"Titulo"=>"Cuenta Actualizada",
							"Texto"=>"los datos de la cuenta se actualizarón con exito.",
							"Tipo"=>"success"
						];
			}else{
				$alerta=[
						"Alertas"=>"simple",
						"Titulo"=>"Ocurrio un error inesperado",
						"Texto"=>"No se han podido actualizar los datos de la cuenta, verifique e intente nuevamente.",
						"Tipo"=>"error"
					];
					
			}
			return mainModel::sweet_alert($alerta);
	} 
}