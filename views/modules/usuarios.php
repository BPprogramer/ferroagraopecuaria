<?php if($_SESSION['perfil']!='administrador'){?>
    <script>window.location='inicio'</script>
<?php }?> 

<div class="content-wrapper">
   
    <section class="content-header">
        <h1>
            Administrar Usuarios
            
        </h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

            <li class="active">Administrar Usuarios</li>
        </ol>
    </section>

 
    <!-- tabla de usuarios -->
    
    <section class="content usuarios">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#agregarUsuario">Registrar Usuario</button>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablas" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Foto</th>
                            <th>Perfil</th>
                            <th>Estado</th>
                            <th>Ultimo Login</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php 
                        $consultar_usuarios = new UsuarioController();
                        $usuarios =  $consultar_usuarios->mostrarUsuarios('usuarios', null, null);
                        $numero = 0;
                        
                        foreach($usuarios as $usuario){
                            $numero = $numero +1;
                            if($usuario['id']!=1){
                    ?>
                            <tr>
                                <td><?php echo $numero ?></td>
                                <td><?php echo $usuario["nombre"] ?></td>
                                <td><?php echo $usuario["usuario"] ?></td>
                                
                                <td><img src='<?php echo $usuario["foto"]!=""?$usuario["foto"]:"views/img/usuarios/default/anonymous.png"?>' class="img-thumbnail" style="width:40px"  alt="foto del usuarios"></td>
                                <td><?php echo $usuario["perfil"] ?></td>
                                <td>
                                    <?php echo $usuario["estado"]==1? '<button class="btn btn-success btn-xs btn-activar" idUsuario="'.$usuario['id'].'" estadoUsuario="0">Activado</button>':'<button class="btn btn-danger btn-xs btn-activar" idUsuario="'.$usuario['id'].'" estadoUsuario="1">Desactivado</button>' ?>
                                </td>                               
                                <td><?php echo $usuario["ultimo_login"] ?></td>                                
                                <td>
                                    <div class="">
                                        <button value="" class="btn btn-warning btnEditarUsuario"  idUsuario="<?php echo $usuario['id']?>" data-toggle="modal" data-target="#editarUsuario"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-danger btnEliminarUsuario" idUsuario="<?php echo $usuario['id']?>" fotoUsuario="<?php echo $usuario['foto']?>"><i class="fa fa-times"></i></button>
                                    </div>
                                </td>
                            </tr>
                    <?php }} ?>
                      
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
$2a$07$usesomesillystringforeMAbW133JNw7EF9W7MUUeC55x.a4uEmG
<!-- Modal agregar usuario -->

<div id="agregarUsuario" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" enctype="multipart/form-data" method="post" class="agregar_usuario">
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Registrar Usuario</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" id="nombre" name="nombre" placeholder="Nombre del Usuario EJ (Juan Perez)" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="text" class="form-control input-lg" id="usuario" name="usuario" id="nuevoUsuario" placeholder="define un Nombre de usuario EJ (Juan1996)" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control input-lg" id="password" name="password" placeholder="Pasword (numeros y letras)" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <select name="perfil" id="perfil" class="form-control input-lg" id="">
                                    <option value="" selected disabled>--seleccion--</option>
                                    <option value="administrador">Administrador</option>
                                    <option value="vendedor">Vendedor</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="panel">SUBIR IMAGEN (opcional)</div>
                            <input type="file" id="imagen" class="imagen" name="imagen">
                            <p class="help-block">Peso Máximo de la imagen de 2M</p>
                            <img src="views/img/usuarios/default/anonymous.png" class="img-thumnail previsualizar" style="width:100px" alt="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary pull-right" id="registrarUsuario">Registrar Usuario</button>
                </div>

                <?php 
                     $crearUsuario = new UsuarioController();
                     $crearUsuario->registrarUsuario();
                ?>

            </form>
        </div>
  </div>
</div>

<!-- modal Editar usuario -->

<div id="editarUsuario" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" enctype="multipart/form-data" method="post">
                <div class="modal-header" style="background-color: #3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Registrar Usuario</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" id="editNombre" name="nombreEdit" placeholder="Nombre del Usuario EJ (Juan Perez)" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="text" class="form-control input-lg" id="editUsuario" idUsuarioActual="" name="usuario" placeholder="define un Nombre de usuario EJ (Juan1996)">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control input-lg"  name="password" placeholder="Pasword Nuevo" >
                                <input type="hidden" id="passwordActual" name="passwordActual">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <select name="perfil" class="form-control input-lg" id="editPerfil">
                                   <!--  <option value="" id="editPerfil"></option> -->
                                    <option value="administrador">Administrador</option>
                                  
                                    <option value="vendedor">Vendedor</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="panel">SUBIR IMAGEN (opcional)</div>
                            <input type="file" id="imagen" class="imagen" name="imagenEdit">
                            <p class="help-block">Peso Máximo de la imagen de 2M</p>
                            <img src="views/img/usuarios/default/anonymous.png" class="img-thumnail previsualizar" style="width:100px" alt="">
                            <input type="hidden" name="fotoActual" id="fotoActual">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="idUsuarioEditar" name="idUsuarioEditar">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="submit" class="btn btn-primary pull-right" id="guardarEdicion" data-dismiss="">Guardar cambios</button>
                    
                </div>

                <?php 
                    $usuario = new UsuarioController();
                    $usuario->editarUsuario();
                 
                    
                ?>

            </form>
        </div>
  </div>
</div>
<?php 
    $usuario = new UsuarioController();
    $usuario->eliminarUsuario();
?>


