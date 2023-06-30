

<?php

    session_start();
    date_default_timezone_set('America/Bogota');
 
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        
      


?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Ferro Agro</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!--   <link rel="icon" href="views/img/plantilla/icono-negro.png"> -->

   <!--=====================================
  PLUGINS DE CSS
  ======================================-->


  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->
 


   <!-- <link rel="stylesheet" href="views/bower_components/font-awesome/css/font-awesome.min.css"> -->

  <!-- Ionicons -->
  <link rel="stylesheet" href="views/bower_components/Ionicons/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="views/dist/css/AdminLTE.css">

  <link rel="stylesheet" href="views/plugins/iCheck/all.css">
  <!-- daterangerpicker -->
  <link rel="stylesheet" href="views/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="views/dist/css/skins/_all-skins.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

   <!-- DataTables -->
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">

  <link rel="stylesheet" href="views/bower_components/morris.js/morris.css">



<!-- <script src="views/plugins/sweetalert2/sweetalert2.all.js"></script> -->
    <script>
        const currentUrl = window.location.href;
        if (currentUrl.indexOf("administrar-ventas") == -1) {
            
            if(localStorage.getItem('rango')!=null){
                localStorage.removeItem('capturarRango');
                localStorage.clear();
            }
        }
        if (currentUrl.indexOf("reporte-ventas") == -1) {
            
            if(localStorage.getItem('rango_reportes')!=null){
               //localStorage.removeItem('capturarRango');
                localStorage.clear();
            }
        }
    </script>
    <style>
        body{
            font-size:20px !important;
        }
        .swal2-confirm,
        .swal2-cancel,
        .swal2-title{
            font-size:20px !important;
        }
        .swal2-html-container{
            font-size:15px !important;
        }
       
    </style>

 
</head>

<!--=====================================
CUERPO DOCUMENTO sidebar-collapse
======================================-->


<body class="hold-transition skin-blue sidebar-collapse  sidebar-mini login-page">
 
<?php 
     

        
       if(isset($_SESSION['login']) && $_SESSION['login']==true){
            echo '<div class="wrapper">';

           include "modules/header.php";
           include "modules/sidebar.php";
            
            if(isset($_GET['ruta'])){
               if($_GET['ruta']=='inicio' || 
                   $_GET['ruta']=='usuarios' ||
                   $_GET['ruta']=='categorias' ||
                   $_GET['ruta']=='clientes' ||
                   $_GET['ruta']=='productos' ||
                   $_GET['ruta']=='administrar-ventas' ||
                   $_GET['ruta']=='crear-venta' ||
                   $_GET['ruta']=='editar-venta' ||
                   $_GET['ruta']=='reporte-ventas' ||
                   $_GET['ruta']=='descargar-reporte' ||
                   $_GET['ruta']=='creditos' ||
                   $_GET['ruta']=='proveedores' ||
                   $_GET['ruta']=='cajas' ||
                   $_GET['ruta']=='compras' ||
                   $_GET['ruta']=='ingresos' ||
                   $_GET['ruta']=='egresos' ||
              
                   $_GET['ruta'] == 'logout'
               ){
                   include "modules/".$_GET['ruta'].".php";
               }else{
                   include "modules/404.php";
               }
           }else{
                include "modules/inicio.php";
           }      
           
       
           include "modules/footer.php";

           echo '</div>';
           //<!-- ./wrapper -->
       }else{

           include "modules/login.php";
         
       }
      
   ?>

 <!-- jQuery 3 -->
 <script src="views/bower_components/jquery/dist/jquery.min.js"></script>
  
  <!-- Bootstrap 3.3.7 -->
  <script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- FastClick -->
  <script src="views/bower_components/fastclick/lib/fastclick.js"></script>
  
  <!-- AdminLTE App -->
  <script src="views/dist/js/adminlte.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="views/plugins/iCheck/icheck.min.js"></script>
  <!-- DataTables -->
  <script src="views/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="views/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="views/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="views/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
  <script src="views/bower_components/moment/min/moment.min.js"></script>
  <script src="views/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <script src="views/bower_components/raphael/raphael.min.js"></script>
    <script src="views/bower_components/morris.js/morris.min.js"></script>
    <script src="views/bower_components/chart.js/Chart.js"></script>




    <!-- InputMask -->
    <script src="views/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="views/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="views/plugins/input-mask/jquery.inputmask.extensions.js"></script>

    <!-- SweetAlert 2 -->
    <!--   <script src="views/plugins/sweetalert2/sweetalert2.all.js"></script> -->
    <!-- <script src="views/plugins/sweetalert/sweetalert2.all.js"></script> -->


  <!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:-->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> -->

    

<!--     <script src="views/js/idiomas.js"></script> -->
    <script src="views/js/productos.js"></script>
    <script src="views/js/plantilla.js"></script>
    <script src="views/js/usuarios.js"></script>
    
    <script src="views/js/categorias.js"></script>
    <script src="views/js/clientes.js"></script>
    <script src="views/js/ventas.js"></script>
    <script src="views/js/editar_venta.js"></script>
    <script src="views/js/eliminar_venta.js"></script>
    <script src="views/js/administrar_ventas.js"></script>
    <script src="views/js/reporte_ventas.js"></script>
    <script src="views/js/reporte/reporte_ventas.js"></script>
    <script src="views/js/inicio/cajas_superiores.js"></script>
    <script src="views/js/inicio/grafico_ventas_inicio.js"></script>
    <script src="views/js/inicio/productos_top.js"></script>
    <script src="views/js/imprimir_facturas.js"></script>
    <script src="views/js/creditos.js"></script>
    <script src="views/js/proveedores.js"></script>
    <script src="views/js/cajas.js"></script>
    <script src="views/js/compras.js"></script>
    <script src="views/js/editar_stock_productos.js"></script>
    <script src="views/js/ingresos.js"></script>
    <script src="views/js/egresos.js"></script>

    <script src="views/plugins/jquery_number/jquerynumber.min.js"></script>
    <script src="https://kit.fontawesome.com/a3e5ca3374.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
</body>
</html>
