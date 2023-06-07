if(localStorage.getItem('rango')!=null){
    $('#daterange_btn span').html(localStorage.getItem('rango'));
   
}
if($('tablaClientes').length>0){
  
$(".tablaClientes").dataTable().fnDestroy(); //por si me da error de reinicializar

$('.tablaClientes').DataTable({
    ajax: 'ajax/ajaxTablaClientes.php',
    "deferRender":true,
    "retrieve":true,
    "proccesing":true
});

// if($('.tablaClientes').length>0){
//     $(document).ready(function(){
//        $.ajax({
//             url:"ajax/AjaxTablaClientes.php",
          
       
//             success:function(req){
//                 console.log(req)
//             },
//             error:function(error){
//                 console.log(error);
//             }
//         })
//     })
// }


/* almacenar cliente */

$('.formulario_guardar_cliente').submit(function(e){

    e.preventDefault();
    const nombre = $('#nombre').val();
    const cedula = $('#cedula').val();
    const telefono = $('#telefono').val();
    const direccion = $('#direccion').val();
    const correo = $('#correo').val();
    const arreglo = [nombre,cedula,telefono,direccion];

    if($('.alerta').length>0){
        $('.alerta').remove();
    }

    if(arreglo.some(dato=> dato=='')){
        $(this).append('<div class="alert alert-danger alerta text-center">Todos los Campos son Obligatorios</div>');
        return;
    }
    const datos = new FormData();
    datos.append('nombre', nombre);
    datos.append('cedula', cedula);
    datos.append('telefono', telefono);
    datos.append('direccion', direccion);
    datos.append('correo', correo);
  

    
    $.ajax({
        url:"ajax/AjaxClientes.php",
        method:"POST",
        data:datos,
        cache:false,
        contentType:false,
        processData:false,
        dataType:"json",
        success:function(req){
            console.log(req)
           if(req == 'correo_no_valido'){
                $('.formulario_guardar_cliente').append('<div class="alert alert-danger alerta text-center">Correo no valido</div>');
                return;
           }
            if(req=='no-validate'){
            
                $('.formulario_guardar_cliente').append('<div class="alert alert-danger alerta text-center">datos no validos</div>');
               return;
            }
            if(req=='error'){
            
                $('.formulario_guardar_cliente').append('<div class="alert alert-danger alerta text-center">hubo un error por favor intenet nuevamente</div>');
               return;
            }
            if(req=='success'){
                if($('.alerta').length>0){
                    $('.alerta').remove();
                }
                Swal.fire({
                    title: 'Cliente Almacenado Correctamente',
                    type:'success',
                    icon:'success',
                    showCancelButton: false,
                    confirmButtonColor:'#3085d6',
     
       
                    confirmButtonText: 'ACEPTAR'
            
                }).then((result)=>{
                    if(result.value){
                        window.location = "clientes";
                    }
                })
            }
            
        },
        error:function(error){
            console.log(error.responseText)
        }
    })
  
})

//traeme los datos actulaes del cliente
$(document).on('click', '.btnEditarCliente',function(){
    const id_cliente = $(this).attr('idCliente');
    const datos = new FormData();
    datos.append('id_cliente',id_cliente);
    $.ajax({
        url: "ajax/AjaxClientes.php",
        method: "POST",
        data: datos,
        cache:false,
        processData:false,
        contentType:false,
        dataType:"json",
        success:function(req){
            
            $('#editar_nombre').val(req['nombre'])
            $('#editar_cedula').val(req['cedula'])
            $('#editar_telefono').val(req['telefono'])
            $('#editar_direccion').val(req['direccion'])
            $('#editar_correo').val(req['correo'])
            $('#id_editar_cliente').val(req['id']);
        },
        error:function(error){
            console.log(error.responseText)
        }

    })

})

//enviar elformulario editar
$('.formulario_editar_cliente').submit(function(e){
    e.preventDefault();

    if($('.alert').length>0){
        $('.alert').remove();
    }
    const id_editar_cliente = $('#id_editar_cliente').val();
    const editar_nombre = $('#editar_nombre').val();
    const editar_cedula = $('#editar_cedula').val();
    const editar_telefono = $('#editar_telefono').val();
    const editar_direccion = $('#editar_direccion').val();
    const editar_correo = $('#editar_correo').val();

    const datos = new FormData();
    datos.append('id_editar_cliente',id_editar_cliente);
    datos.append('editar_nombre',editar_nombre)
    datos.append('editar_cedula',editar_cedula)

    datos.append('editar_telefono',editar_telefono)
    datos.append('editar_direccion',editar_direccion)
    datos.append('editar_correo',editar_correo)


    
    $.ajax({
        url: 'ajax/AjaxClientes.php',
        method:'POST',
        data:datos,
        cache:false,
        contentType:false,
        processData:false,
        dataType:'json',
        success:function(req){
            console.log(req)
            if(req == 'correo_no_valido'){
                $('.formulario_editar_cliente').append('<div class="alert alert-danger alerta text-center">Correo no valido</div>');
                return;
           }
            if(req=='no_validate'){
               
                $('.formulario_editar_cliente').after('<div class="alert alert-danger text-center alerta">todos los campos son obligatorios y deben ser validos</div>')
               
            }else if(req=='error'){
                $('.alerta').remove()
                Swal.fire({
                    title: 'Hubo un error, por favor intenta nuevamente',
                    type:'error',
                    icon:'error',
                    showCancelButton: false,
                    confirmButtonColor:'#3085d6',
     
       
                    confirmButtonText: 'ACEPTAR'
            
                }).then((result)=>{
                    if(result.value){
                        window.location = "clientes";
                    }
                })
            }else{
                $('.alerta').remove()
                Swal.fire({
                    title: 'Datos Actualizados Correctamente',
                    type:'success',
                    icon:'success',
                    showCancelButton: false,
                    confirmButtonColor:'#3085d6',
     
       
                    confirmButtonText: 'ACEPTAR'
            
                }).then((result)=>{
                    if(result.value){
                        window.location = "clientes";
                    }
                })
            }
        },
        error:function(error){
            console.log(error.responseText)
        }

    })
})

//eliminar CLiente

$(document).on('click', '.btnEliminarCliente', function(){
    
    const deuda_total = $(this).attr('deuda_cl')
    if(deuda_total!=0){
        console.log(deuda_total)
        Swal.fire({
        icon:'error',
        title: 'El cliente no se puede Eliminar Saldo Pendiente',
        text: 'Saldo Pendiente',
    })}else{

  

   
   
    Swal.fire({
        title:'Esta Seguro que Desea Eliminar este Cliente?',
        text: 'esta accion no se puede deshacer',
        head: 'esta acción no tiene',
        icon: 'warning',
        type: 'warning',
        showCancelButton:true,
        cancelButtonText:'Cancelar',
        confirmButtonText: 'si, eliminar Cliente'
    }).then((result)=>{
        if(result.value){
            const id_eliminar_cliente = $(this).attr('idCliente');
            const datos = new FormData();
            datos.append('id_eliminar_cliente', id_eliminar_cliente);
            $.ajax({
                url: 'ajax/AjaxClientes.php',
                method:'POST',
                data:datos,
                cache:false,
                contentType:false,
                processData:false,
                dataType:'json',
                success:function(req){
                    
                    if(req=='error'){
                        Swal.fire({
                            icon:'error',
                            title: 'Opps, hubo un error',
                            text: 'porfavor intenta nuevamente',
                        })
                      
                    }
                    if(req=='no_permitido'){
                        Swal.fire({
                            icon:'error',
                            title: 'El cliente no se puede Eliminar Saldo Pendiente',
                            text: 'Saldo Pendiente',
                        })
                      
                    }
                    if(req=='success'){
                        Swal.fire({
                            title: 'Cliente Eliminado Correctamente',
                            type:'success',
                            icon:'success',
                            showCancelButton: false,
                            confirmButtonColor:'#3085d6',
             
               
                            confirmButtonText: 'ACEPTAR'
                    
                        }).then((result)=>{
                            if(result.value){
                                window.location = "clientes";
                            }
                        })
                    }
                },
                error:function(error){
                    console.log(error.responseText)
                }

            })
        }
    })
}
})

}
