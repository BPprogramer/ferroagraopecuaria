<?php 

    require_once '../controllers/CajasController.php';
    require_once '../models/Caja.php';
    require_once '../models/Conexion.php';
    class AjaxTablaCajas{
        public function mostrarCajas(){
            
             $cajas = CajasController::consultarCajas();
           
        
            $i=0;
            
            
      
            $datoJson = '{
                "data": [';
                    foreach($cajas as $key=>$caja){
                      $i++;
                        $estado = $caja['estado'];
                        if($estado=='0'){
                          
                            $btn_estado =  "<div>";
                            $btn_estado .= "<button class='btn btn-success btn-xs' id='cerrar_caja' idCaja='".$caja['id']."' style='font-size:20px'>Abierta</button>";
                            $btn_estado .=  "</div>";
                        }else{
                            $btn_estado =  "<div>";
                            $btn_estado .= "<button class='btn btn-secondary btn-xs' id='caja_cerrada'  style='font-size:20px'>Cerrada</button>";
                            $btn_estado .=  "</div>";
                            
                        }
                        $timestamp_apertura = strtotime($caja['fecha_apertura']);
                        $fecha_apertura = date('j \d\e F \d\e\l Y', $timestamp_apertura);
                        $hora_apertura = date('g:i a', $timestamp_apertura); 
                        $fecha_apertura_format = $fecha_apertura.' '.$hora_apertura;
                        $timestamp_cierre = strtotime($caja['fecha_cierre']);
                        $fecha_cierre = date('j \d\e F \d\e\l Y', $timestamp_cierre);
                        $hora_cierre = date('g:i a', $timestamp_cierre); 
                        $fecha_cierre_format = $fecha_cierre.' '.$hora_cierre;

                       
                       
                    
    
                        
                    
                        $datoJson.= '[
                                "'.$i.'",
                                "'.$caja['vendedor'].'",
                                "$'.number_format($caja['efectivo_apertura']).'",
                                "$'.number_format($caja['efectivo_ventas']).'",
                                "$'.number_format($caja['creditos']).'",
                                "$'.number_format($caja['efectivo_cierre']).'",
                                "'.$fecha_apertura_format.'",
                              
                                "'.$btn_estado.'"
                                
                              
                        ]';
                        if($key != count($cajas)-1){
                            $datoJson.=",";
                        }
                    }
          
            $datoJson.=  ']}';

            echo $datoJson;
        }
    }

    $cajas = new AjaxTablaCajas();
    $cajas->mostrarCajas();