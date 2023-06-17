<?php 

    require_once '../controllers/EgresosController.php';
    require_once '../models/Egresos.php';
    require_once '../models/Conexion.php';
    class AjaxEgresos{
        public function agregarEgreso(){
            $respuesta = EgresosController::agregarEgreso();
            echo json_encode($respuesta);
        }
        public function consultarEgreso(){
            $respuesta = EgresosController::consultarEgresos('id', $_POST['id_egreso']);
            echo json_encode($respuesta);
        }
        public function eliminarEgreso(){
            $respuesta = EgresosController::eliminarEgreso();
            echo json_encode($respuesta);
        }

    }

    $egresos = new AjaxEgresos();

    if(isset($_POST['egreso'])){
        $egresos->agregarEgreso();
    }
    if(isset($_POST['id_egreso'])){
        $egresos->consultarEgreso();
    }
    if(isset($_POST['id_eliminar'])){
        $egresos->eliminarEgreso();
    }
  