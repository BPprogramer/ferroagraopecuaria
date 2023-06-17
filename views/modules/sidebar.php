
<aside class="main-sidebar" >
	<section class="sidebar">
		<ul class="sidebar-menu">
			<?php if($_SESSION['perfil']=='administrador'){?>
				<li class="active">
					<a href="inicio">
						<i class="fa fa-home"></i>
						<span>&nbsp;&nbsp; Inicio</span>
					</a>
				</li>
				
				<li>
					<a href="usuarios">
						<i class="fa fa-user"></i>
						<span>&nbsp;&nbsp;Usuarios</span>
					</a>
				</li>
			<?php }?>
		
			<?php if($_SESSION['perfil']=='administrador' || $_SESSION['perfil']=='vendedor'){?>
				
				
				<li>
					<a href="creditos">
			
						<i class="fas fa-hand-holding-usd"></i>



						<span>&nbsp;&nbsp;Creditos</span>
					</a>
				</li>
			
		
			<?php }?>
		
		
			<?php if($_SESSION['perfil']=='administrador' || $_SESSION['perfil']=='vendedor'){?>
				<li>
					<a href="clientes">
						<i class="fa fa-users"></i>
						<span>&nbsp;&nbsp;Clientes</span>
					</a>
				</li>
			
				
				
				<li class="treeview">
					<a href="#">
						<i class="fas fa-shopping-cart"></i>

						<span>&nbsp;&nbsp;Ventas</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>

					<ul class="treeview-menu">
						<li>
							<a href="administrar-ventas">
								<i class="fa fa-circle-o"></i>
								<span>Administrar ventas</span>
							</a>
						</li>
						<li>
							<a href="crear-venta">
								<i class="fa fa-circle-o"></i>
								<span>Crear Venta</span>
							</a>
						</li>
			<?php }?>
				<?php if($_SESSION['perfil']=='administrador'){?>
						<li>
							<a href="reporte-ventas">
								<i class="fa fa-circle-o"></i>
								<span>Reporte ventas</span>
							</a>
						</li>
					</ul>
				
				
			<?php }else{?>
					</ul>
				</li>
			<?php }?>	
			</li>
			<?php if($_SESSION['perfil']=='administrador' || $_SESSION['perfil']=='vendedor'){?>

					<li>
						<a href="cajas">
							<i class="fas fa-cash-register"></i>
							<span>&nbsp;&nbsp;Cajas</span>
						</a>
					</li>
			<?php }?>
				
			<li class="treeview">
					<a href="#">
						<i class="fas fa-money-bill-wave"></i>

						<span>&nbsp;&nbsp;Transacciones</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="ingresos">
								<i class="fa fa-circle-o"></i>
								<span>Ingresos</span>
							</a>
						</li>
						<li>
							<a href="egresos">
								<i class="fa fa-circle-o"></i>
								<span>Egresos</span>
							</a>
						</li>
					</ul>
			</li>

			<?php if($_SESSION['perfil']=='administrador'){?>
					<li>
						<a href="proveedores">
							<i class="fas fa-truck"></i>
							<span>&nbsp;&nbsp;Proveedores</span>
						</a>
					</li>
					<li>
						<a href="compras">
							<i class="fas fa-shopping-basket"></i>
							<span>&nbsp;&nbsp;Compras</span>
						</a>
					</li>

				
				<?php }?>

			<?php if($_SESSION['perfil']=='administrador'){?>
				<li>
					<a href="productos">

						<i class="fas fa-shopping-bag"></i>
						<span>&nbsp;&nbsp;productos</span>
					</a>
				</li>
				<li>
					<a href="categorias">
						<i class="fas fa-tags"></i>

						<span>&nbsp;&nbsp;Categorias</span>
					</a>
				</li>
			
			<?php }?>


		</ul>
	</section>
</aside>