

if($('.creditos').length>0){
    let deuda_format = 0 ;
    let cantidad_pagar = 0;
    let id;
    if($('.tablaCreditos').length>0){
        $(document).ready(function(){
     
            $(".tablaCreditos").dataTable().fnDestroy(); //por si me da error de reinicializar

            $('.tablaCreditos').DataTable({
                ajax: 'ajax/AjaxTablaCreditos.php',
                "deferRender":true,
                "retrieve":true,
                "proccesing":true
            });
           
        })
        $(document).on('click','.btnInfoCredito',function(){
            const codigo_venta = $(this).attr('codigoVenta');
            const datos = new FormData();
            datos.append('codigo_venta', codigo_venta);
            $.ajax({
                url: "ajax/AjaxCreditos.php",
                method: "POST",
                data: datos,
                cache:false,
                processData:false,
                contentType:false,
                dataType:"json",
                success:function(req){
                    mostrarInfoVenta(req);
                },
                error:function(error){
                    console.log(error.responseText)
                }
            })
 
        })

        //validar el fomrularoi al dar el boton enviar
        $('.formulario_pagar_deuda').submit(function(e){
          
            e.preventDefault();
            $('.alerta').remove()
            const pago = $('.contenido_pago_deuda').val();
            //console.log(pago)
            if(pago=='' || pago<0){
                $('<div class="alert alert-danger text-center alerta">PORFAVOR INSERTE UN VALOR VALIDO</div>').insertAfter($('.penultimo'))
            }else if(parseInt(pago)>parseInt(cantidad_pagar)){
                $('<div class="alert alert-danger text-center alerta">EL PAGO NO PUEDE SER MAYOR A LA DEUDA</div>').insertAfter($('.penultimo'))
            }else{
                const pago = $('.contenido_pago_deuda_format').val()
                Swal.fire({
                    title: `Esta seguro de pagar ${pago} ?`,
                    text:'esta acción no se puede deshacer',
                    icon:'warning',
                    showDenyButton: false,
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'aceptar'
                    
                    
                }).then((result) => {
                  
                    if (result.isConfirmed) {
                        $('#btnPagar').prop('disabled',true);
                        
                        const valor_pago = $('.contenido_pago_deuda').val()
                        const datos = new FormData();
                        datos.append('id',id)                       
                        datos.append('valor_pago',valor_pago);
                        $.ajax({
                            url:'ajax/AjaxCreditos.php',
                            method:'POST',
                            data:datos,
                            cache:false,
                            processData:false,
                            contentType:false,
                            dataType:'json',
                            success:function(req){
                                console.log(req)
                                if(req=='success'){
                                    Swal.fire({
                                        title: 'Pago Realizado Con exito',
                                        type:'success',
                                        icon:'success',
                                        showCancelButton: false,
                                        confirmButtonColor:'#3085d6',
                         
                           
                                        confirmButtonText: 'ACEPTAR'
                                
                                    }).then((result)=>{
                                        if(result.value){
                                            window.location = "creditos";
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

        //modal pagar credito
        $(document).on('click','.btnPagarCredito', function(){
            $('.contenido_pago_deuda').val("")
            $('.contenido_pago_deuda').attr("")
            $('.contenido_pago_deuda_format').val("")
            id = $(this).attr('idCredito')
        
            cantidad_pagar = $(this).attr('deuda');
            deuda = cantidad_pagar
            deuda_format = parseFloat(cantidad_pagar)
            deuda_format = $.number(deuda_format, 2)
          
            $('.contenido_deuda').val(deuda_format)
            
          
        })

        //dar click en el boton pagar todo
        $('.btn_maxima_deuda').click(function(){
          
            $('.contenido_pago_deuda').val(deuda)
            $('.contenido_pago_deuda_format').val(`$${deuda_format}`)
          
        })

        //escribir la cantidad que se quiee pagar
        $('.contenido_pago_deuda').on('input',function(e){
          
            let valor_pago = parseFloat($(this).val());
            $('.contenido_pago_deuda_format').val(`$${$.number(valor_pago,2)}`)
        })
        
    }

    function mostrarInfoVenta(info_venta){
        moment.locale('es');

        $('.info_venta').empty()
        const {total, deuda, fecha, vendedor, productos} = info_venta;
        const total_venta = total.toLocaleString('en-US', {style: 'currency', currency: 'USD'})
        const total_deuda = deuda.toLocaleString('en-US', {style: 'currency', currency: 'USD'})
      
        const fecha_formateada = moment(fecha).locale('en-es').format('D [de] MMMM [del] YYYY');
       
        $('.info_venta').append(`
            <li class="list-group-item text-lg" style="font-size:20px">Total: <strong>${total_venta}</strong></li>
            <li class="list-group-item text-lg" style="font-size:20px">Deuda: <strong>${total_deuda}</strong></li>
            <li class="list-group-item text-lg" style="font-size:20px">Fecha: <strong>${fecha_formateada}</strong></li>
            <li class="list-group-item text-lg" style="font-size:20px">Vendedor: <strong>${vendedor}</strong></li>
            <h2 class="text-center">Productos</h2>
        `)
        const info_productos = JSON.parse(productos);
        let contenedor_lista_productos = $('<li class="list-group-item text-lg">')
        let lista_productos = $('<ul class="list-group">');
       ;
        
        info_productos.forEach(info=>{
          
            let total = info['cantidad']*info['precio_producto'];
            let precio_producto = info['precio_producto'];
            precio_producto = precio_producto.toLocaleString('en-US', {style: 'currency', currency: 'USD'})
            total = total.toLocaleString('en-US', {style: 'currency', currency: 'USD'})
            let info_formateada = `${info['cantidad']} de ${info['descripcion']} a ${precio_producto} = ${total}`
            let strong = $('<strong style="font-size:20px">');
            strong.append(info_formateada)
            let li= $('<li class="list-group-item text-lg bold" style="font-size:20px">').text(info_formateada);
            lista_productos.append(strong);
            let salto = $('<br>')
            lista_productos.append(salto)
            
        })
        $(contenedor_lista_productos).append(lista_productos)
        $('.info_venta').append(contenedor_lista_productos)
        

    }
 
}   

