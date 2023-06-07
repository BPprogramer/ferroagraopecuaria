
<aside class="main-sidebar" >
	<section class="sidebar">
		<ul class="sidebar-menu">
			<?php if($_SESSION['perfil']=='administrador'){?>
				<li class="active">
					<a href="inicio">
						<i class="fa fa-home"></i>
						<span>Inicio</span>
					</a>
				</li>
				
				<li>
					<a href="usuarios">
						<i class="fa fa-user"></i>
						<span>Usuarios</span>
					</a>
				</li>
			<?php }?>
			<?php if($_SESSION['perfil']=='administrador' || $_SESSION['perfil']=='especial'){?>
				<li>
					<a href="categorias">
						<i class="fas fa-tags"></i>

						<span>Categorias</span>
					</a>
				</li>
				<li>
					<a href="productos">

						<i class="fas fa-shopping-bag"></i>
						<span>productos</span>
					</a>
				</li>
			<?php }?>
			<?php if($_SESSION['perfil']=='administrador' || $_SESSION['perfil']=='vendedor'){?>
				
				
				<li>
					<a href="creditos">
			
						<i class="fas fa-hand-holding-usd"></i>



						<span>Creditos</span>
					</a>
				</li>
			
		
			<?php }?>
		
		
			<?php if($_SESSION['perfil']=='administrador' || $_SESSION['perfil']=='vendedor'){?>
				<li>
					<a href="clientes">
						<i class="fa fa-users"></i>
						<span>Clientes</span>
					</a>
				</li>
				<?php if($_SESSION['perfil']=='administrador'){?>
					<li>
						<a href="proveedores">
							<i class="fas fa-truck"></i>
							<span>Proveedores</span>
						</a>
					</li>
					<li>
						<a href="compras">
							<i class="fas fa-shopping-basket"></i>
							<span>Compras</span>
						</a>
					</li>
				<?php }?>
				<?php if($_SESSION['perfil']=='administrador' || $_SESSION['perfil']=='vendedor'){?>
					<li>
						<a href="cajas">
							<i class="fas fa-cash-register"></i>
							<span>Cajas</span>
						</a>
					</li>
				<?php }?>
				
				
				<li class="treeview">
					<a href="#">
						<i class="fas fa-shopping-cart"></i>

						<span>Ventas</span>
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
				<?php }?>	

				
			</li>
			

		</ul>
	</section>
</aside>