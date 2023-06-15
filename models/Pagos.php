
<?php 
    class Pagos{

        public function crearPago($args){
                
                $stmt = Conexion::conectarDB()->prepare("INSERT INTO pagos (pago, fecha )
                VALUES (:pago, :fecha )");
                $stmt->bindParam(":pago", $args['pago'], PDO::PARAM_STR);
                $stmt->bindParam(":fecha", $args['fecha'], PDO::PARAM_STR);
        
                if($stmt->execute()){
                    return "success";
                }else{
                    return "error";
                }
            
        }
        public static function consultarPagos($args){
            $fecha_inicial = $args['fecha_inicial'];
            $fecha_final = $args['fecha_final'];
   
 
            $stmt = Conexion::conectarDB()->prepare("SELECT SUM(pago) AS total FROM pagos WHERE fecha BETWEEN '$fecha_inicial' AND  '$fecha_final'");
            // $stmt->bindParam(':fecha_inicial', $args['fecha_inicial']);
            // $stmt->bindParam(':fecha_final',$args['fecha_final']);
            $stmt->execute();
        
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado;

        }
      
    }