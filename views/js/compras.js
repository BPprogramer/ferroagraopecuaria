if($('.tablaComprasPendientes').length>0){
  
    $(".tablaComprasPendientes").dataTable().fnDestroy(); //por si me da error de reinicializar
    
    $('.tablaComprasPendientes').DataTable({
        ajax: 'ajax/AjaxTablaStock.php',
        "deferRender":true,
        "retrieve":true,
        "proccesing":true
    });
    

        // $(document).ready(function(){
        //    $.ajax({
        //         url:"ajax/AjaxTablaStock.php",
              
           
        //         success:function(req){
        //             console.log(req)
        //         },
        //         error:function(error){
        //             console.log(error);
        //         }
        //     })
        // })

    let id_producto;
    let stock_actual;

    iniciarapp();

    function iniciarapp(){
        $(document).on('click','#btn_stock',leerStockIdProducto);
        submitFormulario();
    }

    function submitFormulario(){
        $('form').submit(function(e){
    
            $('#btnEditarStock').prop('disabled',true)
            e.preventDefault();
            const agregar_stock = $('#editar_stock').val();
           
            enviarStock(agregar_stock);
        })
    }

    function enviarStock(agregar_stock){
        if($('.alerta').length>0){
            $('.alerta').remove();
        }
        const datos = new FormData();
        datos.append('agregar_stock', agregar_stock);
        datos.append('stock_actual', stock_actual);
        datos.append('id_producto_editar', id_producto);
        $.ajax({
            url: 'ajax/AjaxProductos.php',
            data:datos,
            method:'POST',
            contentType:false,
            cache:false,
            processData:false,
            dataType:'json',
            success:function(req){
                console.log(req)
                if(req == 'empty'){
                    $('form').append('<div class="alert alert-danger alerta text-center">el Campo no puede ir vacio</div>');
                    return;
                }
                if(req == 'no_validate'){
                    $('form').append('<div class="alert alert-danger alerta text-center">Por Favor introduzca un valor numérico y positivo</div>');
                    return;
                }
                if(req=='success'){
                    Swal.fire({
                        title: 'Stock Actualizado Correctamente',
                        type:'success',
                        icon:'success',
                        showCancelButton: false,
                        confirmButtonColor:'#3085d6',
         
           
                        confirmButtonText: 'ACEPTAR'
                
                    }).then((result)=>{
                        if(result.value){
                            window.location = "compras";
                        }
                    })
                }
            },
            error:function(error){
                console.log(error.responseText)
            }
        })
    }

    function leerStockIdProducto(){

        $('#editar_stock').val('0')
        id_producto = $(this).attr('idProducto');
        stock_actual = $(this).text();
       
           
    }
 

}