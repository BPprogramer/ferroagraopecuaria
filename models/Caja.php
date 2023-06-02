<?php 

    class Caja{
        public static function abrirCaja($args){
          
            $stmt = Conexion::conectarDB()->prepare("INSERT INTO cajas (vendedor,estado, efectivo_apertura, efectivo_ventas, efectivo_cierre, fecha_apertura )
             VALUES (:vendedor,:estado, :efectivo_apertura, :efectivo_ventas, :efectivo_cierre, :fecha_apertura)");
            $stmt->bindParam(":vendedor", $args['vendedor'], PDO::PARAM_STR);
            $stmt->bindParam(":estado", $args['estado'], PDO::PARAM_STR);
            $stmt->bindParam(":efectivo_apertura", $args['efectivo_apertura'], PDO::PARAM_STR);
            $stmt->bindParam(":efectivo_ventas", $args['efectivo_ventas'], PDO::PARAM_STR);
            $stmt->bindParam(":efectivo_cierre", $args['efectivo_cierre'], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_apertura", $args['fecha_apertura'], PDO::PARAM_STR);
            
            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
        
        }
        public static function consultarCajas($valor = null){
            if($valor == null){
                $stmt = Conexion::conectarDB()->prepare("SELECT * FROM cajas ORDER BY id DESC");
                $stmt->execute();
                $resultado = $stmt->fetchAll();
                return  $resultado;
            }else{
                $stmt = Conexion::conectarDB()->prepare("SELECT * FROM cajas WHERE id=:id");
                $stmt->bindParam(":id", $valor, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetch(); 
            }
            
        }
        public static function actualizarCaja($args, $id){
         
            $stmt = Conexion::conectarDB()->prepare("UPDATE  cajas SET estado=:estado,  efectivo_ventas=:efectivo_ventas, efectivo_cierre=:efectivo_cierre, 
            fecha_cierre=:fecha_cierre  WHERE id= :id");
          
        
            $stmt->bindParam(":estado", $args['estado'], PDO::PARAM_STR);
       
            $stmt->bindParam(":efectivo_ventas", $args['efectivo_ventas'], PDO::PARAM_STR);
            $stmt->bindParam(":efectivo_cierre", $args['efectivo_cierre'], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_cierre", $args['fecha_cierre'], PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            
          
            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
        }
    }