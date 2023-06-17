
  
$(document).ready(function(){
    if($('.cajas').length>0){
        
        iniciarApp();
        
    

        function iniciarApp(){
            mostrarTablas();
            submitForm();
            formatearEfectivo();
            cerrarCaja();
            $(document).on('click','.btnInfoCaja',  infoCaja);
        }

        function infoCaja(){
            $('.info_caja').empty();
            const id_info_egreso = ($(this).attr('idCaja'))
            datos = new FormData();
            datos.append('id_caja_info',id_info_egreso);
            $.ajax({
                url: 'ajax/AjaxCajas.php',
                data:datos,
                method:'POST',
                processData:false,
                cache:false,
                contentType:false,
                dataType:'json',
                success:function(req){
                   console.log(req)
                   moment.locale('es');
            
                    const fecha_apertura = moment(req['fecha_apertura']).format("D [de] MMMM [del] YYYY, [Hora] h:mm a");
                    const fecha_cierre = moment(req['fecha_cierre']).format("D [de] MMMM [del] YYYY, [Hora] h:mm a");
                    const pagos = parseInt(req['efectivo_cierre'])-parseInt(req['efectivo_ventas'])-parseInt(req['efectivo_apertura'])+parseInt(req['creditos'])-parseInt(req['ingreso'])+parseInt(req['egreso']);
                   
                    $('.info_caja').append(`
              
                       
                        <li class="list-group-item text-lg" style="font-size:20px">Efectivo en Caja: <strong>${$.number(req['efectivo_cierre'])}</strong></li>
                        <li class="list-group-item text-lg" style="font-size:20px">Efectivo Inicial: <strong>${$.number(req['efectivo_apertura'])}</strong></li>
                        <li class="list-group-item text-lg" style="font-size:20px">Ventas: <strong>${$.number(req['efectivo_ventas'])}</strong></li>
                        <li class="list-group-item text-lg" style="font-size:20px">Creditos: <strong>${$.number(req['creditos'])}</strong></li>
                        <li class="list-group-item text-lg" style="font-size:20px">Pagos: <strong>${$.number(pagos)}</strong></li>
                        <li class="list-group-item text-lg" style="font-size:20px">Ingresos: <strong>${$.number(req['ingreso'])}</strong></li>
                        <li class="list-group-item text-lg" style="font-size:20px">Egresos: <strong>${$.number(req['egreso'])}</strong></li>
                    
                  
                      
                        <li class="list-group-item text-lg" style="font-size:20px">fecha apertura: <strong>${fecha_apertura}</strong></li>
                        <li class="list-group-item text-lg" style="font-size:20px">fecha cierre: <strong>${fecha_cierre}</strong></li>
             
                    
                    `)
                },
                error:function(error){
                    console.log(error.responseText)
                }
            })
        }

        //cerrar la caja al dar click
        function cerrarCaja(){
            $(document).on('dblclick', '#cerrar_caja',function(){
                Swal.fire({
        
                    title: 'Esta Seguro de Cerrar esta Caja?',
                    text: 'Esta acción no se puede deshacer',
                    type:'warning',
                    icon:'warning',
                    showCancelButton: true,
                    confirmButtonColor:'#3085d6',
                    cancelarButtonColor:'#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'confirmar'
        
                }).then((result)=>{
                    if(result.isConfirmed){
                        
                        const id_caja = $(this).attr('idCaja');
                        
                        
                  
                        
                        const datos = new FormData();
                        datos.append("id_caja",id_caja);
                      
                       
                        $.ajax({
                            url:"ajax/AjaxCajas.php",
                            method:"POST",
                            data:datos,
                            cache:false,
                            contentType:false,
                            processData:false,
                            dataType: "json",
                            success:function(req){
                                console.log(req)
                        
                                if(req=='no_validate'){
                                    location.reload();
                                }
                                
                                Swal.fire({
                                
                                    title:'Caja Cerrada Exitosamente',
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
                        },
                        error:function(error){
                           
                            console.log(error.responseText)
                        }
                    })
                }else{
                        location.reload()
                }
                    
                })
            })
        }

        //mostrarmos todas las cajas existentes
        function mostrarTablas(){
      
            $(".tablasCajas").dataTable().fnDestroy(); //por si me da error de reinicializar

            $('.tablasCajas').DataTable({
                ajax: 'ajax/AjaxTablaCajas.php',
                "deferRender":true,
                "retrieve":true,
                "proccesing":true
            });  
        }

        function submitForm(){
           $('form').submit(function(e){
                e.preventDefault();
                const   efectivo = $('#efectivo_inicial').val();
                const  efectivo_formateado = efectivo;

                // Eliminar los separadores de miles
                const valor_sin_formato = efectivo_formateado.replace(/,/g, '');
              
                // Convertir el valor a número
                const efectivo_inicial = parseFloat(valor_sin_formato);
              
                validarFormulario(efectivo_inicial)
           })
        }

        function validarFormulario(efectivo_inicial){
            $('.alerta').remove();
            if(isNaN(efectivo_inicial)){
              
                $('form').append('<div class="alert alert-danger alerta text-center alerta">Debe ingresar un valor inicial sin importar si es Cero</div>');
                return;
            }
            
            enviarDatos(efectivo_inicial);
            
        }

        function enviarDatos(efectivo_inicial){
            $('#abrirCaja').prop('disabled',true)
            const datos = new FormData();
            datos.append('efectivo_inicial',efectivo_inicial);

            $.ajax({
                url:"ajax/AjaxCajas.php",
                data:datos,
                method: 'POST',
                contentType:false,
                processData:false,
                cache:false,
                dataType:'json',
                success:function(req){
                    console.log(req);
                    $('#abrirCaja').prop('disabled',false)
                    if(req=='success'){
                        Swal.fire({
                                
                            title:'Caja Abierta Exitosamente',
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
                },
                error:function(error){
                    console.log(error.responseText);
                }
            })
        }

        function formatearEfectivo(){
            $('#efectivo_inicial').on('input',function(){
                let valor = $(this).val();

                // Eliminar cualquier carácter que no sea un dígito o un punto decimal
                valor = valor.replace(/[^\d.]/g, '');
              
                // Dividir el valor en parte entera y parte decimal
                const partes = valor.split('.');
              
                // Formatear la parte entera con separadores de miles
                partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
              
                // Reunir las partes nuevamente con el punto decimal
                valor = partes.join('.');
              
                // Establecer el valor formateado en el input
                $(this).val(valor);
            })
        }

    }

    
})