<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Administrar Creditos
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
           
            <li class="active">Administrar Creditos</li>
        </ol>
    </section>

    <section class="content creditos">
        <div class="box">
      
            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablas tablaCreditos" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Codigo</th>
                            <th>Cliente</th>
                    
                      
                         
                            <th>Total Compra</th>
                            <th>Deuda</th>
                            <th>Deuda I</th>
           
                       
                            <th>Boton de Acciones</th>
                        </tr>
                    </thead>
              
                </table>
            </div>
        </div>
    </section>
</div>

<div id="infoCredito" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="formulario_guardar_cliente">
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Información de La Venta a Credito</h4>
                </div>
                <div class="modal-body">
                    <ul class="info_venta list-group">

                    </ul>

                </div>
              
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Cerrar</button>
                    
                </div>
            </form>
        </div>
  </div>
</div>

<div id="modalPagarCredito" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="formulario_pagar_deuda">
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Pago</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Deuda</span>
                                
                                <input type="text" class="form-control input-lg contenido_deuda" name="nombre" id="nombre" readonly>
                                
                            </div>
                            <div class="input-group" style="margin-top:20px">
                                <div type="button" class="btn btn-default pull-right btn_maxima_deuda" >Maximo</div>
                            </div>
                           
                        </div> 
                        
                      
                   
                        <div class="form-group penultimo">
                            <div class="input-group">
                                <span class="input-group-addon">Cantidad</span>
                                <input type="number"  class="form-control input-lg contenido_pago_deuda" cantidad_pagar="" name="direccion" id="direccion" placeholder="Cantidad a pagar">
                               
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Total Pagar</span>
                                <input type="text" value = "" class="form-control input-lg contenido_pago_deuda_format" readonly>
                               
                            </div>
                        </div> 
                   
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary pull-right" id="btnPagar" >Pagar</button>
                </div>
            </form>
        </div>
  </div>
</div>