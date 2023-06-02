

<div class="content-wrapper cajas">
   
    <section class="content-header">
        <h1>
            Administrar Cajas
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

            <li class="active">Administrar Cajas</li>
        </ol>
    </section>

 
    <!-- tabla de usuarios -->
    
    <section class="content cajas">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#agregarCaja">Abrir Caja</button>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablasCajas" style="width:100%">
                    <thead>
                        <tr>

                            <th>#</th>
                            <th>Vendedor</th>
                            <th>efectivo inicial</th>
                            <th>Total Ventas</th>
                            <th>Credito</th>

                            <th>Efectivo total</th>
                            <th>cierre</th>
                            <th>estado</th>
                            
                        </tr>
                    </thead>
             
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Modal agregar usuario -->

<div id="agregarCaja" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" enctype="multipart/form-data" method="post" class="">
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Abrir Caja</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" id="efectivo_inicial" name="efectivo_inicial" placeholder="Efectivo Inicial de esta Caja" >
                            </div>
                        </div>
                        
                    </div>
                </div>

              
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary pull-right" id="abrirCaja">Abrir Caja</button>
                </div>
                

              

            </form>
        </div>
  </div>
</div>





<?php //echo $usuario["estado"]==1? '<button class="btn btn-success btn-xs btn-activar" idUsuario="'.$usuario['id'].'" estadoUsuario="0">Activado</button>':'<button class="btn btn-danger btn-xs btn-activar" idUsuario="'.$usuario['id'].'" estadoUsuario="1">Desactivado</button>' ?>
<!-- <div class="">
<button value="" class="btn btn-warning btnEditarUsuario"  idUsuario="<?php //echo $usuario['id']?>" data-toggle="modal" data-target="#editarUsuario"><i class="fa fa-pencil"></i></button>
<button class="btn btn-danger btnEliminarUsuario" idUsuario="<?php //echo $usuario['id']?>" fotoUsuario="<?php //echo $usuario['foto']?>"><i class="fa fa-times"></i></button>
</div> -->