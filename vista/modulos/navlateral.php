<section class="full-box cover dashboard-sideBar">
	<div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
	<div class="full-box dashboard-sideBar-ct">
		<!--SideBar Title -->
		<div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
			<?php echo COMPANY; ?> <i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
		</div>
		<!-- SideBar User info -->
		<div class="full-box dashboard-sideBar-UserInfo">
			<figure class="full-box">
					<?php 
						$ruta = $_SESSION['foto_sbp'];	
						$ruta = substr($ruta, 8);		
						?>

				<img src="<?php echo SERVERURL; ?>vista<?php echo $ruta;?>" alt="UserIcon">
				<figcaption class="text-center text-titles"><?php echo $_SESSION["nombre_sbp"];?> <?php echo $_SESSION["apellido_sbp"];?></figcaption>
			</figure>
			<?php 
			if($_SESSION["tipo_sbp"]=="Administrador"){
				$tipo="admin";
			}else{
				$tipo="user";
			}
			?>
			<ul class="full-box list-unstyled text-center">
				<li>
					<a href="<?php echo SERVERURL; ?>mydata/<?php echo $tipo."/".$lc->encryption($_SESSION["codigo_cuenta_sbp"]); ?>/" title="Mis datos">
						<i class="zmdi zmdi-account-circle"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo SERVERURL; ?>myaccount/<?php echo $tipo."/".$lc->encryption($_SESSION["codigo_cuenta_sbp"]); ?>/" title="Mi cuenta">
						<i class="zmdi zmdi-settings"></i>
					</a>
				</li>
				<li>

				<a href="<?php echo $lc->encryption($_SESSION['token_sbp']); ?>" title="Salir del sistema" class="btn-exit-system">
						<i class="zmdi zmdi-power"></i>
					</a> 


				</li>
			</ul>
		</div>
		<!-- SideBar Menu -->
		<ul class="list-unstyled full-box dashboard-sideBar-Menu">
			<!--OCULTAR EL TIPO DE USUARIO QUE ACABA DE INICIAAR SESION-->
			<?php if($_SESSION['tipo_sbp']=="Administrador"): ?>
			<li>
				<a href="<?php echo SERVERURL; ?>home/">
					<i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i> Inicio
				</a>
			</li>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-case zmdi-hc-fw"></i> Administración <i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php echo SERVERURL; ?>company/<?php echo $tipo."/".$lc->encryption($_SESSION["codigo_cuenta_sbp"]); ?>/" title="Empresa">
							<i class="zmdi zmdi-balance zmdi-hc-fw"></i> 
						Empresa</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>category/"><i class="zmdi zmdi-labels zmdi-hc-fw"></i> Categorías</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>provider/"><i class="zmdi zmdi-truck zmdi-hc-fw"></i> Proveedores</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>book/"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Libros </a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>report/"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw"></i> Reportes</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Usuarios <i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php echo SERVERURL; ?>admin/"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Administradores</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>client/"><i class="zmdi zmdi-male-female zmdi-hc-fw"></i> Estudiantes</a>
					</li>
				</ul>
			</li>
			<?php endif; ?>
			<li>
				<a href="<?php echo SERVERURL; ?>catalog/"><i class="zmdi zmdi-book-image zmdi-hc-fw"></i> Catalogo</a>
			</li>
			<li>
				<a href="<?php echo SERVERURL; ?>contacto/"><i class = "zmdi zmdi-comment-text zmdi-hc-fw"></i> Contacto</a>
			</li>
		</ul>
	</div>
</section>