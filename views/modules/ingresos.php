<?php if(!$_SESSION['login']){?>
    <script>window.location='login'</script>
<?php }?> 
<div class="content-wrapper">
   
    <section class="content-header">
        <h1>
            Administrar Ingresos
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
           
            <li class="active">Administrar Ingresos</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#agregarIngreso">Agregar Ingreso</button>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablas tablaIngresos" style="width:100%">
                    <thead>
                        <tr>
                            <th>Responsable</th>
                            <th>Ingreso</th>
                            <th>Descripcion</th>

                            <th>Estado</th>
                    
                        </tr>
                    </thead>
              
                </table>
            </div>
        </div>
    </section>
</div>

<div id="agregarIngreso" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="formulario_guardar_ingreso">
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar Ingreso</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dollar-sign"></i></span>
                                <input type="text" class="form-control input-lg" name="ingreso" id="ingreso" placeholder="Cantidad de Ingreso">
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
                                <textarea class="form-control input-lg" rows="5" style="max-width:100%"  id="nota"   placeholder="ingrese un nota acerca del porque del ingreso max (200 caracteres) (opcional)"></textarea>
                               
                            </div>
                        </div> 
                        
                      
                   
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary pull-right" id="btnAgregarIngreso" >Agregar Ingreso</button>
                </div>
            </form>
        </div>
  </div>
</div>

<!-- editar datos del Ingreso-->
 <div id="editarIngreso" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="formulario_editar_ingreso">
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Ingreso</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-arrow-circle-up"></i></span>
                                <input type="text" class="form-control input-lg"  id="ingreso_editar" placeholder="Cantidad de Ingreso">
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
                                <textarea class="form-control input-lg" rows="5" style="max-width:100%"  id="nota_editar"   placeholder="ingrese un nota acerca del porque del ingreso"></textarea>
                               
                            </div>
                        </div> 
                        
                      
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="id_editar_ingreso"></input>
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary pull-right" id="btnEditarIngreso" >Guardar Cambios</button>
                </div>
            </form>
        </div>
  </div>
</div>

<!-- info Ingreso-->
<div id="infoIngreso" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="formulario_guardar_cliente" novalidate>
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Más Información del Ingreso</h4>
                </div>
                <div class="modal-body">
                    <ul class="info_ingreso list-group">

                    </ul>

                </div>
              
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Cerrar</button>
                    
                </div>
            </form>
        </div>
  </div>
</div>
 

 

