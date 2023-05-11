
<?php
    
//    require_once '../models/Ventas.php';
   
    class VentasController{


        public static function consultarVentas($columna, $valor, $orderById){
          
            $tabla = 'administrar_ventas';
           
            if($orderById===null){
                $respuesta = Ventas::consultarVentas($tabla, $columna, $valor, $orderById);
              
              
                foreach($respuesta as $key => $value){
                    //$cliente = Clientes::consultarClientes('clientes', 'id', $value['id_cliente']);
                    $vendedor = Usuarios::consultarUsuario('usuarios', 'id', $value['id_vendedor']);
                   
                    //$respuesta[$key]['nombre_cliente'] = $cliente['nombre']??'anonimo';
                    $respuesta[$key]['nombre_vendedor'] = $vendedor['nombre']??'anonimo';
                }
           
            
            return $respuesta;
            }else if($orderById == false){
                
                $respuesta = Ventas::consultarVenta($tabla, $columna, $valor);
                
                return $respuesta;
            }else{
                $respuesta = Ventas::consultarVentas($tabla, $columna, $valor, $orderById);
                return $respuesta;
            }
        }
        

        //datos para la factura
        public static function consultarDatosVenta($columna, $valor){
            $venta = Ventas::consultarVenta('administrar_ventas', $columna, $valor);
            $vendedor =  Usuarios::consultarUsuario('usuarios','id',$venta['id_vendedor']);
            $venta['pago_total'] = $venta['total']-$venta['deuda'];
            $venta['nombre_vendedor'] = $vendedor['nombre']??'anonimo';
            
            return $venta;
        }


        public static function crearVenta(){
         
            require_once '../models/Productos.php';
            require_once '../models/Clientes.php';
            require_once '../models/Ventas.php';
            require_once '../models/Credito.php';


            $productos = json_decode($_POST['productos'],true); 
   
            date_default_timezone_set('America/Bogota');
            $fecha_actual = date('Y-m-d H:i:s');
            $_POST['fecha'] = $fecha_actual;
        
            
            $producto_objeto = new Productos();
           
            //sumar todas las cantidades 
            $total_cantidad_productos = array();

            foreach($productos as $key=>$value){
                    array_push($total_cantidad_productos, $value['cantidad']);
                    $tabla = 'productos';
                    $columna = 'id';
                    $valor = $value['id'];
                
                    $producto = Productos::consultarProductos($tabla, $columna, $valor);

                

                    //actualizamos el numero de ventas
                    $columna1 = "ventas";
                    $valor1 = $value['cantidad']+$producto['ventas'];
                    //return $valor1;
                    $valor2 = $value['id'];
                
                    $respuesta = $producto_objeto->actualizarProducto($tabla, $columna1, $valor1, $valor2);
            
                    //actualizamos el numero de stock
                    $columna1 = "stock";
                    $valor1 = $value['stock_actual'];
                    $valor2 = $value['id'];

                    $producto_objeto->actualizarProducto($tabla, $columna1, $valor1, $valor2);
            }  
            //aqui rvisamos si el cliente esta sacando fiado
            if($_POST['metodo_pago']=='credito'){
                    $credito = new Credito();
                    $tabla = 'clientes';
                    $columna = 'id';
                    $valor = $_POST['id_cliente'];
        
                    $cliente = Clientes::consultarClientes($tabla,$columna, $valor);
                    $args['codigo'] = $_POST['codigo'];
                    $args['id_cliente'] = $cliente['id'];
                    $args['nombre_cliente'] = $cliente['nombre'];
                    $args['total'] = $_POST['total'];
                    $args['deuda'] = $_POST['deuda'];
                    $args['fecha'] = $_POST['fecha'];
                    $respuesta = $credito->guardarCredito($args);
                    if($respuesta=='error'){
                        return $respuesta;
                    }
                       
            }
      
           //guardar la venta
          
           $venta = new Ventas();
           $tabla = 'administrar_ventas';
           $respuesta = $venta->registrarVenta($_POST, $tabla);
       
           return $respuesta;
           
        //   
        }

        public static function editar_venta(){
          
            
            require_once '../models/Productos.php';
        
            require_once '../models/Ventas.php';
            require_once '../models/Credito.php';
            
            date_default_timezone_set('America/Bogota');
            $fecha_actual = date('Y-m-d H:i:s');
            $_POST['fecha'] = $fecha_actual;
         
           //return $_POST;
            //formateamos la tabla de productos y la de clientes a como estaba antes
            $venta = Ventas::consultarVenta('administrar_ventas', 'codigo', $_POST['codigo']);
        

            $productos_anteriores = json_decode($venta['productos'],true);
            $cantidad_anterior = 0;
            $producto_objeto = new Productos();
            foreach($productos_anteriores as $producto){
                $cantidad_anterior = $cantidad_anterior + $producto['cantidad'];
               
                $traer_producto = Productos::consultarProductos('productos', 'id', $producto['id']);
                $stock = $traer_producto['stock'] + $producto['cantidad']; 
                $ventas = $traer_producto['ventas'] - $producto['cantidad']; 
                $respuesta = $producto_objeto->actualizarProducto('productos', 'stock', $stock, $producto['id']); //actualizamos el stock 
                $respuesta = $producto_objeto->actualizarProducto('productos', 'ventas', $ventas, $producto['id']); //actualizamos el numero de ventas
                
            }
            
            if($venta['metodo_pago']=='credito'){ //eliminamos el credito anterior
                $credito = new Credito();
                $respuesta = $credito->eliminarCredito('codigo_venta', $venta['codigo']);
              
                if($respuesta=='error'){
                    return $error;
                }
            }
            if($_POST['metodo_pago']=='credito'){
                $credito = new Credito();
                $tabla = 'clientes';
                $columna = 'id';
                $valor = $_POST['id_cliente'];
    
                $cliente = Clientes::consultarClientes($tabla,$columna, $valor);
                $args['codigo'] = $_POST['codigo'];
                $args['id_cliente'] = $cliente['id'];
                $args['nombre_cliente'] = $cliente['nombre'];
                $args['total'] = $_POST['total'];
                $args['deuda'] = $_POST['deuda'];
                $args['fecha'] = $_POST['fecha'];
                $respuesta = $credito->guardarCredito($args);
                if($respuesta=='error'){
                    return $respuesta;
                }
                   
             }
            
        
           
            
            
          
        //     //desde aqui empezamos a actualizar la compra
            $productos = json_decode($_POST['productos'],true); 
          
            
            //sumar todas las cantidades 
            $total_cantidad_productos = array();
            
            foreach($productos as $key=>$value){

                    array_push($total_cantidad_productos, $value['cantidad']);
                    $tabla = 'productos';
                    $columna = 'id';
                    $valor = $value['id'];
                 
                    $producto = Productos::consultarProductos($tabla, $columna, $valor);
            
            
                
                    //actualizamos el numero de ventas
                    $columna1 = "ventas";
                    $valor1 = $value['cantidad']+$producto['ventas'];
                    //return $valor1;
                    $valor2 = $value['id'];
                
                    $respuesta = $producto_objeto->actualizarProducto($tabla, $columna1, $valor1, $valor2);
            
                    //actualizamos el numero de stock
                    $columna1 = "stock";
                    $valor1 = $value['stock_actual'];
                    $valor2 = $value['id'];

                    $producto_objeto->actualizarProducto($tabla, $columna1, $valor1, $valor2);
            }  
           //revisar si el cliente ya izo compras
           
        
           
        
          
           $venta = new Ventas();
           //guardar la venta
           
           $tabla = 'administrar_ventas';
           $respuesta = $venta->actualizarVenta($_POST, $tabla);
       
           return $respuesta;
           
        //   
        }

        public static function eliminar_venta(){
            $cliente = new Clientes();
            //require_once '../models/Ventas.php';
            $venta = Ventas::consultarVenta('administrar_ventas', 'id', $_POST['id']);
            if($venta['deuda']>0){
                return 'pendiente';
            }

          /*   $ventas_al_cliente = Ventas::consultarVentaClienteId('administrar_ventas', 'id_cliente', $venta['id_cliente']);
           
            $fechas_venta = [];
            foreach($ventas_al_cliente as $alias_venta){
                
                array_push($fechas_venta, $alias_venta['fecha']);
            }
            */
           /*  if(count($fechas_venta)>1){
                if(strtotime($venta['fecha'])==strtotime($fechas_venta[count($fechas_venta)-1])){
                   
                    $cliente->actualizarCliente('clientes', 'ultima_compra', $fechas_venta[count($fechas_venta)-2], $venta['id_cliente']);
                }
            }else{
                $cliente->actualizarCliente('clientes', 'ultima_compra', '0000-00-00 00:00:00', $venta['id_cliente']);
            } */
           
            //formateamos productos y clientes
            $producto_objeto = new Productos();
            $objeto_cliente = new Clientes();
           //return $_POST;

            //formateamos la tabla de productos y la de clientes a como estaba antes
           

            $productos_anteriores = json_decode($venta['productos'],true);
            $cantidad_anterior = 0;
            foreach($productos_anteriores as $producto){
                $cantidad_anterior = $cantidad_anterior + $producto['cantidad'];

                $traer_producto = Productos::consultarProductos('productos', 'id', $producto['id']);+
                $stock = $traer_producto['stock'] + $producto['cantidad']; 
                $ventas = $traer_producto['ventas'] - $producto['cantidad']; 
                $producto_objeto->actualizarProducto('productos', 'stock', $stock, $producto['id']); //actualizamos el stock 
                $producto_objeto->actualizarProducto('productos', 'ventas', $ventas, $producto['id']); //actualizamos ell numero de ventas
                
            }
           
           // $traer_cliente =  Clientes::consultarClientes('clientes','id', $venta['id_cliente']);
            //$compras_cliente = $traer_cliente['compras']-$cantidad_anterior;
            
            //$objeto_cliente->actualizarCliente('clientes', 'compras', $compras_cliente, $venta['id_cliente']); 

            //eliminar la venta
            $venta = new Ventas();
            $respuesta = $venta->eliminarVenta('id', $_POST['id']);
            return $respuesta;

        }
        public static function consultarRangoVentas($fecha_inicial, $fecha_final){
            // date_default_timezone_set('America/Bogota');
            $respuesta = Ventas::consultarRangoVentas($fecha_inicial, $fecha_final);
            foreach($respuesta as $key => $value){
            
                $vendedor = Usuarios::consultarUsuario('usuarios', 'id', $value['id_vendedor']);
               
               
                $respuesta[$key]['nombre_vendedor'] = $vendedor['nombre']??'anonimo';
            }

           return $respuesta;
        }

        public static function descargarReporteVentas(){
           
            if(isset($_GET['type'])){
                $fecha_final = $_GET['ff'];
                $fecha_inicial = $_GET['fi'];
                $fecha_inicial = filter_var($fecha_inicial, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}-\d{1,2}-\d{1,2}$/")));
                $fecha_final = filter_var($fecha_final, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}-\d{1,2}-\d{1,2}$/")));
             
                if ($fecha_inicial==false || $fecha_final==false) {
                    return;
                }
                $ventas =  Ventas::consultarRangoVentas($fecha_inicial, $fecha_final);
                foreach($ventas as $venta){
                  //  $cliente = Clientes::consultarClientes('clientes', 'id', $venta['id_cliente']);
                    $vendedor = Usuarios::consultarUsuario('usuarios', 'id', $venta['id_vendedor']);
                    $productos = json_decode($venta['productos'], true);

                  //  $cliente_nombre = $cliente['nombre']??'anonimo';
                   
                    // echo "<pre>";
                    // var_dump($cliente_nombre);
                    // echo "</pre>";
               
                }
                  
                $name = 'reporte.xls';

                    
                header('Expires: 0');
                header('Cache-control: private');
                header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
                header("Cache-Control: cache, must-revalidate"); 
                header('Content-Description: File Transfer');
                header('Last-Modified: '.date('D, d M Y H:i:s'));
                header("Pragma: public"); 
                header('Content-Disposition:; filename="'.$name.'"');
                header("Content-Transfer-Encoding: binary");
                ob_clean();
                echo utf8_decode("<table border='0'> 

                    <tr> 
                        <td style='font-weight:bold; border:2px solid #000;'>CÓDIGO</td> 
                        <td style='font-weight:bold; border:2px solid #000;'>CLIENTE</td>
                        <td style='font-weight:bold; border:2px solid #000;'>VENDEDOR</td>
                        <td style='font-weight:bold; border:2px solid #000;'>CANTIDAD</td>
                        <td style='font-weight:bold; border:2px solid #000;'>PRODUCTOS</td>
                        <td style='font-weight:bold; border:2px solid #000;'>PRECIO UNITARIO</td>
                        <td style='font-weight:bold; border:2px solid #000;'>IMPUESTO</td>
                        <td style='font-weight:bold; border:2px solid #000;'>NETO</td>		
                        <td style='font-weight:bold; border:2px solid #000;'>TOTAL</td>		
                        <td style='font-weight:bold; border:2px solid #000;'>METODO DE PAGO</td	
                        <td style='font-weight:bold; border:2px solid #000;'>FECHA</td>		
                    </tr>"
                );

                foreach($ventas as $venta){
                    //$cliente = Clientes::consultarClientes('clientes', 'id', $venta['id_cliente']);
                    $vendedor = Usuarios::consultarUsuario('usuarios', 'id', $venta['id_vendedor']);
                   // $nombre_cliente = $cliente['nombre']??'anonimo';
                    $nombre_vendedor = $vendedor['nombre']??'anonimo';
                    echo utf8_decode(
                        "<tr>
                            <td style='border:2px solid #000;'>".$venta["codigo"]."</td> 
                            <td style='border:2px solid #000;'>Anonimo</td>
                            <td style='border:2px solid #000;'>".$nombre_vendedor."</td>
                            <td style='border:2px solid #000;'>");
                            
                            $productos = json_decode($venta['productos'], true);
                            foreach($productos as $key=>$value){
                                echo utf8_decode($value['cantidad']."<br>");
                            }

                            echo "</td>";
                            echo utf8_decode("<td style='border:2px solid #000;'>");
                            foreach($productos as $key=>$value){
                                echo utf8_decode($value['precio_producto']."<br>");
                            }
                            echo "</td>";
                            echo utf8_decode("<td style='border:2px solid #000;'>");
                            foreach($productos as $key=>$value){
                                echo utf8_decode($value['precio_producto']."<br>");
                            }

                            echo "</td>";
                            echo utf8_decode(
                                "<td style='border:2px solid #000;'>".number_format(floatval($venta['total']),2)."</td>
                                <td style='border:2px solid #000;'>".number_format(floatval($venta['deuda']),2)."</td>
                                <td style='border:2px solid #000;'>".number_format(floatval($venta['total']-$venta['deuda']),2)."</td>
                                <td style='border:2px solid #000;'>".$venta['metodo_pago']."</td>
                                <td style='border:2px solid #000;'>".$venta['fecha']."</td>"
                            );



                    echo "</tr>";

                }

                echo "</table>";


            }else{
                
            }
        }

       
    
    }
   
