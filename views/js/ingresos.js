if($('.tablaIngresos').length>0){
        let ingreso='';
        let id_editar='';
        iniciarApp();

        function iniciarApp(){
            mostrarIngresos();
            $(document).on('input', '#ingreso',formatearIngreso);
            $('.formulario_guardar_ingreso').submit(leerDatos);

            //edicion
            $(document).on('click','.btnEditarIngreso',  consultarIngresoEditar);
            $('.formulario_editar_ingreso').submit(leerDatosEditar);

            $(document).on('input', '#ingreso_editar',formatearIngreso);

            //elliminar ingreso}
            $(document).on('click','.btnEliminarIngreso',  leerIdEliminar);
            $(document).on('click','.btnInfoIngreso',  infoIngreso);

        }

        function infoIngreso(){
            $('.info_ingreso').empty();
            const id_info_ingreso = ($(this).attr('idIngreso'))
            datos = new FormData();
            datos.append('id_ingreso',id_info_ingreso);
            $.ajax({
                url: 'ajax/AjaxIngresos.php',
                data:datos,
                method:'POST',
                processData:false,
                cache:false,
                contentType:false,
                dataType:'json',
                success:function(req){
                    const fecha_formateada = moment(req['fecha']).locale('es').format('D [de] MMMM [del] YYYY');
                    const input_ingreso = Number(req['ingreso'])
                    $('.info_ingreso').append(`
                        <li class="list-group-item text-lg" style="font-size:20px">Responsable : <strong>${req['responsable']}</strong></li>
                        <li class="list-group-item text-lg" style="font-size:20px">Ingreso: <strong>${$.number(input_ingreso)}</strong></li>
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
            const id_eliminar = $(this).attr('idIngreso');
            Swal.fire({
                title:'Esta Seguro que Desea Eliminar este Ingreso?',
                text: 'esta accion no se puede deshacer',
               
                icon: 'warning',
                type: 'warning',
                showCancelButton:true,
                cancelButtonText:'Cancelar',
                confirmButtonText: 'si, eliminar Ingreso'
            }).then((result)=>{
                if(result.value){
                    eliminarIngreso(id_eliminar)
                }   
            })
        }

        function eliminarIngreso(id_eliminar){
            datos = new FormData();
            datos.append('id_eliminar',id_eliminar);
            $.ajax({
                url: 'ajax/AjaxIngresos.php',
                data:datos,
                method:'POST',
                processData:false,
                cache:false,
                contentType:false,
                dataType:'json',
                success:function(req){
                    if(req=='success'){
                        Swal.fire({
                            title: 'Ingreso Eliminado Correctamente',
                            type:'success',
                            icon:'success',
                            showCancelButton: false,
                            confirmButtonColor:'#3085d6',
             
               
                            confirmButtonText: 'ACEPTAR'
                    
                        }).then((result)=>{
                            if(result.value){
                                window.location = "ingresos";
                            }
                        })
                    }
                },
                error:function(error){
                    console.log(error.responseText)
                }
            })
        }

        function consultarIngresoEditar(){
          
            const id_ingreso = $(this).attr('idIngreso');
            const datos = new FormData();
            datos.append('id_ingreso',id_ingreso);
            $.ajax({
                url: 'ajax/AjaxIngresos.php',
                data:datos,
                method:'POST',
                processData:false,
                cache:false,
                contentType:false,
                dataType:'json',
                success:function(req){
                    ingreso = req['ingreso'];
                    id_editar = req['id'];
                    llenarFormulario(req);
                },
                error:function(error){
                    console.log(error.responseText)
                }
             
            })
        }
        function llenarFormulario(datos){
            const ingreso = Number(datos['ingreso'])
            $('#ingreso_editar').val($.number(ingreso))
            $('#descripcion_editar').val((datos['descripcion']))
            $('#nota_editar').val((datos['nota']))
        }

        
        function formatearIngreso(){
         
            const ingreso_input = $(this).val().replace(/,/g, ''); //convertimos a numero sin comas
            ingreso = ingreso_input; //aqui agregamos el valor de ingreso que sera enviado por ajax
            
            const ingreso_number = Number(ingreso_input);
            const ingreso_formateado = $.number(ingreso_number);
            $(this).val(ingreso_formateado)
       
            
            
        }


        function leerDatos(e){
            e.preventDefault();
            id_editar = '';
            const descripcion = $('#descripcion').val();
            const nota = $('#nota').val();
            const referencia = '.formulario_guardar_ingreso'
            
            validarDatos({descripcion, nota, }, referencia);
        }
        function leerDatosEditar(e){
            e.preventDefault();
       
            const descripcion = $('#descripcion_editar').val();
            const nota = $('#nota_editar').val();
            const referencia = '.formulario_editar_ingreso'
            validarDatos({descripcion, nota, }, referencia);
        }

        function validarDatos(datos, referencia){
            $('.alerta').remove()
           const  {descripcion, nota} = datos;

           if(ingreso == ''){
                $(referencia).append('<div class="alert alert-danger alerta text-center">El valor del ingreso es obligatorio</div>')       
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
                const ingreso_format = Number(ingreso);
                Swal.fire({
                    title: `Esta seguro agregar ${$.number(ingreso_format)} ?`,
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
            datos.append('ingreso',ingreso);
            datos.append('descripcion',descripcion);
            datos.append('nota',nota);
            if(id_editar == ''){
                $('#btnAgregarIngreso').prop('disabled',true)
            }else{
                $('#btnEditarIngreso').prop('disabled',true)
            }
          
            $.ajax({
                url: 'ajax/AjaxIngresos.php',
                data:datos,
                method:'POST',
                processData:false,
                cache:false,
                contentType:false,
                dataType:'json',
                success:function(req){
                    console.log(req)
                    if(req=='no_validate'){
                        $('#btnAgregarIngreso').prop('disabled',false)
                        $('form').append('<div class="alert alert-danger alerta text-center">Información no valida</div>') 
                        return;
                    }
                    if(req=='error'){
                        $('#btnAgregarIngreso').prop('disabled',false)
                        $('form').append('<div class="alert alert-danger alerta text-center">Hubo un error, porvor intenta nuevamente</div>') 
                        return;
                    }
                    if(req=='success'){
                        if($('.alerta').length>0){
                            $('.alerta').remove();
                        }
                        Swal.fire({
                            title: 'Ingreso Agregado Correctamente',
                            type:'success',
                            icon:'success',
                            showCancelButton: false,
                            confirmButtonColor:'#3085d6',
             
               
                            confirmButtonText: 'ACEPTAR'
                    
                        }).then((result)=>{
                            if(result.value){
                                window.location = "ingresos";
                            }
                        })
                    }
                    
                },
                error:function(error){
                   console.log(error.responseText)
                
                }
            })
        }
        function mostrarIngresos(){

            if($('.tablaIngresos').length>0){

                $(".tablaIngresos").dataTable().fnDestroy(); //por si me da error de reinicializar
                
                $('.tablaIngresos').DataTable({
                    ajax: 'ajax/AjaxTablaIngresos.php',
                    "deferRender":true,
                    "retrieve":true,
                    "proccesing":true
                });
              
                
                
                // if($('.tablaIngresos').length>0){
                //     $(document).ready(function(){
                //        $.ajax({
                //             url:"ajax/AjaxTablaIngresos.php",
                          
                       
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