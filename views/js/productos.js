
if($('.tablaProductos').length>0){
 $(".tablaProductos").dataTable().fnDestroy(); //por si me da error de reinicializar

$('.tablaProductos').DataTable({
    ajax: 'ajax/AjaxTablaProductos.php',
    "deferRender":true,
    "retrieve":true,
    "proccesing":true
});



//mostrar informacion del producto

$(document).on('click','.btnInfoProducto',function(){
    const id_producto = $(this).attr('idProducto');
    
    const datos = new FormData();
    datos.append('id', id_producto);
    $.ajax({
        url: "ajax/AjaxProductos.php",
        method: "POST",
        data: datos,
        cache:false,
        processData:false,
        contentType:false,
        dataType:"json",
        success:function(req){
          
            mostrarInfoProducto(req);
        },
        error:function(error){
        
            console.log(error.responseText)
        }
    })

})
function mostrarInfoProducto(info_producto){
   

    $('.info_producto').empty()
    const {codigo, descripcion, id, id_categoria, id_proveedor, imagen,precio_compra,precio_venta,stock,stock_minimo,stock_maximo,ventas} = info_producto;
    const precio_compra_producto = precio_compra.toLocaleString('en-US', {style: 'currency', currency: 'USD'})
    const precio_venta_producto = precio_venta.toLocaleString('en-US', {style: 'currency', currency: 'USD'})
    const datos = new FormData();

    datos.append('id_proveedor',id_proveedor);
    $.ajax({
        url:"ajax/AjaxProveedores.php",
        method:"POST",
        data:datos,
        cache:false,
        contentType:false,
        processData:false,
        dataType:"json",
        success:function(req){
           
            // console.log(req)
            $('.info_producto').append(`
                <li class="list-group-item text-lg" style="font-size:20px">Producto : <strong>${descripcion}</strong></li>
                <li class="list-group-item text-lg" style="font-size:20px">Proveedor: <strong>${req['nombre']}</strong></li>
                <li class="list-group-item text-lg" style="font-size:20px">telefono del proveedor: <strong>${req['telefono']}</strong></li>
             
                
                <li class="list-group-item text-lg" style="font-size:20px">Precio de compra: <strong>${precio_compra_producto}</strong></li>
                <li class="list-group-item text-lg" style="font-size:20px">precio de venta: <strong>${precio_venta_producto}</strong></li>
                <li class="list-group-item text-lg" style="font-size:20px">Stock Actual: <strong>${stock}</strong></li>
                <li class="list-group-item text-lg" style="font-size:20px">Stock mínimo: <strong>${stock_minimo}</strong></li>
                <li class="list-group-item text-lg" style="font-size:20px">Stock máximo: <strong>${stock_maximo}</strong></li> 
                
            `)
        },
        error:function(error){
            console.log(error.responseText)
        }

    })


  
    
   
 
    

}



$('#btnAgregarProducto').click(function(){
     $.ajax({
        url: "ajax/AjaxProveedores.php",
        dataType:"json",
        success:function(req){
            
            $('.selectProveedores').append(`<option value="" selected disabled>--seleccione el proveedor--</option>`)
            req.forEach(proveedor => {
                $('.selectProveedores').append(`<option value="${proveedor['id']}">${proveedor['nombre']}</option>`)
            });
        },
        error:function(error){
            console.log(error.responseText)
        }
     })
})


  


    //<option value="<?php echo $categoria['id']?>"><?php echo $categoria['nombre']?></option>


   


//calcular el precio del producto 

$('#precio_compra').keyup(calcularPrecioCompra)

$('.porcentaje_input').change(calcularPrecioCompra)
$('.porcentaje_input').keyup(calcularPrecioCompra)
//$('#check_porcentaje').change(calcularPrecioCompra)
$('#check_porcentaje').on('ifChanged',calcularPrecioCompra) //plugin icheck


//calcular porcentaje de la venta al crear la venta

$('#precio_venta').keyup(calcularPorcentaje);
$('#precio_venta').change(calcularPorcentaje);

function calcularPorcentaje(){
    const precio_compra = $('#precio_compra').val()
    const precio_venta =  $('#precio_venta').val();
    const porcentaje = (precio_venta*100/precio_compra) - 100;
    
    $('.porcentaje_input').val(porcentaje)
}
//calcular porcentaje de la venta al crear la venta

$('#editar_precio_venta').keyup(calcularPorcentajeEditar);
$('#editar_precio_venta').change(calcularPorcentajeEditar);

function calcularPorcentajeEditar(){
    const precio_compra = $('#editar_precio_compra').val()
    const precio_venta =  $('#editar_precio_venta').val();
    const porcentaje = (precio_venta*100/precio_compra) - 100;
  
    $('.editar_porcentaje_input').val(porcentaje)
}



function calcularPrecioCompra(){
 
  
        if($(".porcentaje").prop('checked')){
           
            const porcentaje = parseFloat($('.porcentaje_input').val());
            const precio_compra = parseFloat($('#precio_compra').val());
            const precio_venta =precio_compra + precio_compra*porcentaje/100;
           // console.log(precio_venta)
           
            //$('#precio_venta').val(precio_venta)
       
            const numero = precio_venta;
            const redondeado = Math.round(numero / 100) *100;
            $('#precio_venta').val(redondeado)
      
            //$('#precio_venta').attr("readonly", true)
        }else{
            const precio_compra = parseFloat($('#precio_compra').val());
            $('#precio_venta').val(precio_compra)
            //$('#precio_venta').attr("readonly", false)
        }
    
 
}


//calculo del codigo 
$('#idCategoria').change(function(){
    const idCategoria = $(this).val();
 
    const datos = new FormData();
    datos.append('id_categoria', idCategoria);

    $.ajax({
        url:"ajax/AjaxProductos.php",
        method:"POST",
        data:datos,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(req){
            let nuevoCodigo;
            if(!req){
                 nuevoCodigo = idCategoria+"01";
            }else{
                const ultimoCodigo = Number(req['codigo']);
                
                 nuevoCodigo = ultimoCodigo+1;
            }
            
           
            $('#codigo').val(nuevoCodigo)
            $('#codigo').attr('readonly',true);

         
        },
        error:function(error){
           console.log(error.responseText)
        }
    
    })
})








$('.form_agregar_producto').submit(function(e){
   e.preventDefault();
   if($('.alerta').length>0){
        $('.alerta').remove();
    }

    const idCategoria = $('#idCategoria').val();
    const idProveedor = $('#idProveedor').val();

    const codigo = $('#codigo').val();
    const descripcion = $('#descripcion').val();
    const stock = $('#stock').val();

    const stock_minimo = $('#stock_minimo').val();
    const stock_maximo = $('#stock_maximo').val();
  

    const precio_compra = $('#precio_compra').val();
    const precio_venta = $('#precio_venta').val();
    

    const imagen = $('#imagen').prop('files')[0];

    const datos = new FormData();
    const datos_producto = true;
    datos.append('idCategoria',idCategoria)
    datos.append('idProveedor',idProveedor)
    datos.append('codigo',codigo)
    datos.append('descripcion',descripcion)
    datos.append('stock',stock)
    datos.append('stock_minimo',stock_minimo)
    datos.append('stock_maximo',stock_maximo)
    datos.append('precio_compra',precio_compra)
    datos.append('precio_venta',precio_venta)
    datos.append('imagen',imagen)
  
    datos.append('datos_producto',datos_producto)
 
    $.ajax({
        url:"ajax/AjaxProductos.php",
        method:"POST",
        data:datos,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "json",
        success:function(req){
            console.log(req)
            if(req==['imagen no compatible']){
                $('.form_group_imagen').after('<div class="alert alert-danger text-center alerta">Imagen no Compatible</div>');
                return;
            }
            if(req=='datos_invalidos'){
                if(!$('.alerta').length>0){
                    $('.form_group_imagen').after('<div class="alert alert-danger text-center alerta">todos los campos son obligatorios y deben ser validos</div>')
                }
                return;
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
                        window.location = "productos";
                    }
                })
            }else{
                $('.alerta').remove()
                Swal.fire({
                    title: 'Producto Almacenado Correctamente',
                    type:'success',
                    icon:'success',
                    showCancelButton: false,
                    confirmButtonColor:'#3085d6',
     
       
                    confirmButtonText: 'ACEPTAR'
            
                }).then((result)=>{
                    if(result.value){
                        window.location = "productos";
                    }
                })
            }

         
        },
        error:function(error){
           console.log(error.responseText)
        }
    
    })
  
})


/* subitr imagen del producto */
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
         
            $('.ver_imagen').attr("src", rutaImg);
        })
    }

});

$('#editar_precio_compra').keyup(calcularPrecioVentaEditar)

$('.editar_porcentaje_input').change(calcularPrecioVentaEditar)
$('.editar_porcentaje_input').keyup(calcularPrecioVentaEditar)
//$('#check_porcentaje').change(calcularPrecioVenta)


$('#check_porcentaje_editar').on('ifChanged',calcularPrecioVentaEditar) //plugin icheck


function calcularPrecioVentaEditar(){

  
        if($("#check_porcentaje_editar").prop('checked')){
           
            const porcentaje = parseFloat($('.editar_porcentaje_input').val());

            const precio_compra = parseFloat($('#editar_precio_compra').val());
            const precio_venta =precio_compra + precio_compra*porcentaje/100;
       
            const numero = precio_venta;

            const redondeado = Math.round(numero / 100) *100;
          
           
            $('#editar_precio_venta').val(redondeado)
            //$('#editar_precio_venta').attr("readonly", true)
        }else{
            const precio_compra = parseFloat($('#editar_precio_compra').val());
            $('#editar_precio_venta').val(precio_compra)
           // $('#editar_precio_venta').attr("readonly", false)
        }
    
 
}


/* traerme los datos a editar*/
$(document).on('click', '.btnEditarProducto',function(){
   
    const id = $(this).attr('idProducto');
    const datos = new FormData();
    datos.append('id', id);
    $.ajax({
        url: 'ajax/AjaxProductos.php',
        method: 'POST',
        data: datos,
        cache: false,
        processData:false,
        contentType:false,
        processData:false,
        dataType:'json',
        success:function(req){
            const precio_compra = req['precio_compra']
            const precio_venta = req['precio_venta']
            const porcentaje = (precio_venta*100/precio_compra) - 100;
            $('.editar_porcentaje_input').val(porcentaje)
            $('#id_producto').val(req['id']);
            $('#editar_codigo').val(req['codigo'])
            $('#editar_codigo').attr('readonly', true)
            $('#editar_descripcion').val(req['descripcion'])
            $('#editar_stock').val(req['stock'])
            $('#editar_stock_minimo').val(req['stock_minimo'])
            $('#editar_stock_maximo').val(req['stock_maximo'])
            $('#editar_precio_compra').val(req['precio_compra'])
            $('#editar_precio_venta').val(req['precio_venta'])
            $('#imagen_actual').val(req['imagen'])
            $('.ver_imagen_editar').attr('src', req['imagen']);

           
            const id_categoria = req['id_categoria'];
            const id_proveedor = req['id_proveedor'];
            const datosCategoria = new FormData();
            datosCategoria.append('id_categoria_consulta', id_categoria);

               $.ajax({
                    url: "ajax/AjaxProveedores.php",
                    dataType:"json",
                    success:function(req){
                        req.forEach(proveedor => {
                            let proveedorActual= ''
                            
                            if(proveedor['id']==id_proveedor){
                                proveedorActual = 'selected';
                            }
                            $('.selectProveedores').append(`<option ${proveedorActual} value="${proveedor['id']}">${proveedor['nombre']}</option>`)
                        });
                    },
                    error:function(error){
                        console.log(error.responseText)
                    }
                })

            $.ajax({
                url: 'ajax/AjaxProductos.php',
                method: 'POST',
                data: datosCategoria,
                cache: false,
                processData:false,
                contentType:false,
                processData:false,
                dataType:'json',
                success:function(req){
            
                    if($('.option_codigo').length>0){
                        $('.option_codigo').remove()
                    }
                    $('#categoria_editar').append($('<option class="option_codigo"></option>').attr({'readonly': true, 'value':id_categoria}).text(req['nombre']))
                  
                  
                 
                }
            })
        }
      

    })
})





//envio del formulario editar

$('.form_editar_producto').submit(function(e){
    if($('.alerta').length>0){
        $('.alerta').remove()
     }

    e.preventDefault();
     const datosProducto = [ $('#editar_descripcion').val(),$('#editar_stock').val(),$('#editar_precio_compra').val(),$('#editar_precio_venta').val()]
     if(datosProducto.some(dato=>dato=='')){
         
         $('.form_group_imagen_editar').after('<div class="alert alert-danger text-center alerta">Todos los Campos Son Obligatorios excepto la imagen</div>')
         return;
     }
   
     const id_producto = $('#id_producto').val();
     const editar_id_proveedor = $('#editar_id_proveedor').val();
    
   

     const editar_descripcion = $('#editar_descripcion').val();
     const editar_stock = $('#editar_stock').val();
     const editar_stock_minimo = $('#editar_stock_minimo').val();
     const editar_stock_maximo = $('#editar_stock_maximo').val();

     const editar_precio_compra = $('#editar_precio_compra').val();
     const editar_precio_venta = $('#editar_precio_venta').val();
 
     const editar_imagen = $('#editar_imagen').prop('files')[0];
 
     const datos = new FormData();


     datos.append('id_producto',id_producto);
     datos.append('editar_id_proveedor',editar_id_proveedor);
     datos.append('editar_descripcion',editar_descripcion)
     datos.append('editar_imagen', editar_imagen);
     datos.append('editar_stock',editar_stock)
     datos.append('editar_stock_minimo',editar_stock_minimo)
     datos.append('editar_stock_maximo',editar_stock_maximo)
     datos.append('editar_precio_compra',editar_precio_compra)
     datos.append('editar_precio_venta',editar_precio_venta)
     //datos.append('imagen',imagen)
   
     
  
     $.ajax({
         url:"ajax/AjaxProductos.php",
         method:"POST",
         data:datos,
         cache:false,
         contentType: false,
         processData: false,
         dataType: "json",
         success:function(req){
            console.log(req)
            if(req==['imagen no compatible']){
                $('.form_group_imagen_editar').after('<div class="alert alert-danger text-center alerta">Imagen no Compatible</div>');
                return;
            }
         
            if(req=='id_invalido'){
                window.location='productos'
            }
            if(req=='datos_no_validos'){
                if($('.alerta').length>0){
                    $('.alerta').remove()
                 }
                 $('.form_group_imagen_editar').after('<div class="alert alert-danger text-center alerta">No se Permiten caracteres especiales</div>')
                 return;
            }
            if(req=='success'){
                if( $('.alerta').length>0){
                    $('.alerta').remove()
                }
                Swal.fire({
                    title: 'Producto Editado Correctamente',
                    type:'success',
                    icon:'success',
                    showCancelButton: false,
                    confirmButtonColor:'#3085d6',
     
       
                    confirmButtonText: 'ACEPTAR'
            
                }).then((result)=>{
                    if(result.value){
                        window.location = "productos";
                    }
                })
            }
          
         
 
          
         },
         error:function(error){
            console.log(error.responseText)
         }
     
     })
   
 })

 /* editar imagen */

$("#editar_imagen").change(function(){

  
    const imagen = this.files[0];
    
    if($('.alerta').length>0){
        $('.alerta').remove();
    }
    
    //validar que laimagen sea jpg o png
   // console.log(imagen['type'])
    console.log(imagen['size'])
    if(imagen['type'] != "image/jpeg" && imagen['type']!= "image/png"){
     

        
        $('.form_group_imagen_editar').after('<div class="alert alert-danger text-center alerta">solo formato jpg y png</div>')
    }else if(imagen["size"]>2000000){
       
        $('.form_group_imagen_editar').after('<div class="alert alert-danger text-center alerta">el peso debe ser menor a 2Megas</div>')
    }else{

        //imprimimos la foto en el formulario
        const dataImg = new FileReader;
        dataImg.readAsDataURL(imagen);

        $(dataImg).on("load", e=>{
            const rutaImg = e.target.result;
         
            $('.ver_imagen_editar').attr("src", rutaImg);
        })
    }

});


/* Eliminar el producto */

$(document).on('click', '.btnEliminarProducto',function(){
    if($('.alerta').length>0){
        $('.alerta').remove();
    }
    const id_eliminar = $(this).attr('idProducto');

    Swal.fire({
        title:'Esta Seguro que Desea Eliminar este Producto?',
        text: 'esta accion no se puede deshacer',
        head: 'esta acción no tiene',
        icon: 'warning',
        type: 'warning',
        showCancelButton:true,
        cancelButtonText:'Cancelar',
        confirmButtonText: 'si, eliminar Producto'
    }).then((result)=>{
        if(result.value){
            
            const datos = new FormData();
            datos.append('id_eliminar', id_eliminar);
            $.ajax({
                url: 'ajax/AjaxProductos.php',
                method:'POST',
                data:datos,
                cache:false,
                contentType:false,
                processData:false,
                dataType:'json',
                success:function(req){
                    console.log(req)
                    if(req=='error'){
                        Swal.fire({
                            icon:'error',
                            title: 'Opps, hubo un error',
                            text: 'porfavor intenta nuevamente',
                        })
                      
                    }else{
                        Swal.fire({
                            title: 'Producto Eliminado Correctamente',
                            type:'success',
                            icon:'success',
                            showCancelButton: false,
                            confirmButtonColor:'#3085d6',
             
               
                            confirmButtonText: 'ACEPTAR'
                    
                        }).then((result)=>{
                            if(result.value){
                                window.location = "productos";
                            }
                        })
                    }
                },
                error:function(error){
                    console.log(error)
                }

            })
        }
    })

})

}