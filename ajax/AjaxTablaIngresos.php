<?php

    require_once '../controllers/IngresosController.php';

    require_once '../models/Ingresos.php';
    require_once '../models/Conexion.php';

    class AjaxTablaIngresos{
        public function mostrarTablaingresos(){
            $ingresos = IngresosController::consultarIngresos();
            
           
          
        
            // $i=0;
            
            
      
            $datoJson = '{
                "data": [';
                    foreach($ingresos as $key=>$ingreso){
                       // $credito_cliente = CreditoController::creditoIndex($cliente['id']);
                      
                        // if($credito_cliente['total_deuda']>0){
                        //     $deuda_cliente = $credito_cliente['total_deuda'];
                        //     $deuda = "<div class='btn btn-warning text-bold total_deuda_cliente' >$".number_format($credito_cliente['total_deuda'])."</div>";
                        // }else{
                        //     $deuda_cliente = 0;
                        //     $deuda = "<div class='total_deuda_cliente'>$".number_format($credito_cliente['total_deuda'])."</div>";
                        // }
                       
                    
                        $estado;
                     
                        if($ingreso['estado']==0){
                           
                            $estado = "<div>";
                            $estado .= "<button class='btn btn-warning btnEditarIngreso' idIngreso='".$ingreso['id']."' style='margin-right:20px' data-toggle='modal' data-target='#editarIngreso'><i class='fa fa-pencil' ></i></button>";
                            $estado .= "<button class='btn btn-danger btnEliminarIngreso'   idIngreso='".$ingreso['id']."' style='margin-right:20px'  data-toggle='modal' data-target='#modalEliminarIngreso'><i class='fa fa-times'></i></button>";
                            $estado .= "<button class='btn btn-primary btnInfoIngreso' idIngreso='".$ingreso['id']."' data-toggle='modal' data-target='#infoIngreso'><i class='fa fa-search' ></i></button>";
                            
                            
                            $estado .= "</div>";
                            
                        }else{
                            $estado = "<div>";
                            $estado = "<div>";
                        
                            $estado .= "<button class='btn btn-secondary btn-xs' id='ingreso_cerrado'  style='font-size:20px'>Cerrado</button>";
                            $estado .= "<button class='btn btn-primary btnInfoIngreso' idIngreso='".$ingreso['id']."' style='margin-right:20px' data-toggle='modal' data-target='#infoIngreso'><i class='fa fa-search' ></i></button>";
                
                            
                            $estado .= "</div>";
                            
                        
                        }
                          
                        
                        $datoJson.= '[
                             
                                "'.$ingreso['responsable'].'",
                              

                                "'.number_format($ingreso['ingreso']).'",
                                "'.$ingreso['descripcion'].'",
                                "'.$estado.'"
                             
                        ]';
                        if($key != count($ingresos)-1){
                            $datoJson.=",";
                        }
                    }
          
            $datoJson.=  ']}';

            echo $datoJson;
        }

    }

    $ingresos = new AjaxTablaIngresos();
    $ingresos->mostrarTablaIngresos();