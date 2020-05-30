<?php 

	class vistasModelo {
		protected function obtener_vistas_modelo($vistas){
			$listaBlanca=["adminlist","adminsearch","bookconfig","book","admin","bookinfo","catalog","categorylist","category","categorydata","clientlist","clientsearch","client","companylist","company","companydata","home","myaccount","mydata","providerlist","provider","providerdata","search","contacto","booklist","booksearch","report","reportCate","reportBook"];
			if(in_array($vistas, $listaBlanca)) {
				if(is_file("./vista/contenido/".$vistas."-vista.php")){
					$contenido="./vista/contenido/".$vistas."-vista.php";	
				}else{
					$contenido="login";
				}	
			}elseif($vistas=="login"){
				$contenido="login";
			}elseif ($vistas=="index"){
				$contenido="login";
			}else{
				$contenido="404";
			}
			return $contenido;
		}	
	}


