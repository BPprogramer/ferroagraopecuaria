<?php

    require_once '../controllers/ProductosController.php';
    require_once '../models/Productos.php';




    class AjaxTablaProductosVentas{
        public function mostrarTablaProductosVentas(){

            $productos = ProductosController::consultarProductos(null, null);
            $i=0;
            
            
      
            $datoJson = '{
                "data": [';
                    foreach($productos as $key=>$producto){
                        $i++;
                        $imagen = "<img class='img-thumbmail' style='width:40px' src='".$producto['imagen']."'>";
                       
                        if($producto['stock']<$producto['stock_minimo']){
                            $stock = "<button class='btn btn-danger'>".$producto['stock']."</button>";
                        }else if($producto['stock']>$producto['stock_maximo']){
                            $stock = "<button class='btn btn-warning'>".$producto['stock']."</button>";
                        }else{
                            $stock = "<button class='btn btn-success'>".$producto['stock']."</button>";
                        }
                        
                      
                 
                    
                        $precio = "<button style='font-size:2rem' class='btn'>$".number_format($producto['precio_venta'])."</button>";
                    
                
                      
                        $botones = "<div class='btn-group'> ";
                        $botones .= "<button class='btn btn-primary agregarProducto recuperarBoton'  idProducto='".$producto['id']."'>Agregar</button>";
                        $botones .= "</div>";
                        $datoJson.= '[
                            
                                "'.$producto['descripcion'].'",
                                "'.$precio.'",
                                "'.$stock.'",
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

    $productos = new AjaxTablaProductosVentas();
    $productos->mostrarTablaProductosVentas();



  
