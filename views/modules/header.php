<header class="main-header">
    <a href="inicio" class="logo">
        <span class="logo-mini">
            <!-- <img src="views/img/plantilla/icono-blanco.png" class="img-responsive" style="padding:10px" alt=""> -->
            <h1 style="margin:10px 0px; font-size:28px; color:#f0ad4e;  font-weight: bold">FA</h1>
        </span>


        <span class="logo-lg">
            <h1 style="margin:10px 0px; font-size:28px; color:#f0ad4e;  font-weight: bold">FERROAGROG</h1>
            <!-- <img src="views/img/plantilla/logo.png" class="img-responsive" style="padding:10px 0" alt=""> -->
        </span> 
    </a>

    <!-- sidebar -->

    <nav class="navbar navbar-static-top" role="navigation"> 

        <!-- menu hamburguesa -->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"> 
            <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- boton para cerrar sesion -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                    <?php if($_SESSION['foto'] !=""){?>
                        <img src="<?php echo $_SESSION['foto'] ?>" class="user-image" alt="">
                    <?php }else {?>

                        <img src="views/img/usuarios/default/anonymous.png"  class="user-image" alt="">
                    <?php }?>
                        <span class="hiden-xs"><?php echo $_SESSION['nombre']?></span>
                    </a>

                      <!-- dropdown tooggle -->
                    <ul class="dropdown-menu">
                        <li class="user-body">
                            <div class="pull-right">
                                <a href="logout" class="btn btn-default btn-flat">Cerrar Sesión</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

      
      
    </nav>

</header>




