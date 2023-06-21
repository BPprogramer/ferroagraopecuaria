<?php

    require_once '../controllers/ProductosController.php';
    require_once '../controllers/ProveedorController.php';
    require_once '../models/Productos.php';
    require_once '../models/Proveedores.php';
    // require_once "../controllers/CategoriasController.php";
    // require_once "../models/Categorias.php";

    // header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    // header("Cache-Control: post-check=0, pre-check=0", false);
    // header("Pragma: no-cache");

    class AjaxTablaStock{
        public function mostrarTablaStock(){

            $productos_all = ProductosController::consultarProductos(null, null);
            $i=0;
            
            
            // $productos_filtrado = array_filter($productos_all, function($arreglo_productos){
            //     return $arreglo_productos['stock']<=$arreglo_productos['stock_minimo'];
            // });
         
           
    
         
            // foreach($productos_filtrados as $key=>$producto){
            //     var_dump($producto['descripcion']);
            //     var_dump($key);
            //     var_dump($producto['stock']);
            //     var_dump($producto['stock_minimo']);
            //     var_dump($producto['stock_maximo']);
         
            // }
            $productos_filtrados = [];
            foreach($productos_all as $key=>$producto){
                if($producto['stock']>=$producto['stock_minimo']){
                    continue;
                }
                $productos_filtrados[] = $producto;
            }
            $datoJson = '{
                "data": [';
                    foreach($productos_filtrados as $key=>$producto){
                        $i++;
                        //$imagen = "<img class='img-thumbmail' style='width:40px' src='".$producto['imagen']."'>";
                        //$categoria = CategoriasController::consultarCategorias('id', $producto['id_categoria']);
                    
                        $proveedor = ProveedorController::consultarProveedores('id',$producto['id_proveedor']);

                      
  
                       
                        $stock = "<button class='btn btn-danger' data-toggle='modal' data-target='#editarStock' id='btn_stock' id_producto_editar_stock='".$producto['id']."'>".$producto['stock']."</button>";
                        
                        
                        $datoJson.= '[
                                "'.$i.'",
                                "'.$producto['descripcion'].'",
                              
                                "'.$producto['stock_minimo'].'",
                                "'.$producto['stock_maximo'].'",
                                "'.$stock.'",
                                "'.$proveedor['nombre'].'",
                                "'.$proveedor['telefono'].'"
                          
                                
                             
                        ]';
                        if($key != count($productos_filtrados)-1){
                            $datoJson.=",";
                        }
                    }
          
            $datoJson.=  ']}';
               
           echo $datoJson;
        }
    }

    $stock = new AjaxTablaStock();
    $stock->mostrarTablaStock();



  
