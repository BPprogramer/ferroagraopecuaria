<?php 

    class CajasController{

        public static function consultarCajas(){
      
            $respuesta = Caja::consultarCajas();
           
            return $respuesta;
            
        }
        public static function abrirCaja(){
            session_start();
            $caja = new Caja();
            $efectivo_inicial = $_POST['efectivo_inicial'];
            $parttern_1 = '/^[0-9.]+$/';
            $args = [];
            if(preg_match($parttern_1, $efectivo_inicial)){
                date_default_timezone_set('America/Bogota');
                $args['fecha_apertura']  = date('Y-m-d H:i:s');
                $args['efectivo_apertura'] = $efectivo_inicial;
                $args['estado'] = 0;
                $args['vendedor'] = $_SESSION['nombre'];
                $args['efectivo_ventas'] = 0;
                $args['creditos'] = 0;
                $args['efectivo_cierre'] = 0;
              
                $respuesta = $caja->abrirCaja($args);
                return $respuesta;

            }else{
                return 'no_validate';
            }

            $respuesta = $caja->abrirCaja($_POST);
            return $respuesta;
        }

        /* Cerrar Caja */
        public static function cerrarCaja(){
            
            $id = filter_var($_POST['id_caja'], FILTER_VALIDATE_INT);
            if(!$id){
                return 'no_validate';
            }
            $caja_actual = Caja::consultarCajas($id);
            $fecha_apertura = $caja_actual['fecha_apertura'];
            $fecha_cierre = $caja_actual['fecha_cierre'];
            $args['fecha_inicial'] = $fecha_apertura;
            date_default_timezone_set('America/Bogota');
            $args['fecha_final']  = date('Y-m-d H:i:s');
            $efectivo_ventas = Ventas::consultarVentasPorFecha($args, 'total');
            $creditos_array = Ventas::consultarVentasPorFecha($args, 'deuda');
            $pagos = Pagos::consultarPagos($args);
        
            $creditos = $creditos_array['total'];
           
            $efectivo_apertura = $caja_actual['efectivo_apertura'];
            $efectivo_cierre = $efectivo_ventas['total']+$efectivo_apertura-$creditos +$pagos['total'];
            $fecha_cierre = $args['fecha_final'];
            $estado = 1;

            $datos_caja_cierre = ['estado'=> $estado, 'efectivo_ventas'=>$efectivo_ventas['total']+$pagos['total'],'creditos'=>$creditos, 'efectivo_cierre'=>$efectivo_cierre,'fecha_cierre'=>$fecha_cierre];
           
            $actualizar_caja = new Caja();
            $respuesta = $actualizar_caja->actualizarCaja($datos_caja_cierre, $id);
            
            return $respuesta;
        }
    }