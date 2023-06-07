<?php if($_SESSION['perfil']!='administrador'){?>
    <script>window.location='inicio'</script>
<?php }?> 
<div class="content-wrapper">
   
    <section class="content-header">
        <h1>
            Administrar Clientes
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
           
            <li class="active">Administrar Clientes</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
           <!--  <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#agregarCliente">Agregar Cliente</button>
            </div> -->
            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablas tablaComprasPendientes" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Stock Mínimo</th>
                            <th>Stock Máximo</th>
                            <th>Stock Actual</th>
                            <th>Proveedor</th>
                            <th>Tel Proveedor</th>
                          
                          
                        </tr>
                    </thead>
              
                </table>
            </div>
        </div>
    </section>
</div>



<!-- editar datos del cliente -->
<div id="editarStock" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="formulario_editar_stock">
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Insertar Nuevo Stock</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="number" class="form-control input-lg" name="editar_stock" id="editar_stock" placeholder="ingresa el stock adquirido">
                            </div>
                        </div> 
                   

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="id_editar_stock"></input>
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary pull-right" id="btnEditarStock" >Guardar Cambios</button>
                </div>
            </form>
        </div>
  </div>
</div>
   

 

