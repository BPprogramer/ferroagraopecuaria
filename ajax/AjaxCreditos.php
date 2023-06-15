<?php 

    require_once '../controllers/CreditoController.php';
    require_once '../models/Ventas.php';
    require_once '../models/Usuarios.php';
    require_once '../models/Credito.php';
    require_once '../models/Pagos.php';

    class AjaxTablaCreditos{
        public function consultarDatosVenta(){
            $respuesta = CreditoController::consultarVenta();
            echo json_encode($respuesta);
            
        }
        public function pagarDeuda(){
            $respuesta = CreditoController::pagoDeudas();
            echo json_encode($respuesta);
        }
    }

    $credito = new AjaxTablaCreditos();
    if(isset($_POST['codigo_venta'])){
       $credito->consultarDatosVenta();
    }
    if(isset($_POST['valor_pago'])){
       $credito->pagarDeuda();
    }