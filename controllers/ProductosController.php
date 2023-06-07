<?php
   
    class ProductosController{

        //consultar productos
        public static function consultarProductos($columna, $valor){
            $tabla = 'productos';
            $respuesta = Productos::consultarProductos($tabla, $columna, $valor);
            return $respuesta;
        }
        public static function consultarProductosDes($order){
            $respuesta = Productos::consultarProductosDes($order);
            return $respuesta;
        }

        public static function agregarStock(){
           
            $stock =  $_POST['agregar_stock'];
            $stock_actual = $_POST['stock_actual'];
            $id = $_POST['id_producto_editar'];
            $parttern = '/^\d+$/';
            if($stock == ''){
                return 'empty';
            }
            if(!preg_match($parttern, $stock)){
                return 'no_validate';
            }
            if(!preg_match($parttern, $stock_actual)){
                return 'no_validate';
            }
            if(!preg_match($parttern, $id)){
                return 'no_validate';
            }
     
            $args['id'] = $id;
            $args['stock'] = $stock+$stock_actual;
      
         
            $producto = new Productos();
            $respuesta = $producto->agregarStock($args);
            return $respuesta;

        }

        //para hacer un join despuesss
        // public static function consultarProductosProveedores(){
        //     $respuesta = Productos::consultarProductosProveedores($order);
        //     return $respuesta;
        // }
        
        
        public static function crearProducto(){
           $id_categoria = $_POST['idCategoria'];
        
           $id_proveedor = $_POST['idProveedor'];
           $codigo = $_POST['codigo'];
           $descripcion = $_POST['descripcion'];
           $precio_compra = $_POST['precio_compra'];
           $precio_venta = $_POST['precio_venta'];
           $stock = $_POST['stock'];
           $stock_minimo = $_POST['stock_minimo'];
           $stock_maximo = $_POST['stock_maximo'];
            // $imagen = $_FILES;
           $imagen = "views/img/productos/default/anonymous.png";
           $parttern_1 = '/^[0-9.]+$/';
           $parttern_2 = '/^[-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ \/]+$/';

           $id_proveedor = filter_var($id_proveedor, FILTER_VALIDATE_INT);
           
           if(!$id_proveedor){
                return 'datos_invalidos';
           }
        
           if(preg_match($parttern_2, $descripcion) && preg_match($parttern_1, $codigo) && preg_match($parttern_1, $stock) && preg_match($parttern_1, $stock_minimo) && preg_match($parttern_1, $stock_maximo) && preg_match($parttern_1, $precio_compra) && preg_match($parttern_1, $precio_venta)){
               
                if(isset($_FILES['imagen'])){
                    $info_img = getimagesize($_FILES['imagen']["tmp_name"]);
                  
                    if($info_img['mime']!='image/jpeg' && $info_img['mime']!='image/png'){
                        return 'imagen no compatible';
                    }
              
                    if(($_FILES['imagen']['tmp_name']) !== ""){
                         list($width, $height) = getimagesize($_FILES['imagen']['tmp_name']);
                         $newWidth = 500;
                         $newHeight = 500;

                         $directorio ="../views/img/productos/fotos/";
                       
                         if(!is_dir($directorio)){
                             mkdir($directorio);
                         }
                      
                         $nombre_imagen = md5(uniqid(rand(),true));
                       
                    
                        if($_FILES['imagen']['type'] == "image/jpeg"){
                            
                            //guardamos la imagen 
                           
                            $imagen =$directorio.$nombre_imagen.".jpg";
                             $img_origen = imagecreatefromjpeg($_FILES["imagen"]["tmp_name"]); ///////
                            $img_destino = imagecreatetruecolor($newWidth, $newHeight);             
                            imagecopyresized($img_destino,$img_origen, 0, 0, 0,0, $newWidth, $newHeight,$width, $height);
                            imagejpeg($img_destino, $imagen);
                            $imagen = 'views/img/productos/fotos/'.$nombre_imagen.".jpg";
                        
                        }
                        if($_FILES['imagen']['type'] == "image/png"){
                            
                            //guardamos la imagen 
                           
                            $imagen = $directorio.$nombre_imagen.".png";
                             $img_origen = imagecreatefrompng($_FILES["imagen"]["tmp_name"]); ///////
                            $img_destino = imagecreatetruecolor($newWidth, $newHeight);             
                            imagecopyresized($img_destino,$img_origen, 0, 0, 0,0, $newWidth, $newHeight,$width, $height);
                            imagejpeg($img_destino, $imagen);
                            $imagen = 'views/img/productos/fotos/'.$nombre_imagen.".png";
                        
                        }
                    }
                }
            
                $tabla = "productos";
                $datos = array("id_categoria"=>$id_categoria,'id_proveedor'=>$id_proveedor, "codigo"=>$codigo, "descripcion"=>$descripcion, "stock"=>$stock,"stock_minimo"=>$stock_minimo,"stock_maximo"=>$stock_maximo ,"precio_compra"=>$precio_compra, "precio_venta"=>$precio_venta, "imagen"=>$imagen);
                $producto = new Productos();
                return $producto->registrarProducto($tabla, $datos);

            //return 'success';
           }else{
                return "datos_invalidos";
           }

           
        }

        public static function editarProducto(){
            $id = $_POST['id_producto'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if(!$id){
                return 'id_invalido';
            }
            $id_proveedor =$_POST['editar_id_proveedor'];
            $id_proveedor = filter_var($id_proveedor, FILTER_VALIDATE_INT);
           
            if(!$id_proveedor){
                 return 'datos_no_validos';
            }
            $descripcion = $_POST['editar_descripcion'];
            $stock = $_POST['editar_stock'];
            $stock_minimo = $_POST['editar_stock_minimo'];
            $stock_maximo = $_POST['editar_stock_maximo'];
            $precio_compra = $_POST['editar_precio_compra'];
            $precio_venta = $_POST['editar_precio_venta'];

            $parttern_1 = '/^[0-9.]+$/';
            $parttern_2 = '/^[-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ \/]+$/';

           
            if(preg_match($parttern_2, $descripcion) &&  preg_match($parttern_1, $stock) && preg_match($parttern_1, $stock_minimo) && preg_match($parttern_1, $stock_maximo) && preg_match($parttern_1, $precio_compra) && preg_match($parttern_1, $precio_venta)){
                $tabla = 'productos';
                $columna = 'id';
              
                //verificar si subieron nueva imagen
                $imagen = Productos::consultarProductos('productos', 'id', $id);
                $imagen = $imagen['imagen'];
            
                 if(!empty($_FILES['editar_imagen'])){
                    $info_img = getimagesize($_FILES['editar_imagen']["tmp_name"]);
                    if($info_img['mime']!='image/jpeg' && $info_img['mime']!='image/png'){
                        return 'imagen no compatible';
                    }
                   
                         
                    if($imagen != 'views/img/productos/default/anonymous.png'){
                        if(file_exists('../'.$imagen)){
                            unlink('../'.$imagen);
                        }
                     
                    }
                    
           
              
                    if(($_FILES['editar_imagen']['tmp_name']) !== ""){
                         list($width, $height) = getimagesize($_FILES['editar_imagen']['tmp_name']);
                         $newWidth = 500;
                         $newHeight = 500;

                         $directorio ="../views/img/productos/fotos/";
                       
                         if(!is_dir($directorio)){
                             mkdir($directorio);
                         }
                      
                         $nombre_imagen = md5(uniqid(rand(),true));
                       
                    
                        if($_FILES['editar_imagen']['type'] == "image/jpeg"){
                            
                            //guardamos la imagen 
                           
                            $imagen =$directorio.$nombre_imagen.".jpg";
                             $img_origen = imagecreatefromjpeg($_FILES["editar_imagen"]["tmp_name"]); ///////
                            $img_destino = imagecreatetruecolor($newWidth, $newHeight);             
                            imagecopyresized($img_destino,$img_origen, 0, 0, 0,0, $newWidth, $newHeight,$width, $height);
                            imagejpeg($img_destino, $imagen);
                            $imagen = 'views/img/productos/fotos/'.$nombre_imagen.".jpg";
                        
                        }
                        if($_FILES['editar_imagen']['type'] == "image/png"){
                            
                            //guardamos la imagen 
                           
                            $imagen = $directorio.$nombre_imagen.".png";
                    
                            $img_origen = imagecreatefrompng($_FILES["editar_imagen"]["tmp_name"]); ///////
                            $img_destino = imagecreatetruecolor($newWidth, $newHeight);             
                            imagecopyresized($img_destino,$img_origen, 0, 0, 0,0, $newWidth, $newHeight,$width, $height);
                            imagejpeg($img_destino, $imagen);
                            $imagen = 'views/img/productos/fotos/'.$nombre_imagen.".png";
                           
                        }
                    }
                } 
             

                //fin de verificar
                

                $datos = array('id'=>$id, 'id_proveedor'=>$id_proveedor, 'descripcion'=>$descripcion, 'imagen'=>$imagen, 'stock'=>$stock,'stock_minimo'=>$stock_minimo, 'stock_maximo'=>$stock_maximo, 'precio_compra'=>$precio_compra, 'precio_venta'=>$precio_venta);
                $producto = new Productos();
                return $producto->editarProducto($tabla,$columna,  $datos);
            }else{
                return 'datos_no_validos';
            }

            


        }

        /* Eliminar PRoducto */
        public static function eliminarProducto(){
            $id = $_POST['id_eliminar'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
        
            if(!$id){
                return 'error';
            }
    
            $imagen = Productos::consultarProductos('productos', 'id', $id);
            $imagen = $imagen['imagen'];
            if($imagen != 'views/img/productos/default/anonymous.png'){
                if(file_exists('../'.$imagen)){
                    unlink('../'.$imagen);
                }
               
             }


            $producto = new Productos();
            return $producto->eliminarProducto('productos', 'id', $id);

           
        }


    }
