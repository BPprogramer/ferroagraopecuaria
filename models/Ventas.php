<?php 
 require_once 'Conexion.php';
    class Ventas{
        public static function consultarVenta($tabla, $columna, $valor){
       
            $smtp = Conexion::conectarDB()->prepare("SELECT * FROM $tabla WHERE $columna = :$columna");
            $smtp-> bindParam(":".$columna, $valor, PDO::PARAM_STR);
            $smtp->execute();
            return $smtp->fetch();
        }
        
        public static function consultarVentaClienteId($tabla, $columna, $valor){
       
            $smtp = Conexion::conectarDB()->prepare("SELECT * FROM $tabla WHERE $columna = :$columna");
            $smtp-> bindParam(":".$columna, $valor, PDO::PARAM_STR);
            $smtp->execute();
            $resultado = $smtp->fetchAll();
            return $resultado;
        }
        
        public static function consultarVentas($tabla, $columna, $valor, $orderById){
           
            if($orderById !=null){
                $smtp = Conexion::conectarDB()->prepare("SELECT * FROM $tabla ORDER BY $orderById DESC LIMIT 1");
                $smtp->execute();
                return $smtp->fetch();
            }else{
                $smtp = Conexion::conectarDB()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC");
                $smtp->execute();
                $resultado = $smtp->fetchAll();
              
                return  $resultado;
            }

        }

        public static function ventas(){
            $tabla = 'administrar_ventas';
            $smtp = Conexion::conectarDB()->prepare("SELECT * FROM $tabla");
            $smtp->execute();
            $resultado = $smtp->fetchAll();
            return $resultado;
        }
        
        public function registrarVenta($args, $tabla){
            $id_cliente = $args['id_cliente']??'';
            $stmt = Conexion::conectarDB()->prepare("INSERT INTO $tabla (codigo, id_vendedor, productos,  total, total_costo , deuda ,metodo_pago,id_cliente, nombre_cliente, cedula_cliente, telefono_cliente, direccion, correo, fecha) VALUES ( :codigo,  :id_vendedor, :productos, :total, :total_costo, :deuda ,:metodo_pago, :id_cliente, :nombre_cliente, :cedula_cliente, :telefono_cliente, :direccion, :correo,  :fecha)");
            $stmt->bindParam(":codigo", $args['codigo'], PDO::PARAM_STR);
         
            $stmt->bindParam(":id_vendedor", $args['id_vendedor'], PDO::PARAM_STR);
       
            $stmt->bindParam(":productos", $args['productos'], PDO::PARAM_STR);
      
    
            $stmt->bindParam(":total", $args['total'], PDO::PARAM_STR);
            $stmt->bindParam(":total_costo", $args['total_costo'], PDO::PARAM_STR);
            $stmt->bindParam(":deuda", $args['deuda'], PDO::PARAM_STR);
            $stmt->bindParam(":metodo_pago", $args['metodo_pago'], PDO::PARAM_STR);
            $stmt->bindParam(":id_cliente",$id_cliente , PDO::PARAM_STR);
            $stmt->bindParam(":nombre_cliente", $args['nombre_cliente'], PDO::PARAM_STR);
            $stmt->bindParam(":cedula_cliente", $args['cedula_cliente'], PDO::PARAM_STR);
            $stmt->bindParam(":telefono_cliente", $args['telefono_cliente'], PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $args['direccion_cliente'], PDO::PARAM_STR);
            $stmt->bindParam(":correo", $args['correo_cliente'], PDO::PARAM_STR);
            $stmt->bindParam(":fecha",$args['fecha'], PDO::PARAM_STR);
 

            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
          
        }

        public function actualizarVenta($args, $tabla){
       
            $id_cliente = $args['id_cliente']??'';
            $stmt = Conexion::conectarDB()->prepare("UPDATE  $tabla SET codigo=:codigo,  id_vendedor=:id_vendedor, productos=:productos, 
            total=:total, total_costo=:total_costo, deuda=:deuda ,metodo_pago=:metodo_pago,id_cliente=:id_cliente,
            nombre_cliente=:nombre_cliente, cedula_cliente=:cedula_cliente , telefono_cliente=:telefono_cliente,
            direccion=:direccion, correo=:correo WHERE id= :id");
            $stmt->bindParam(":codigo", $args['codigo'], PDO::PARAM_STR);
        
            $stmt->bindParam(":id_vendedor", $args['id_vendedor'], PDO::PARAM_STR);
       
            $stmt->bindParam(":productos", $args['productos'], PDO::PARAM_STR);
            $stmt->bindParam(":total", $args['total'], PDO::PARAM_STR);
            $stmt->bindParam(":total_costo", $args['total_costo'], PDO::PARAM_STR);
            $stmt->bindParam(":deuda", $args['deuda'], PDO::PARAM_STR);
            $stmt->bindParam(":metodo_pago", $args['metodo_pago'], PDO::PARAM_STR);
            $stmt->bindParam(":id_cliente",$id_cliente , PDO::PARAM_STR);
            $stmt->bindParam(":nombre_cliente", $args['nombre_cliente'], PDO::PARAM_STR);
            $stmt->bindParam(":cedula_cliente", $args['cedula_cliente'], PDO::PARAM_STR);
            $stmt->bindParam(":telefono_cliente", $args['telefono_cliente'], PDO::PARAM_STR);
            $stmt->bindParam(":direccion", $args['direccion_cliente'], PDO::PARAM_STR);
            $stmt->bindParam(":correo", $args['correo_cliente'], PDO::PARAM_STR);
            $stmt->bindParam(":id", $args['id'],  PDO::PARAM_STR);
          
            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
          
        }
        public function eliminarVenta($columna, $valor){
            $tabla = 'administrar_ventas';
            
            $smtp = Conexion::conectarDB()->prepare("DELETE FROM $tabla where id=:id");
            $smtp->bindParam(":id", $valor, PDO::PARAM_STR);
            if($smtp->execute()){
                return "success";
            }else{
                return "error";
            }
          
        }
        public function editarDatoVenta($columna_1, $valor_1, $columna_2, $valor_2){
            $stmt = Conexion::conectarDB()->prepare("UPDATE  administrar_ventas SET  $columna_2=:$columna_2 WHERE $columna_1= :$columna_1");
            $stmt->bindParam(":".$columna_2, $valor_2, PDO::PARAM_STR);
            $stmt->bindParam(":".$columna_1, $valor_1, PDO::PARAM_STR);
        
            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
        }
        public static function consultarRangoVentas($fecha_inicial,$fecha_final){
            // date_default_timezone_set('America/Bogota');
            $tabla = "administrar_ventas";
            $fecha_final = $fecha_final.' 23:59:59';
            $fecha_inicial = $fecha_inicial.' 00:00:00';
            $stmt = Conexion::conectarDB()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY id DESC");
      
            $stmt->execute();
            return $stmt->fetchAll();

        }
        public static function sumaPrecios($columna){

           // $smtp = Conexion::conectarDB()->prepare(" SELECT SUM(deuda) as total_deuda FROM creditos WHERE id_cliente = :id_cliente ");
            $smtp = Conexion::conectarDB()->prepare(" SELECT SUM($columna) as total_suma FROM administrar_ventas");
           
            $smtp->execute();
            $resultado = $smtp->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }
     
        public static function consultarVentasPorFecha($args, $columna){
            $fecha_inicial = $args['fecha_inicial'];
            $fecha_final = $args['fecha_final'];
   
 
            $stmt = Conexion::conectarDB()->prepare("SELECT SUM($columna) AS total FROM administrar_ventas WHERE fecha BETWEEN '$fecha_inicial' AND  '$fecha_final'");
            // $stmt->bindParam(':fecha_inicial', $args['fecha_inicial']);
            // $stmt->bindParam(':fecha_final',$args['fecha_final']);
            $stmt->execute();
        
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado;

        }
      

        
        
    }/* aspiradora industria

        stock 44
        compras 328s
        ventas 8


    */