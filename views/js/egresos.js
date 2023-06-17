if($('.tablaEgresos').length>0){
        let egreso='';
        let id_editar='';
        iniciarApp();

        function iniciarApp(){
            mostrarEgresos();
            $(document).on('input', '#egreso',formatearEgreso);
            $('.formulario_guardar_egreso').submit(leerDatos);

            //edicion
            $(document).on('click','.btnEditarEgreso',  consultarEgresoEditar);
            $('.formulario_editar_egreso').submit(leerDatosEditar);

            $(document).on('input', '#egreso_editar',formatearEgreso);

            //elliminar egreso}
            $(document).on('click','.btnEliminarEgreso',  leerIdEliminar);
            $(document).on('click','.btnInfoEgreso',  infoEgreso);

        }

        function infoEgreso(){
            $('.info_egreso').empty();
            const id_info_egreso = ($(this).attr('idEgreso'))
            datos = new FormData();
            datos.append('id_egreso',id_info_egreso);
            $.ajax({
                url: 'ajax/AjaxEgresos.php',
                data:datos,
                method:'POST',
                processData:false,
                cache:false,
                contentType:false,
                dataType:'json',
                success:function(req){
                    const fecha_formateada = moment(req['fecha']).locale('es').format('D [de] MMMM [del] YYYY');
                    const input_egreso = Number(req['egreso'])
                    $('.info_egreso').append(`
                        <li class="list-group-item text-lg" style="font-size:20px">Responsable : <strong>${req['responsable']}</strong></li>
                        <li class="list-group-item text-lg" style="font-size:20px">Egreso: <strong>${$.number(input_egreso)}</strong></li>
                        <li class="list-group-item text-lg" style="font-size:20px">Descripción: <strong>${req['descripcion']}</strong></li>
                        <li class="list-group-item text-lg" style="font-size:20px">Nota: <strong>${req['nota']}</strong></li>
                        <li class="list-group-item text-lg" style="font-size:20px">fecha: <strong>${fecha_formateada}</strong></li>
             
                    
                    `)
                },
                error:function(error){
                    console.log(error.responseText)
                }
            })
        }

        function leerIdEliminar(){
            const id_eliminar = $(this).attr('idEgreso');
            Swal.fire({
                title:'Esta Seguro que Desea Eliminar este Egreso?',
                text: 'esta accion no se puede deshacer',
               
                icon: 'warning',
                type: 'warning',
                showCancelButton:true,
                cancelButtonText:'Cancelar',
                confirmButtonText: 'si, eliminar Egreso'
            }).then((result)=>{
                if(result.value){
                    eliminarEgreso(id_eliminar)
                }   
            })
        }

        function eliminarEgreso(id_eliminar){
            datos = new FormData();
            datos.append('id_eliminar',id_eliminar);
            $.ajax({
                url: 'ajax/AjaxEgresos.php',
                data:datos,
                method:'POST',
                processData:false,
                cache:false,
                contentType:false,
                dataType:'json',
                success:function(req){
                    if(req=='success'){
                        Swal.fire({
                            title: 'Egreso Eliminado Correctamente',
                            type:'success',
                            icon:'success',
                            showCancelButton: false,
                            confirmButtonColor:'#3085d6',
             
               
                            confirmButtonText: 'ACEPTAR'
                    
                        }).then((result)=>{
                            if(result.value){
                                window.location = "egresos";
                            }
                        })
                    }
                },
                error:function(error){
                    console.log(error.responseText)
                }
            })
        }

        function consultarEgresoEditar(){
          
            const id_egreso = $(this).attr('idEgreso');
            const datos = new FormData();
            datos.append('id_egreso',id_egreso);
            $.ajax({
                url: 'ajax/AjaxEgresos.php',
                data:datos,
                method:'POST',
                processData:false,
                cache:false,
                contentType:false,
                dataType:'json',
                success:function(req){
                    egreso = req['egreso'];
                    id_editar = req['id'];
                    llenarFormulario(req);
                },
                error:function(error){
                    console.log(error.responseText)
                }
             
            })
        }
        function llenarFormulario(datos){
            const egreso = Number(datos['egreso'])
            $('#egreso_editar').val($.number(egreso))
            $('#descripcion_editar').val((datos['descripcion']))
            $('#nota_editar').val((datos['nota']))
        }

        
        function formatearEgreso(){
         
            const egreso_input = $(this).val().replace(/,/g, ''); //convertimos a numero sin comas
            egreso = egreso_input; //aqui agregamos el valor de egreso que sera enviado por ajax
            
            const egreso_number = Number(egreso_input);
            const egreso_formateado = $.number(egreso_number);
            $(this).val(egreso_formateado)
       
            
            
        }


        function leerDatos(e){
            e.preventDefault();
            id_editar = '';
            const descripcion = $('#descripcion').val();
            const nota = $('#nota').val();
            const referencia = '.formulario_guardar_egreso'
            
            validarDatos({descripcion, nota, }, referencia);
        }
        function leerDatosEditar(e){
            e.preventDefault();
       
            const descripcion = $('#descripcion_editar').val();
            const nota = $('#nota_editar').val();
            const referencia = '.formulario_editar_egreso'
            validarDatos({descripcion, nota, }, referencia);
        }

        function validarDatos(datos, referencia){
           
            $('.alerta').remove()
           const  {descripcion, nota} = datos;

           if(egreso == ''){
                $(referencia).append('<div class="alert alert-danger alerta text-center">El valor del egreso es obligatorio</div>')       
           }
           if(descripcion == '' ){
                $(referencia).append('<div class="alert alert-danger alerta text-center">La descripción es Obligatoria</div>')       
                   
           }else if(descripcion.length>30){
                $(referencia).append('<div class="alert alert-danger alerta text-center">La descripción debe tener como máximo 30 caracteres</div>')    
           }
           if(nota.length>200){
            $(referencia).append('<div class="alert alert-danger alerta text-center">La nota debe tener como máximo 200 caracteres</div>') 
           }
           if($('.alerta').length==0){
                const egreso_format = Number(egreso);
                Swal.fire({
                    title: `Esta seguro agregar ${$.number(egreso_format)} ?`,
                    text:'esta acción no se puede deshacer',
                    icon:'warning',
                    showDenyButton: false,
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'aceptar'
                    
                    
                }).then((result) => {
                
                    if (result.isConfirmed) {
                        enviarFormulario({descripcion, nota})
                    }
                })
            }
        }

        function enviarFormulario(datosFormulario){
           
          
           
            const {descripcion, nota} = datosFormulario;
            const datos = new FormData();
            datos.append('id_editar',id_editar);
            datos.append('egreso',egreso);
            datos.append('descripcion',descripcion);
            datos.append('nota',nota);
            if(id_editar == ''){
                $('#btnAgregarEgreso').prop('disabled',true)
            }else{
                $('#btnEditarEgreso').prop('disabled',true)
            }
            console.log([...datos])
          
            $.ajax({
                url: 'ajax/AjaxEgresos.php',
                data:datos,
                method:'POST',
                processData:false,
                cache:false,
                contentType:false,
                dataType:'json',
                success:function(req){
                    console.log(req)
                    if(req=='no_validate'){
                        $('#btnAgregarEgreso').prop('disabled',false)
                        $('form').append('<div class="alert alert-danger alerta text-center">Información no valida</div>') 
                        return;
                    }
                    if(req=='error'){
                        $('#btnAgregarEgreso').prop('disabled',false)
                        $('form').append('<div class="alert alert-danger alerta text-center">Hubo un error, porvor intenta nuevamente</div>') 
                        return;
                    }
                    if(req=='success'){
                        if($('.alerta').length>0){
                            $('.alerta').remove();
                        }
                        Swal.fire({
                            title: 'Egreso Agregado Correctamente',
                            type:'success',
                            icon:'success',
                            showCancelButton: false,
                            confirmButtonColor:'#3085d6',
             
               
                            confirmButtonText: 'ACEPTAR'
                    
                        }).then((result)=>{
                            if(result.value){
                                window.location = "egresos";
                            }
                        })
                    }
                    
                },
                error:function(error){
                   console.log(error.responseText)
                
                }
            })
        }
        function mostrarEgresos(){

            if($('.tablaEgresos').length>0){

                $(".tablaEgresos").dataTable().fnDestroy(); //por si me da error de reinicializar
                
                $('.tablaEgresos').DataTable({
                    ajax: 'ajax/AjaxTablaEgresos.php',
                    "deferRender":true,
                    "retrieve":true,
                    "proccesing":true
                });
              
                
                
                // if($('.tablaEgresos').length>0){
                //     $(document).ready(function(){
                //        $.ajax({
                //             url:"ajax/AjaxTablaEgresos.php",
                          
                       
                //             success:function(req){
                //                 console.log(req)
                //             },
                //             error:function(error){
                //                 console.log(error);
                //             }
                //         })
                //     })
                // }
            }
        }
}