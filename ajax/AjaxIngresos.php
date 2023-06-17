<?php 

    require_once '../controllers/IngresosController.php';
    require_once '../models/Ingresos.php';
    require_once '../models/Conexion.php';
    class AjaxIngresos{
        public function agregarIngreso(){
            $respuesta = IngresosController::agregarIngreso();
            echo json_encode($respuesta);
        }
        public function consultarIngreso(){
            $respuesta = IngresosController::consultarIngresos('id', $_POST['id_ingreso']);
            echo json_encode($respuesta);
        }
        public function eliminarIngreso(){
            $respuesta = IngresosController::eliminarIngreso();
            echo json_encode($respuesta);
        }

    }

    $ingresos = new AjaxIngresos();

    if(isset($_POST['ingreso'])){
        $ingresos->agregarIngreso();
    }
    if(isset($_POST['id_ingreso'])){
        $ingresos->consultarIngreso();
    }
    if(isset($_POST['id_eliminar'])){
        $ingresos->eliminarIngreso();
    }
    if(isset($_POST['id_info_ingreso'])){
        $ingresos->consultarIngreso();
    }