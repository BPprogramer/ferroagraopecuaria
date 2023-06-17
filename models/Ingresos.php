<?php 

    class Ingresos{
        public function agregarIngreso($args){
            $stmt;
            if(isset($args['id'])){
                $stmt =  Conexion::conectarDB()->prepare("UPDATE ingresos  SET responsable=:responsable, ingreso=:ingreso, descripcion=:descripcion, nota=:nota, estado=:estado , fecha=:fecha WHERE id=:id");
            }else{
                $stmt = Conexion::conectarDB()->prepare("INSERT INTO ingresos (responsable,ingreso, descripcion, nota, estado, fecha) VALUES
             (:responsable, :ingreso, :descripcion, :nota, :estado, :fecha)");
            }
       
            $stmt->bindParam(":responsable",$args['responsable'], PDO::PARAM_STR);
            $stmt->bindParam(":ingreso",$args['ingreso'], PDO::PARAM_STR);
            $stmt->bindParam(":descripcion",$args['descripcion'], PDO::PARAM_STR);
            $stmt->bindParam(":nota",$args['nota'], PDO::PARAM_STR);
            $stmt->bindParam(":estado",$args['estado'], PDO::PARAM_STR);
            $stmt->bindParam(":fecha",$args['fecha'], PDO::PARAM_STR);
            if(isset($args['id'])){
                $stmt->bindParam(":id",$args['id'], PDO::PARAM_STR);
            }
           
            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
        }

        public static function consultarIngresos($columna, $valor){
            if($columna!=null){
                $stmt = Conexion::conectarDB()->prepare("SELECT * FROM ingresos WHERE $columna = :$columna");
                $stmt-> bindParam(":".$columna, $valor, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetch();
            }else{
                $stmt = Conexion::conectarDB()->prepare("SELECT * FROM ingresos ORDER BY id DESC");
                // $stmt->bindParam(':fecha_inicial', $args['fecha_inicial']);
                // $stmt->bindParam(':fecha_final',$args['fecha_final']);
                $stmt->execute();
                $resultado = $stmt->fetchAll();
                return  $resultado;
            }
        }

        public function eliminarIngreso($id){
            $stmt = Conexion::conectarDB()->prepare("DELETE from ingresos WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            if($stmt->execute()){
                return 'success';
            }else{
                return 'error';
            }
        }
        public static function consultarIngresosPorFecha($args){
            $fecha_inicial = $args['fecha_inicial'];
            $fecha_final = $args['fecha_final'];
   
 
            $stmt = Conexion::conectarDB()->prepare("SELECT SUM(ingreso) AS total FROM ingresos WHERE fecha BETWEEN '$fecha_inicial' AND  '$fecha_final'");
            // $stmt->bindParam(':fecha_inicial', $args['fecha_inicial']);
            // $stmt->bindParam(':fecha_final',$args['fecha_final']);
            $stmt->execute();
        
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado;

        }
        public function cambiarEstados($args){
            $fecha_inicial = $args['fecha_inicial'];
            $fecha_final = $args['fecha_final'];
            $stmt = Conexion::conectarDB()->prepare("UPDATE ingresos SET estado = 1 WHERE fecha BETWEEN '$fecha_inicial' AND  '$fecha_final'");
            $stmt->execute();
        
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }
        
    }