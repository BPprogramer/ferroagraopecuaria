<?php if(!$_SESSION['login']){?>
    <script>window.location='login'</script>
<?php }?> 
<div class="content-wrapper">
   
    <section class="content-header">
        <h1>
            Administrar Egresos
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
           
            <li class="active">Administrar Egresos</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#agregarEgreso">Agregar Egreso</button>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablas tablaEgresos" style="width:100%">
                    <thead>
                        <tr>
                            <th>Responsable</th>
                            <th>Egreso</th>
                            <th>Descripcion</th>

                            <th>Estado</th>
                    
                        </tr>
                    </thead>
              
                </table>
            </div>
        </div>
    </section>
</div>

<div id="agregarEgreso" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="formulario_guardar_egreso">
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar Egreso</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dollar-sign"></i></span>
                                <input type="text" class="form-control input-lg" name="egreso" id="egreso" placeholder="Cantidad de egreso">
                            </div>
                        </div> 
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                                <input type="text" class="form-control input-lg" name="descripcion" id="descripcion" placeholder="ingresa un nombre corto descriptivo (max 20 caracteres)">
                            </div>
                        </div> 
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-sticky-note"></i></span>
                                <textarea class="form-control input-lg" rows="5" style="max-width:100%"  id="nota"   placeholder="ingrese un nota acerca del porque del egreso max (200 caracteres) (opcional)"></textarea>
                               
                            </div>
                        </div> 
                        
                      
                   
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary pull-right" id="btnAgregarEgreso" >Agregar Egreso</button>
                </div>
            </form>
        </div>
  </div>
</div>

<!-- editar datos del Ingreso-->
 <div id="editarEgreso" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="formulario_editar_egreso">
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Egreso</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-arrow-circle-up"></i></span>
                                <input type="text" class="form-control input-lg"  id="egreso_editar" placeholder="Cantidad de egreso">
                            </div>
                        </div> 
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                                <input type="text" class="form-control input-lg"  id="descripcion_editar" placeholder="ingresa un nombre corto descriptivo">
                            </div>
                        </div> 
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-sticky-note"></i></span>
                                <textarea class="form-control input-lg" rows="5" style="max-width:100%"  id="nota_editar"   placeholder="ingrese un nota acerca del porque del egreso"></textarea>
                               
                            </div>
                        </div> 
                        
                      
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="id_editar_egreso"></input>
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary pull-right" id="btnEditarEgreso" >Guardar Cambios</button>
                </div>
            </form>
        </div>
  </div>
</div>

<!-- info Ingreso-->
<div id="infoEgreso" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="" novalidate>
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Más Información del Egreso</h4>
                </div>
                <div class="modal-body">
                    <ul class="info_egreso list-group">

                    </ul>

                </div>
              
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Cerrar</button>
                    
                </div>
            </form>
        </div>
  </div>
</div>
 

 

