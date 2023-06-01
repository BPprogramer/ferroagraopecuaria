<?php

    require_once '../controllers/ProductosController.php';
    require_once '../models/Productos.php';
    require_once "../controllers/CategoriasController.php";
    require_once "../models/Categorias.php";

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    class AjaxTablaProductos{
        public function mostrarTablaProductos(){

            $productos = ProductosController::consultarProductos(null, null);
            $i=0;
            
            
      
            $datoJson = '{
                "data": [';
                    foreach($productos as $key=>$producto){
                        $i++;
                        $imagen = "<img class='img-thumbmail' style='width:40px' src='".$producto['imagen']."'>";
                        $categoria = CategoriasController::consultarCategorias('id', $producto['id_categoria']);
                      
                    
                        $nombre_categoria = $categoria['nombre']??'anonimo';
                       
                        $botones = "<div>";
                        
                        $botones .= "<button class='btn btn-primary btnInfoProducto' idProducto='".$producto['id']."'  data-toggle='modal' data-target='#infoProducto'><i class='fa fa-search' ></i></button>";
                        $botones .= "<button class='btn btn-warning btnEditarProducto' idProducto='".$producto['id']."' data-toggle='modal' data-target='#editarProducto'><i class='fa fa-pencil' ></i></button>";
                        $botones .= "<button class='btn btn-danger btnEliminarProducto' idProducto='".$producto['id']."'><i class='fa fa-times'   data-toggle='modalEliminar' data-target='#modalEliminarProducto'</i></button>";
                        $botones .= "</div>";
                        if($producto['stock']<$producto['stock_minimo']){
                            $stock = "<button class='btn btn-danger'>".$producto['stock']."</button>";
                        }else if($producto['stock']>$producto['stock_maximo']){
                            $stock = "<button class='btn btn-warning'>".$producto['stock']."</button>";
                        }else{
                            $stock = "<button class='btn btn-success'>".$producto['stock']."</button>";
                        }
                        
                        $datoJson.= '[
                                "'.$i.'",
                                "'.$imagen.'",
                                "'.$producto['codigo'].'",
                                "'.$producto['descripcion'].'",
                                
                                "'.$nombre_categoria.'",
                                "'.$stock.'",
                                "$'.number_format($producto['precio_compra'], 2, ',', '.').'",
                                "$'.number_format($producto['precio_venta'], 2, ',', '.').'",
                                
                                "'.$botones.'"
                        ]';
                        if($key != count($productos)-1){
                            $datoJson.=",";
                        }
                    }
          
            $datoJson.=  ']}';

            echo $datoJson;
        }
    }

    $productos = new AjaxTablaProductos();
    $productos->mostrarTablaProductos();



  
