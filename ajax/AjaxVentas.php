
<?php 
    require_once '../controllers/VentasController.php';
    require_once '../models/Ventas.php';
    require_once '../models/Clientes.php';
    require_once '../models/Productos.php';
    class AjaxVentas{
        public function crearVenta(){
        
            $respuesta = VentasController::crearVenta();
            
            echo json_encode($respuesta);
        }
        public function editarVenta(){
          
            $respuesta = VentasController::editar_venta();
            echo json_encode($respuesta);
        }
        public function eliminarVenta(){
         
            $respuesta = VentasController::eliminar_venta();
            echo json_encode($respuesta);
        }

     
      
    }



   $ventas = new AjaxVentas();
   if(isset($_POST['create'])){
    
        $ventas->crearVenta();
   }

   if(isset($_POST['update'])){
 

       $ventas->editarVenta();
   }

   if(isset($_POST['delete'])){
        $ventas->eliminarVenta();
   }
  
