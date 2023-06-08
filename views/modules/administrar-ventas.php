<?php

?>
<div class="content-wrapper administrar_ventas">
   
    <section class="content-header">
        <h1>
            Administrar Ventas
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
           
            <li class="active">Administrar Ventas</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <a href="crear-venta">
                    <button type="button" class="btn btn-primary">Agregar Venta</button>
                </a>
                <button class="btn btn-default pull-right" id="daterange_btn">
                    <span>
                        <i class="fa fa-calendar"></i> Rango de Fecha
                    </span>
                    <i class="fa fa-caret-down"></i>
                </button>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablas" style="width:100%">
                
                    <thead>
                        <tr>
                            <th style="max-width:8px">#</th> 
                            <th style="max-width:100px"># factura</th>
                       
                            <th style="max-width:290px">vendedor</th>
                            <th style="max-width:100px">Pago</th>
                         
                            <th>Total</th>
                            <th>Deuda</th>
                          <!--   <th>Fecha de Transacción</th> -->
                            <th>Acciones</th>
                    
                        </tr>
                    </thead>
                  
                    <tbody>
                        <?php 
                  
                            // date_default_timezone_set('America/Bogota');
                            date_default_timezone_set('America/Bogota');
                            $fecha_inicial = $_GET['fi']??date('Y-m-d', strtotime('-2 days'));
                            $fecha_final = $_GET['ff']??date('Y-m-d');
                         
                            $respuesta;
                            if($fecha_final != '' && $fecha_final != ''){
                                
                                $fecha_inicial = filter_var($fecha_inicial, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}-\d{1,2}-\d{1,2}$/")));
                         
                                $fecha_final = filter_var($fecha_final, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{4}-\d{1,2}-\d{1,2}$/")));
                       

                                if (!$fecha_inicial || !$fecha_final) {
                                    $respuesta = VentasController::consultarVentas(null, null, null);
                                  } else {
                                    $respuesta = VentasController::consultarRangoVentas( $fecha_inicial, $fecha_final);
                             
                                  }
                            }else{
                        
                                $respuesta = VentasController::consultarVentas(null, null, null);
                               
                            }
                          
                            $cont = 0;  
                            foreach($respuesta as $venta){    
                             
                                $timestamp = strtotime($venta['fecha']);
                                $fecha = date('j \d\e F \d\e\l Y', $timestamp);
                                $hora = date('g:i a', $timestamp);                  
                        ?>
                            <tr>
                              <td><?php echo $cont++ ?></td> 
                                <td class="codigo"><?php echo $venta['codigo']?></td>
                        
                                <td><?php echo $venta['nombre_vendedor']?></td>
                                <td><?php echo $venta['metodo_pago']?></td>
                               
                                <td>$<?php echo number_format($venta['total'])?></td>
                                <td>$<?php echo number_format($venta['deuda'])?></td>
                               <!--  <td><?php //echo $fecha.' '.$hora?></td>   --> 
                                <td>
                                    <div class="btn-group">
                             <!--            <button class="btn btn-danger btn_imprimir_ticket" id_imprimir_ticket = "<?php //echo $venta['id'] ?>"><i class="fa-solid fa-ticket"></i></button> -->
                                        <button class="btn btn-info btn_imprimir_factura" codigo_factura="<?php echo $venta['codigo']?>"><i class="fa fa-print"></i></button>
                                        <button  class="btn btn-warning btn_editar_venta" id_venta = "<?php echo $venta['id'] ?>"><i class="fa fa-pencil"></i></button>                     
                                        <button class="btn btn-danger btn_eliminar_venta" id_venta_eliminar = "<?php echo $venta['id'] ?>"><i class="fa fa-times"></i></button>
                                        
                                    </div>
                                </td>
                            </tr>
                        <?php }?>
                      
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>


