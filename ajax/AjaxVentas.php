
<?php 
    

    require_once '../controllers/VentasController.php';
    require_once '../models/Ventas.php';
    require_once '../models/Clientes.php';
    require_once '../models/Productos.php';
    require_once '../models/Usuarios.php';
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
        public function imprimirTicket(){
         
            $respuesta = VentasController::impirmir_ticket();
            echo json_encode($respuesta);
        }

     
      
    }



   $ventas = new AjaxVentas();
   if(isset($_POST['id_imprimir_ticket'])){
        $ventas->imprimirTicket();
    }
   if(isset($_POST['create'])){
    
        $ventas->crearVenta();
   }

   if(isset($_POST['update'])){
 

       $ventas->editarVenta();
   }

   if(isset($_POST['delete'])){
        $ventas->eliminarVenta();
   }

  
