<?php if($_SESSION['perfil']=='vendedor'){?>
    <script>window.location='inicio'</script>
<?php }?> 
<div class="content-wrapper">
   
    <section class="content-header">
        <h1>
            Administrar Productos
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

            <li class="active">Administrar Productos</li>
        </ol>
    </section>

 
    <!-- tabla de usuarios -->
    
    <section class="content" id="productosPage">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" id="btnAgregarProducto" data-toggle="modal" data-target="#agregarProducto">Agregar Producto</button>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablaProductos" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Imagen</th>
                            <th>Codigo</th>
                            <th>Descripcion</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Precio de Compra</th>
                            <th>Precio de Venta</th>
                         
                            <th>Acciones</th>
                        </tr>
                    </thead>
            
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Modal agregar Producto -->

<div id="agregarProducto" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form_agregar_producto" enctype="multipart/form-data" method="post" novalidate>
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar Producto</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select name="id_categoria" class="form-control input-lg" id="idCategoria">
                                    <option value="" selected disabled>--seleccione la categoria--</option>
                                    <?php $categorias = CategoriasController::consultarCategorias(null, null)?>
                                    <?php foreach($categorias as $categoria){ ?>
                                        <option value="<?php echo $categoria['id']?>"><?php echo $categoria['nombre']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <input type="text" class="form-control input-lg" name="codigo" id="codigo" placeholder="Codigo del Producto" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                                <input type="text" class="form-control input-lg" name="descripcion" id="descripcion" placeholder="Ingresar descripcion Producto" >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select name="id_proveedor" class="form-control input-lg selectProveedores" id="idProveedor">
                                    
                                   
                                </select>
                            </div>
                        </div>
                       
                    
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                <input type="number" class="form-control input-lg" name="stock" id="stock" placeholder="cantidad de productos en el stock" min="0" >
                            </div>
                        </div>
                        <!-- stock minimo y maximo -->
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 mb-2" style="margin-bottom: 10px;">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-caret-down"></i></span>
                                    <input type="number" class="form-control input-lg" name="stock_minimo" id="stock_minimo" placeholder="stock mínimo" min="0" >
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 mb-2" style="margin-bottom: 10px;">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-caret-up"></i></span>
                                    <input type="number" class="form-control input-lg" name="stock_maximo" id="stock_maximo" placeholder="stock máximo" min="0" >
                                </div>
                            </div>
                        </div>
                       
                        <!-- PRecio de compar y venta -->
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 mb-2" style="margin-bottom: 10px;">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                                    <input type="number"  step="any" class="form-control input-lg" name="precio_compra" id="precio_compra" precio_compra="" placeholder="Precio de Compra" min="0" >
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                                    <input type="number"  step="any" class="form-control input-lg" name="precio_venta" id="precio_venta" precio_venta="" placeholder="Precio de venta" >
                                </div>
                                <br>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="">
                                            <input type="checkbox" class="minimal porcentaje" id="check_porcentaje" checked >
                                            Utilizar Porcentaje
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0;">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-lg porcentaje_input" min="0" value="40" required>
                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="form-group form_group_imagen">
                            <div class="panel">SUBIR IMAGEN (opcional)</div>
                            <input type="file" id="imagen" name="imagen" class="imagen">
                            <p class="help-block">Peso Máximo de la imagen de 200M</p>
                            <img src="views/img/usuarios/default/anonymous.png" class="img-thumnail ver_imagen" id="" style="width:100px" alt="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary pull-right btnRegistrar" >Registrar Producto</button>
                </div>
                <?php
                    
                ?>
            </form>
        </div>
  </div>
</div>
<!-- info producto -->
<div id="infoProducto" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="formulario_guardar_cliente" novalidate>
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Información del Producto</h4>
                </div>
                <div class="modal-body">
                    <ul class="info_producto list-group">

                    </ul>

                </div>
              
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Cerrar</button>
                    
                </div>
            </form>
        </div>
  </div>
</div>

<!-- modal editar productp -->
<div id="editarProducto" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form_editar_producto" enctype="multipart/form-data" method="post" novalidate>
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Producto</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                    <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select name="categoria_editar" id="categoria_editar" class="form-control input-lg" >
                              
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <input type="text" class="form-control input-lg" name="editar_codigo" id="editar_codigo" placeholder="Codigo del Producto" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                                <input type="text" class="form-control input-lg" name="editar_descripcion" id="editar_descripcion" placeholder="Ingresar descripcion Producto" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select name="id_proveedor" class="form-control input-lg selectProveedores" id="editar_id_proveedor">
                                    <option value="" disabled>--seleccione el proveedor--</option>
                                </select>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                <input type="number" class="form-control input-lg" name="editar_stock" id="editar_stock" placeholder="cantidad de productos en el stock" min="0" >
                            </div>
                        </div>

                        <!-- stock minimo y maximo -->
                        <div class="form-group row">
                                <div class="col-xs-12 col-sm-6 mb-2" style="margin-bottom: 10px;">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-caret-down"></i></span>
                                        <input type="number" class="form-control input-lg" name="editar_stock_minimo" id="editar_stock_minimo" placeholder="stock mínimo" min="0" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 mb-2" style="margin-bottom: 10px;">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-caret-up"></i></span>
                                        <input type="number" class="form-control input-lg" name="editar_stock_maximo" id="editar_stock_maximo" placeholder="stock máximo" min="0" >
                                    </div>
                                </div>
                        </div>

                        <!-- precios de compra venta y porcentaje -->
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6 mb-2" style="margin-bottom: 10px;">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                                    <input type="number"  step="any" class="form-control input-lg" name="editar_precio_compra" id="editar_precio_compra" placeholder="Precio de Compra" min="0" >
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                                    <input type="number"  step="any" class="form-control input-lg" name="editar_precio_venta" id="editar_precio_venta" placeholder="Precio de venta">
                                </div>
                                <br>
                             <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="">
                                            <input type="checkbox" class="minimal editar_porcentaje" id="check_porcentaje_editar" checked >
                                            Utilizar Porcentaje
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0;">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-lg editar_porcentaje_input" min="0" value="40" required>
                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="form-group form_group_imagen_editar">
                            <div class="panel">SUBIR IMAGEN (opcional)</div>
                            <input type="file" id="editar_imagen" name="editar_imagen" class="editar_imagen">
                            <p class="help-block">Peso Máximo de la imagen de 200M</p>
                            <img src="views/img/usuarios/default/anonymous.png" class="img-thumnail ver_imagen_editar" id="" style="width:100px" alt="">
                            <input type="hidden" id="imagen_actual">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="id_producto">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="">Close</button>
                    <button type="submit" class="btn btn-primary pull-right btnEditarSubmit" >guardar Cambios</button>
                </div>
                <?php
                    
                ?>
            </form>
        </div>
  </div>
</div>