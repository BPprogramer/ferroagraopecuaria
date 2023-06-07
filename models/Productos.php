<?php 

    require_once 'Conexion.php';
    class Productos{

        public static function consultarProductos($tabla, $columna,$valor){
            if($columna){
                $stmt = Conexion::conectarDB()->prepare("SELECT * FROM $tabla WHERE $columna = :$columna ORDER BY id DESC");
                $stmt-> bindParam(":".$columna, $valor, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetch();
            }else{
                $stmt = Conexion::conectarDB()->prepare("SELECT * FROM $tabla");
                $stmt->execute();
                $resultado = $stmt->fetchAll();
                return  $resultado;
            }
   
        }
        public static function consultarProducto(){
            if($columna){
                $stmt = Conexion::conectarDB()->prepare("SELECT * FROM $tabla WHERE $columna = :$columna");
                $stmt-> bindParam(":".$columna, $valor, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetch();
            }
        }
        public static function consultarProductosDes($order){
            $stmt = Conexion::conectarDB()->prepare("SELECT * FROM productos ORDER BY $order DESC");
            $stmt->execute();
            $resultado = $stmt->fetchAll();
            return  $resultado;
        }

        //aqui haremos un join despues
        // public static function consultarProductosProveedores(){
        //     $stmt = Conexion::conectarDB()->prepare("SELECT * FROM productos ORDER BY $order DESC");
        //     $stmt->execute();
        //     $resultado = $stmt->fetchAll();
        //     return  $resultado;
        // }

        public function registrarProducto($tabla, $datos){
          
            $stmt = Conexion::conectarDB()->prepare("INSERT INTO $tabla (id_categoria, id_proveedor, codigo, descripcion, imagen, stock, stock_minimo, stock_maximo, precio_compra, precio_venta) VALUES (:id_categoria,:id_proveedor, :codigo, :descripcion, :imagen, :stock,:stock_minimo, :stock_maximo, :precio_compra, :precio_venta)");
            $stmt->bindParam(":id_categoria", $datos['id_categoria'], PDO::PARAM_STR);
            $stmt->bindParam(":id_proveedor", $datos['id_proveedor'], PDO::PARAM_STR);
            $stmt->bindParam(":codigo", $datos['codigo'], PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $datos['descripcion'], PDO::PARAM_STR);
       
            $stmt->bindParam(":imagen", $datos['imagen'], PDO::PARAM_STR);
            $stmt->bindParam(":stock", $datos['stock'], PDO::PARAM_STR);
            $stmt->bindParam(":stock_minimo", $datos['stock_minimo'], PDO::PARAM_STR);
            $stmt->bindParam(":stock_maximo", $datos['stock_maximo'], PDO::PARAM_STR);
         
            $stmt->bindParam(":precio_compra", $datos['precio_compra'], PDO::PARAM_STR);
            $stmt->bindParam(":precio_venta", $datos['precio_venta'], PDO::PARAM_STR);

            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
          
        }
        public function editarProducto($tabla, $columna, $datos){
         
            $stmt = Conexion::conectarDB()->prepare("UPDATE $tabla SET id_proveedor=:id_proveedor, descripcion =:descripcion, imagen =:imagen, stock=:stock, stock_minimo=:stock_minimo, stock_maximo = :stock_maximo, precio_compra=:precio_compra, precio_venta = :precio_venta WHERE id= :id");
            $stmt->bindParam(":id_proveedor", $datos['id_proveedor'],  PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $datos['descripcion'],  PDO::PARAM_STR);
            $stmt->bindParam(":imagen", $datos['imagen'], PDO::PARAM_STR);
            $stmt->bindParam(":stock", $datos['stock'],  PDO::PARAM_STR);
            $stmt->bindParam(":stock_minimo", $datos['stock_minimo'],  PDO::PARAM_STR);
            $stmt->bindParam(":stock_maximo", $datos['stock_maximo'],  PDO::PARAM_STR);
            $stmt->bindParam(":precio_compra", $datos['precio_compra'],  PDO::PARAM_STR);
            $stmt->bindParam(":precio_venta", $datos['precio_venta'],  PDO::PARAM_STR);
            $stmt->bindParam(":id", $datos['id'],  PDO::PARAM_STR);
            if($stmt->execute()){
                return 'success';
            }else{
                return 'error';
            }
        }
        public function agregarStock($args){
 
            $stmt = Conexion::conectarDB()->prepare("UPDATE productos SET stock = :stock WHERE id = :id");
            $stmt->bindParam(":stock", $args['stock'],PDO::PARAM_STR);
            $stmt->bindParam(":id", $args['id'],PDO::PARAM_STR);
            if($stmt->execute()){
                return 'success';
            }else{
                return 'error';
            }
        }

        /* eliminar Producto */
        public function eliminarProducto($tabla, $columna, $valor){
           
            $stmt = Conexion::conectarDB()->prepare("DELETE from $tabla WHERE $columna = :$columna");
            $stmt->bindParam(":".$columna, $valor, PDO::PARAM_STR);
            if($stmt->execute()){
                return 'success';
            }else{
                return 'error';
            }
        }
       
        public  function actualizarProducto($tabla, $columna1, $valor1, $valor2){
            $stmt = Conexion::conectarDB()->prepare("UPDATE $tabla SET $columna1 = :$columna1  WHERE id= :id");
    
            $stmt->bindParam(":".$columna1, $valor1, PDO::PARAM_INT );
            $stmt->bindParam(":id",$valor2, PDO::PARAM_INT );
            // return $stmt;
            // return ['tabla'=>$tabla, 'columna1'=>$columna1, 'valor1'=>$valor1,'valor2'=>intval($valor2)];
            //return 'codigo';
            if($stmt->execute()){
                return 'ok';
            }else{
                return 'error';
            }
          

        }
    }

    ?>