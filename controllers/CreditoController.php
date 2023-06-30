
<?php 
    class CreditoController{
        public static function creditoIndex($id_cliente){
            $respuesta = Credito::consultarCreditoPorCliente($id_cliente);
            return $respuesta;
        }
        public static function consultarCreditos(){
            $creditos = Credito::consultarCreditos();
            return $creditos;
        }

        public static function consultarVenta(){
            $respuesta= Ventas::consultarVenta('administrar_ventas', 'codigo', $_POST['codigo_venta']);
            $vendedor  = Usuarios::consultarUsuario('usuarios', 'id', $respuesta['id_vendedor']);
            $credito = Credito::consultarCredito('codigo_venta', $respuesta['codigo']);
            
            //calculamos el valor de la deuda con interes
            date_default_timezone_set('America/Bogota');
            $fecha_ultimo_pago = $credito['ultimo_pago'];
            $fecha_actual = date('Y-m-d H:i:s');
            $diferencia = strtotime($fecha_actual) - strtotime($fecha_ultimo_pago);
            $diferencia_dias = floor($diferencia / (60 * 60 * 24));
            $deuda_i = $credito['deuda']+($credito['deuda']*$diferencia_dias)*($credito['interes']/3000);
       

            $respuesta['vendedor'] = $vendedor['nombre']??'anonimo';
            $respuesta['interes'] = $credito['interes'];
            $respuesta['deuda_i'] = $deuda_i;
            return $respuesta;
        }
        public static function pagoDeudas(){
     
            $pago = new Pagos();
            date_default_timezone_set('America/Bogota');
            $datosPago = ['pago'=>$_POST['valor_pago'], 'fecha'=>date('Y-m-d H:i:s')];
 
            $pago->crearPago($datosPago);

            $credito = Credito::consultarCredito('id',$_POST['id']);
            
            $codigo_vena = $credito['codigo_venta'];
            //$deuda = $credito['deuda']-$_POST['valor_pago'];
            $deuda = $_POST['deuda_actual']-$_POST['valor_pago'];
       
            $editar_credito = new Credito();
            $editar_credito->editarCredito('id',$_POST['id'], 'deuda',$deuda,date('Y-m-d H:i:s'));
            $editar_venta = new Ventas();
            $respuesta = $editar_venta->editarDatoVenta('codigo',$credito['codigo_venta'], 'deuda',$deuda);


            return $respuesta;
        }
     
    }