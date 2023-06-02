<?php 
    require_once '../controllers/CajasController.php';
    require_once '../models/Caja.php';
    require_once '../models/Ventas.php';
    require_once '../models/Conexion.php';

    class AjaxCajas{
        public function abrirCaja(){
            $respuesta = CajasController::abrirCaja();
            echo json_encode($respuesta);
        }
        public function cerrarCaja(){
            $respuesta = CajasController::cerrarCaja();
            echo json_encode($respuesta);
        }
    }

    $caja = new AjaxCajas();

    if(isset($_POST['efectivo_inicial'])){
        $caja->abrirCaja();
    }
    if(isset($_POST['id_caja'])){
        
        $caja->cerrarCaja();
    }