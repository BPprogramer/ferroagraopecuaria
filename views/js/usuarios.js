
//*************************subir la foto del usuario*******************

if($('.usuarios').length>0){
    let nombre = '';
    let usuario = '';
    let password = '';
    let perfil = '';
    $('#nombre').on('input',function(){
        nombre = ($(this).val()).trim();
        console.log(nombre)
      
    })
    $('#usuario').on('input',function(){
        usuario = ($(this).val()).trim();
        
    })
    $('#password').on('input',function(){
        password = ($(this).val()).trim();
        
    })
    $('#perfil').on('input',function(){
        perfil = $(this).val();
        console.log(perfil)
    })

    $('#agregarUsuario input').on('input',verficarInfo)
    $('#agregarUsuario select').change(verficarInfo)
    function verficarInfo(){
        if(nombre!='' || nombre.length>60  || usuario !='' || perfil !='' || password !='');
    }


    $('.agregar_usuario').submit(function(e){

        
    })

    $(".imagen").change(function(){
        const imagen = this.files[0];
        
        //validar que laimagen sea jpg o png
        if(imagen['type'] != "image/jpeg" && imagen['type']!= "image/png"){
            $('.imagen').val("");
            Swal.fire({
                icon:'error',
                title: "la imagen debe ser formato jpg o png",
                
                type: "error",
                confirmButtonText: "Cerrar"
            })
        }else if(imagen["size"]>2000000){
            $('.imagen').val("");
            Swal.fire({
                icon:"error",
                title:"El Máximo peso de la imagen son 2 MBytes",
                type:'error',
                confirmButtonText: "cerrar"
            
            })
        }else{

            //imprimimos la foto en el formulario
            const dataImg = new FileReader;
            dataImg.readAsDataURL(imagen);

            $(dataImg).on("load", e=>{
                const rutaImg = e.target.result;
                console.log(rutaImg)
                $('.previsualizar').attr("src", rutaImg);
            })
        }

    })


    //********************************** editar usuario con ajax *************************

    $(document).on("click",".btnEditarUsuario",function(){
    
        const idUsuario = $(this).attr("idUsuario");

        const datos = new FormData();
        datos.append("idUsuario", idUsuario);

        $.ajax({

            url:"ajax/AjaxUsuarios.php",
            method: "POST",
            data: datos,
            cache:false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
        
                $("#idUsuarioEditar").val(respuesta['id']);
                $("#editNombre").val(respuesta[1]);
                $("#editUsuario").val(respuesta['usuario']);
                $("#editUsuario").attr("idUsuarioActual",respuesta['id']);
                $("#passwordActual").val(respuesta[3]);
                $("#editPerfil > option[value="+respuesta[4]+"]").attr("selected",true);
                $("#fotoActual").val(respuesta["foto"]);

                if(respuesta['foto']!=''){
                        $('.previsualizar').attr('src', respuesta['foto']);
                }
            }

        })
    })

    /* **************************activar o descativar usuaroio */

    $(document).on('click', '.btn-activar',function(){

        const idUsuario = $(this).attr("idUsuario");
        const estadoUsuario = $(this).attr("estadoUsuario");
        let titulo;

        if(estadoUsuario==0){
            titulo='quieres deactivar este usuario?'
            
        }else{
            titulo='quieres activar este usuario?'
        }

        Swal.fire({
        
            title: titulo,
            type:'warning',
            icon:'warning',
            showCancelButton: true,
            confirmButtonColor:'#3085d6',
            cancelarButtonColor:'#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'confirmar'

        }).then((result)=>{
            if(result.isConfirmed){
                
                console.log(idUsuario)
                console.log(estadoUsuario)
                
                const datos = new FormData();
                datos.append("idUsuario",idUsuario);
                datos.append("estadoUsuario", estadoUsuario);

                $.ajax({
                url:"ajax/AjaxUsuarios.php",
                method:"POST",
                data:datos,
                cache:false,
                contentType:false,
                processData:false,
                dataType: "json",
                success:function(req){
                    let titulo;
                    if(req==1){
                        titulo = "usuario activado correctamente"
                    }else{
                        titulo = "usuario desactivado correctamente"
                    }
                    Swal.fire({
                    
                        title:titulo,
                        type:'success',
                        icon:'success',
                        showCancelButton: false,
                        confirmButtonColor:'#3085d6',
                        cancelarButtonColor:'#d33',
                    
                        confirmButtonText: 'cerrar'
                
                    }).then((result)=>{
                        if(result.value){
                            location.reload();
                        }
                    })
                }
                })
            }else{
                    location.reload()
            }
            
        })

        


    })

    /* ************evitar que un usuario se repita */

    $('#nuevoUsuario').keyup(function(){

        //borramos las alertas anteriores
    
        
        const nuevoUsuario = $(this).val();
        
    
        const datos = new FormData();
        datos.append("nuevoUsuario", nuevoUsuario);
        $.ajax({
        url:"ajax/AjaxUsuarios.php",
        method:"POST",
        data:datos,
        cache:false,
        contentType:false,
        processData:false,
        dataType: "json",
        success:function(req){
        
                if(req){
                    if(!$(".alert")[0] ){
                        $('#nuevoUsuario').addClass('text-danger')
                        $('#nuevoUsuario').parent().after('<div class="alert alert-warning">Este usuario Ya esta registrado, porfavor intente con otro</div>');
                        $(('#registrarUsuario')).attr('disabled',true)
                    }
                }else{
                    $('.alert').remove();
                    $(('#registrarUsuario')).attr('disabled',false)
                }
        }
        })
    })

    $('#editUsuario').keyup(function(){
        console.log('hola')
        const idUsuarioActual = $(this).attr('idUsuarioActual')
        const datos1 = new FormData();
        datos1.append("idUsuarioActual", idUsuarioActual);
        let usuarioActual;
        $.ajax({
            async:false,
            url:'ajax/AjaxUsuarios.php',
        
            method:"POST",
            data:datos1,
            cache:false,
            contentType:false,
            processData:false,
            dataType: "json",
            success: function(req){
            usuarioActual = req[2];
        
            }

        })
    
    
    
        const nuevoUsuario = $(this).val();
        const datos = new FormData();
        datos.append("nuevoUsuario", nuevoUsuario);
        $.ajax({
        url:"ajax/AjaxUsuarios.php",
        method:"POST",
        data:datos,
        cache:false,
        contentType:false,
        processData:false,
        dataType: "json",
        success:function(req){
            console.log(req[2])
        
                if(req && req[2]!=usuarioActual){
                    if(!$(".alert")[0] ){
                    
                        $('#editUsuario').parent().after('<div class="alert alert-warning">Este usuario Ya esta registrado, porfavor intente con otro</div>');
                        $(('#registrarUsuario')).attr('disabled',true)
                    }
                }else{
                    $('.alert').remove();
                    $(('#registrarUsuario')).attr('disabled',false)
                } 
        }
        })
    })


    /* ************eliminar usuario */

    $(document).on('click','.btnEliminarUsuario',function(){
        idUsuario = $(this).attr("idUsuario");
        fotoUsuario = $(this).attr("fotoUsuario");
        Swal.fire({
            title: 'Estas Seguro que deseas Eliminar este usuario?',
            type:'warning',
            icon:'warning',
            showCancelButton: true,
            confirmButtonColor:'#3085d6',
            cancelarButtonColor:'#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'si, Eliminar Usuario'

        }).then((result)=>{
            if(result.value){
                window.location = "index.php?ruta=usuarios&id="+idUsuario+"&path="+fotoUsuario;
            }
        })
    })
}