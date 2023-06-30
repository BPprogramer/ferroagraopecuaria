

<?php 
    
    class Credito{
        public static function consultarCredito($columna, $valor){
            $stmt = Conexion::conectarDB()->prepare("SELECT * FROM creditos WHERE $columna = :$columna ");
            $stmt->bindParam(":".$columna, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();

        }
        public function guardarCredito($args){
            $stmt = Conexion::conectarDB()->prepare("INSERT INTO creditos (codigo_venta, id_cliente, nombre_cliente,  total, deuda,interes, ultimo_pago, fecha_venta) VALUES ( :codigo_venta,  :id_cliente, :nombre_cliente, :total, :deuda, :interes, :ultimo_pago, :fecha_venta)");
            $stmt->bindParam(":codigo_venta", $args['codigo'], PDO::PARAM_STR);
         
            $stmt->bindParam(":id_cliente", $args['id_cliente'], PDO::PARAM_STR);
       
            $stmt->bindParam(":nombre_cliente", $args['nombre_cliente'], PDO::PARAM_STR);
      
    
            $stmt->bindParam(":total", $args['total'], PDO::PARAM_STR);
            $stmt->bindParam(":deuda", $args['deuda'], PDO::PARAM_STR);
            $stmt->bindParam(":interes", $args['interes'], PDO::PARAM_STR);
            $stmt->bindParam(":ultimo_pago", $args['fecha'], PDO::PARAM_STR);
   
            $stmt->bindParam(":fecha_venta",$args['fecha'], PDO::PARAM_STR);
 

            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
          
        }
        public function editarCredito($columna_1, $valor_1, $columna_2, $valor_2, $ultimo_pago){{
            $stmt = Conexion::conectarDB()->prepare("UPDATE  creditos SET  $columna_2=:$columna_2 , ultimo_pago=:ultimo_pago WHERE $columna_1= :$columna_1");
            $stmt->bindParam(":".$columna_2, $valor_2, PDO::PARAM_STR);
            $stmt->bindParam(":ultimo_pago", $ultimo_pago, PDO::PARAM_STR);
            $stmt->bindParam(":".$columna_1, $valor_1, PDO::PARAM_STR);
          
            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
          
        }

        }

        public function eliminarCredito($columna, $valor){

            $smtp = Conexion::conectarDB()->prepare("DELETE FROM creditos where $columna=:$columna");
            $smtp->bindParam(":".$columna, $valor, PDO::PARAM_STR);
            if($smtp->execute()){
                return "success";
            }else{
                return "error";
            }
        }

        public static function consultarCreditoPorCliente($id_cliente){
            $smtp = Conexion::conectarDB()->prepare(" SELECT SUM(deuda) as total_deuda FROM creditos WHERE id_cliente = :id_cliente ");
            $smtp->bindParam(":id_cliente", $id_cliente, PDO::PARAM_STR);
            $smtp->execute();
            $resultado = $smtp->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }
        public static function totalCreditos(){
            $smtp = Conexion::conectarDB()->prepare(" SELECT SUM(deuda) as total_creditos FROM creditos");
           
            $smtp->execute();
            $resultado = $smtp->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }
        public static function consultarCreditos(){
            
            $smtp = Conexion::conectarDB()->prepare("SELECT * FROM creditos ORDER BY id DESC");
            $smtp->execute();
            $resultado = $smtp->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        }
    }