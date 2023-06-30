<?php

 
    require_once '../controllers/CreditoController.php';
    require_once '../models/Credito.php';
    require_once '../models/Conexion.php';

    class AjaxTablaCreditos{
        public function mostrarTablaCreditos(){
          
        
            $creditos = CreditoController::consultarCreditos();

            
            
            $i=0;
            
            
      
            $datoJson = '{
                "data": [';
                    foreach($creditos as $key=>$credito){
                        date_default_timezone_set('America/Bogota');
                        $fecha_ultimo_pago = $credito['ultimo_pago'];
                        $fecha_actual = date('Y-m-d H:i:s');

                        

                        $diferencia = strtotime($fecha_actual) - strtotime($fecha_ultimo_pago);
                        $diferencia_dias = floor($diferencia / (60 * 60 * 24));

                        $deuda_i = $credito['deuda']+($credito['deuda']*$diferencia_dias)*($credito['interes']/3000);
                        $deuda_i = round($deuda_i, -2);
                        $modulo = $deuda_i%100;

                        if( $modulo>=50){
                            $deuda_i +=100;
                        }
                   

                        if($credito['deuda']>0){
                            $deuda = "<div class='btn btn-warning text-bold'>$".number_format($credito['deuda'])."</div>";
                            $btn_deuda_i = "<div class='btn btn-warning text-bold'>$".number_format($deuda_i)."</div>";
                        }else{
                            $deuda = "<div'>$".number_format($credito['deuda'])."</div>";
                        }
                       
                        $i++;
                       
                    
                        $botones = "<div>";
                        $botones .= "<button class='btn btn-primary btnInfoCredito' codigoVenta='".$credito['codigo_venta']."' style='margin-right:20px' data-toggle='modal' data-target='#infoCredito'><i class='fa fa-search' ></i></button>";
                        $botones .= "<button class='btn btn-danger btnPagarCredito' deuda='".$deuda_i."' idCredito='".$credito['id']."'   data-toggle='modal' data-target='#modalPagarCredito'><i class='fa fa-credit-card'  </i></button>";
                        $botones .= "</div>";
                        
                        
                        $datoJson.= '[
                                "'.$i.'",
                                "'.$credito['codigo_venta'].'",
                                "'.$credito['nombre_cliente'].'",
                              
                                "'.$credito['total'].'",

                                "'.$deuda.'",
                                "'.$btn_deuda_i.'",
                              
                        
                             
                                "'.$botones.'"
                        ]';
                        if($key != count($creditos)-1){
                            $datoJson.=",";
                        }
                    }
          
            $datoJson.=  ']}';

            echo $datoJson;
        }

    }

    $cliente = new AjaxTablaCreditos();
    $cliente->mostrarTablaCreditos();