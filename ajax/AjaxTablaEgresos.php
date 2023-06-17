<?php

    require_once '../controllers/EgresosController.php';

    require_once '../models/Egresos.php';
    require_once '../models/Conexion.php';

    class AjaxTablaEgresos{
        public function mostrarTablaEgresos(){
            $egresos = EgresosController::consultarEgresos();
            
           
          
        
            // $i=0;
            
            
      
            $datoJson = '{
                "data": [';
                    foreach($egresos as $key=>$egreso){
                       // $credito_cliente = CreditoController::creditoIndex($cliente['id']);
                      
                        // if($credito_cliente['total_deuda']>0){
                        //     $deuda_cliente = $credito_cliente['total_deuda'];
                        //     $deuda = "<div class='btn btn-warning text-bold total_deuda_cliente' >$".number_format($credito_cliente['total_deuda'])."</div>";
                        // }else{
                        //     $deuda_cliente = 0;
                        //     $deuda = "<div class='total_deuda_cliente'>$".number_format($credito_cliente['total_deuda'])."</div>";
                        // }
                       
                    
                        $estado;
                     
                        if($egreso['estado']==0){
                           
                            $estado = "<div>";
                            $estado .= "<button class='btn btn-warning btnEditarEgreso' idEgreso='".$egreso['id']."' style='margin-right:20px' data-toggle='modal' data-target='#editarEgreso'><i class='fa fa-pencil' ></i></button>";
                            $estado .= "<button class='btn btn-danger btnEliminarEgreso'   idEgreso='".$egreso['id']."' style='margin-right:20px'  data-toggle='modal' data-target='#modalEliminarEgreso'><i class='fa fa-times'></i></button>";
                            $estado .= "<button class='btn btn-primary btnInfoEgreso' idEgreso='".$egreso['id']."' data-toggle='modal' data-target='#infoEgreso'><i class='fa fa-search' ></i></button>";
                            
                            
                            $estado .= "</div>";
                            
                        }else{
                            $estado = "<div>";
                            $estado = "<div>";
                        
                            $estado .= "<button class='btn btn-secondary btn-xs' id='egreso_cerrado'  style='font-size:20px'>Cerrado</button>";
                            $estado .= "<button class='btn btn-primary btnInfoEgreso' idEgreso='".$egreso['id']."' style='margin-right:20px' data-toggle='modal' data-target='#infoEgreso'><i class='fa fa-search' ></i></button>";
                
                            
                            $estado .= "</div>";
                            
                        
                        }
                          
                        
                        $datoJson.= '[
                             
                                "'.$egreso['responsable'].'",
                              

                                "'.number_format($egreso['egreso']).'",
                                "'.$egreso['descripcion'].'",
                                "'.$estado.'"
                             
                        ]';
                        if($key != count($egresos)-1){
                            $datoJson.=",";
                        }
                    }
          
            $datoJson.=  ']}';

            echo $datoJson;
        }

    }

    $egresos = new AjaxTablaEgresos();
    $egresos->mostrarTablaEgresos();