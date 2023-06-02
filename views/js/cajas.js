
  
$(document).ready(function(){
    if($('.cajas').length>0){
        
        iniciarApp();
        
    

        function iniciarApp(){
            mostrarTablas();
            submitForm();
            formatearEfectivo();
            cerrarCaja();
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
                            console.log('asddf')
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