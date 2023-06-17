<?php 

    class Egresos{
        public function agregarEgreso($args){
            $stmt;
            if(isset($args['id'])){
                $stmt =  Conexion::conectarDB()->prepare("UPDATE egresos  SET responsable=:responsable, egreso=:egreso, descripcion=:descripcion, nota=:nota, estado=:estado , fecha=:fecha WHERE id=:id");
            }else{
                $stmt = Conexion::conectarDB()->prepare("INSERT INTO egresos (responsable,egreso, descripcion, nota, estado, fecha) VALUES
             (:responsable, :egreso, :descripcion, :nota, :estado, :fecha)");
            }
       
            $stmt->bindParam(":responsable",$args['responsable'], PDO::PARAM_STR);
            $stmt->bindParam(":egreso",$args['egreso'], PDO::PARAM_STR);
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

        public static function consultarEgresos($columna, $valor){
            if($columna!=null){
                $stmt = Conexion::conectarDB()->prepare("SELECT * FROM egresos WHERE $columna = :$columna");
                $stmt-> bindParam(":".$columna, $valor, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetch();
            }else{
                $stmt = Conexion::conectarDB()->prepare("SELECT * FROM egresos ORDER BY id DESC");
                // $stmt->bindParam(':fecha_inicial', $args['fecha_inicial']);
                // $stmt->bindParam(':fecha_final',$args['fecha_final']);
                $stmt->execute();
                $resultado = $stmt->fetchAll();
                return  $resultado;
            }
        }

        public function eliminarEgreso($id){
            $stmt = Conexion::conectarDB()->prepare("DELETE from egresos WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            if($stmt->execute()){
                return 'success';
            }else{
                return 'error';
            }
        }
        public static function consultarEgresosPorFecha($args){
            $fecha_inicial = $args['fecha_inicial'];
            $fecha_final = $args['fecha_final'];
  
 
            $stmt = Conexion::conectarDB()->prepare("SELECT SUM(egreso) AS total FROM egresos WHERE fecha BETWEEN '$fecha_inicial' AND  '$fecha_final'");
            // $stmt->bindParam(':fecha_inicial', $args['fecha_inicial']);
            // $stmt->bindParam(':fecha_final',$args['fecha_final']);
            $stmt->execute();
        
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado;

        }
        public function cambiarEstados($args){
            $fecha_inicial = $args['fecha_inicial'];
            $fecha_final = $args['fecha_final'];
            $stmt = Conexion::conectarDB()->prepare("UPDATE egresos SET estado = 1 WHERE fecha BETWEEN '$fecha_inicial' AND  '$fecha_final'");
            $stmt->execute();
        
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado;
        }
        
    }