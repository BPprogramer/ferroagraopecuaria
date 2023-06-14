<?php '../../controllers/ClienteControl'?>
<div class="content-wrapper">
   
    <section class="content-header">
        <h1>
            Crear Venta
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
           
            <li class="active">Crear Venta</li>
        </ol>
    </section>


    <section class="content">
        <div class="row">
            <div class="col-md-5 col-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <form  method="post" class="formulario_crear" id="formulario">
                            <div class="box-body">
                                <div class="box">

                              
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span><!-- vendedor -->
                                            <div class="form-control"  style="background-color:#f9f9f9;"><?php echo $_SESSION['nombre']?></div>
                                            <input type="hidden" id="id_vendedor" name="id_vendedor" value="<?php echo $_SESSION['id']?>">
                                        </div>
                                    </div>
                                    <div class="form-group"><!-- codigo venta -->
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                            <?php 
                                                $columna = null;
                                                $valor = null;
                                                $orderById = 'id';
                                                $ventas = VentasController::consultarVentas($columna, $valor, $orderById);
                                            ?>
                                            <div class="form-control" id="codigo" name="codigo" style="background-color:#f9f9f9;"><?php echo $ventas? $ventas['codigo']+1 :'10001'?></div>
                                        </div>
                                    </div>

                               

                                    <!-- cliente -->
                             <!--        <div class="row">
                                        <div class="col-xs-12 col-sm-8 col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                                <select type="text" class="form-control clienteCrearVenta" id="id_cliente" name="id_cliente" placeholder="nombre del cliente">
                                                    <option value="anonimo" selected disabled>--Seleccione--</option>
                                        
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-4 col-md-12">
                                            <div class="input-group pull-right">
                                               
                                                    <button type="button" class="btn btn-default btn-md" data-toggle="modal" data-target="#agregarCliente" data-dismiss="modal">Agregar Cliente a la venta</button>
                                               
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="form-group row productosVenta"><!--aqui se van agregando producto -->

                                    </div>
                                    
                                    <!-- aqui se carg el arreglo con toda la iformacion osbre productos y precios -->
                                    <input type="hidden" id="listaProductos" name="productos">


                                  <!--   <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar Producto</button> -->
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                       
                                                        <th>Total Venta</th>
                                                        <th>Total Pagar</th>
                                                 
                                                     
                                                    </tr>
                                                
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td >
                                                            <div class="input-group input-group-lg">
                                                                    <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                                                    <div type="number" style="width:150px" class="form-control input-lg" min="0" id="total_venta" name="total" style="background-color:#f9f9f9;">0</div>
                                                                   
                                                            
                                                            </div>
                                                        </td>  
                                                        <td style="">
                                                            <div class="input-group input-group-lg">
                                                                    <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                                                   <input type="number" class="input-group-addon" id ="descuento" style="width:80px" placeholder="%">
                                                                
                                                                    <div type="number" style="width:150px" class="form-control input-lg" min="0" id="total_pagar" name="total" style="background-color:#f9f9f9;">0</div>
                                                                   
                                                            
                                                            </div>
                                                        </td>  
                                                     
                                                      
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                   
                                    <!-- metodos de pago-->
                                    
                                    <div class="row">
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-4" style="padding-right:20px">
                                            <div class="" ><!-- metod de pago -->
                                                <select name="metodo_pago" id="metodo_pago" class="form-control" style="font-size:15px">
                                                    <option value="" disabled>Seleccione Metodo de pago</option>
                                                    <option value="efectivo" selected>De Contado</option>
                                                    <option value="credito" >Credito</option>
                                                   <!--  <option value="Transferencia Bancaria" >Transferencia Bancaria</option>
                                                    <option value="nequi" >Nequi</option> -->
                                                    
  
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12" style="margin-top:10px">
                                            <div class="contenedor_metodo_pago row"><!-- auiinsertamos desde jquery egu nel metodo seleccionado -->
                                                
                                                <div class="col-xs-6 contenedor_valor_efectivo" style="">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                                        <input type="text"  val="" class="form-control valor_efectivo" placeholder="cantidad pagar" style="font-size:20px">
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 contenedor_cambio_efectivo" style="padding-left:0px ">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                                        <input type="text" val="" class="form-control cambio_efectivo" placeholder="cambio" readonly style="font-size:20px">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <input type="hidden" name="lista_metodo_pago" id="lista_metodo_pago"> <!-- aqui almacenamos el metodo de pago -->
                                    </div>
                                    <br>
                                </div>
                                <!-- agregar Cliente para fiados -->
                                <!-- agregar clientes a la venta -->
                                <div class="row contenedor_credito" style="margin-top:30px">
                                    <div class="col-xs-12 col-sm-8 col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                            <select type="text" class="form-control clienteCrearVenta" id="id_cliente" name="id_cliente" placeholder="nombre del cliente" style="font-size:18px">
                                                <option value="anonimo" selected disabled>--Seleccione--</option>
                                    
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="col-xs-12 col-sm-4 col-md-12">
                                        <div class="input-group pull-right">
                                            
                                                <button type="button" class="btn btn-default btn-md" data-toggle="modal" data-target="#agregarCliente" data-dismiss="modal">Agregar Cliente a la venta</button>
                                            
                                        </div>
                                    </div>
                                </div>

                                 <!-- Info Cliente -->
                                 <div class="info_cliente">
                                    <div class="form-group"style="margin-top:10px">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                                <input type="text" class="form-control input-lg" name="nombre_cliente" id="nombre_cliente" placeholder="Nombre del Cliente"  >
                                            </div>
                                    </div>
                                    <div class="form-group row" >
                                        <div class="col-xs-12 col-sm-6 mb-2" style="margin-bottom: 10px;">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-file-alt"></i></span>
                                                <input type="text" class="form-control input-lg" name="cedula_cliente" id="cedula_cliente" placeholder="Cédula" min="0" >
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 mb-2" style="margin-bottom: 10px;">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-phone"></i></span>
                                                <input type="tel" class="form-control input-lg" name="telefono_cliente" id="telefono_cliente" placeholder="Teléfono" min="0" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" >
                                        <div class="col-xs-12 col-sm-6 mb-2" style="margin-bottom: 10px;">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-map-marker-alt"></i></span>
                                                <input type="text" class="form-control input-lg" name="direccion_cliente" id="direccion_cliente" placeholder="Dirección" >
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 mb-2" style="margin-bottom: 10px;">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
                                                <input type="email" class="form-control input-lg" name="correo_cliente" id="correo_cliente" placeholder="Correo"  >
                                            </div>
                                        </div>
                                    </div>
                              
                                 </div>
                                
                            </div>
                            <div id="alerta"></div>
                            <div class="box-footer">
                                    <button type="submit" class="btn btn-primary pull-right btn_crear_venta">guardar Venta</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <div class="box-body">
                            <table class="table table-bordered table-striped dt-responsive tablas tablaProductosVentas" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Imagen</th>
                                        <th>Descripción</th>
                                       
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
    </section>

</div>
<!-- <div class="col-lg-7 col-12 hidden-md hidden-sm hidden-xs"> -->
<!-- modal agregar cliente -->

<div id="agregarCliente" class="modal fade"  role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="formulario_guardar_cliente">
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar Cliente</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" name="nombre" id="nombre" placeholder="ingresa Nombre del cliente">
                            </div>
                        </div> 
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" name="cedula" id="cedula" placeholder="ingresa No de cédula del cliente">
                            </div>
                        </div> 
                        
                      
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" class="form-control input-lg" name="telefono" id="telefono" data-inputmask="'mask':'(999) 999-9999'" data-mask placeholder="ingresa el telefono del cliente">
                            </div>
                        </div> 
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <input type="text" class="form-control input-lg" name="direccion" id="direccion" placeholder="ingresa el direccion del cliente">
                            </div>
                        </div> 
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <input type="text" class="form-control input-lg" name="correo" id="correo" placeholder="ingresa el correo del cliente">
                            </div>
                        </div> 
                   
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary pull-right" id="btnGuardarCliente" >Guardar Cliente</button>
                </div>
            </form>
        </div>
  </div>
</div>