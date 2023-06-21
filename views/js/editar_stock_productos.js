
if($('.tablaProductos').length>0 || $('.tablaComprasPendientes').length>0 ){


let info_producto;
let id_producto;

iniciarapp();

function iniciarapp(){
    $(document).on('click','#btn_stock',leerIdProducto);
    $(document).on('input','#nuevo_precio_compra', formaterPrecio)
    submitFormulario();
}

function formaterPrecio(){

    const nuevo_precio_compra = parseFloat( $(this).val().replace(/,/g, ''));
  
    const precio_compra_number = Number(nuevo_precio_compra)
    const precio_formateado = $.number(precio_compra_number);
    $(this).val(precio_formateado)

}

function submitFormulario(){
    $('form').submit(function(e){
       // $('#btnEditarStock').prop('disabled',true)
        e.preventDefault();
        
        //validar infomracion
        validarInformacion();
    
        // const agregar_stock = $('#editar_stock_producto').val();
     
        // enviarStock(agregar_stock);
    })
}

function calcularDatos(agregar_stock, nuevo_precio_compra){

    const {stock, precio_compra, precio_venta} = info_producto;


    //aqui calculamos el precio de compra que se almacenara en la base de datos
    const precio_compra_final = (stock*precio_compra + agregar_stock*nuevo_precio_compra)/(stock+agregar_stock);
 
    //ahora calculamos el porcentaje de venta que se tiene para este producto 
    const porcentaje_utilidad = (precio_venta*100/precio_compra)/100 - 1;
   
    //ahora calculamos el precio de venta final 
    const precio_venta_final =  Math.round((precio_compra_final+precio_compra_final*porcentaje_utilidad)/ 100) *100;

    //y el nuevo stock que seria el stock ingresado sumado al stock existente para actualizar la base de datos
    const stock_nuevo = agregar_stock+stock
 
    
    //preguntamos si enviamos la informacion
    Swal.fire({
        title: `Esta seguro de agregar ${agregar_stock} productos a ${$.number(Number(nuevo_precio_compra))} pesos`,
        text:'esta acción no se puede deshacer',
        icon:'warning',
        showDenyButton: false,
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'aceptar'
        
    }).then((result) => {
                  
        if (result.isConfirmed) {
            enviarInformacion(precio_compra_final,precio_venta_final,stock_nuevo)
            
        } 
    })



}


function validarInformacion(){
    if($('.alerta').length>0){
        $('.alerta').remove();
    }
    const agregar_stock = $('#editar_stock_producto').val();
    const nuevo_precio_compra =  parseFloat( $('#nuevo_precio_compra').val().replace(/,/g, ''));

    if(agregar_stock=='' || nuevo_precio_compra==''){
        $('form').append('<div class="alert alert-danger alerta text-center">ambos campos son obligatorios</div>');
        return;
    }
  
    calcularDatos(parseInt(agregar_stock), nuevo_precio_compra);


}

function enviarInformacion(precio_compra_final,precio_venta_final,stock_nuevo){
    if($('.alerta').length>0){
        $('.alerta').remove();
    }
    $('#btnEditarStock').prop('disabled',true)
   

    
    const datos = new FormData();
    datos.append('agregar_stock', stock_nuevo);

    datos.append('precio_compra_final', precio_compra_final);
    datos.append('precio_venta_final', precio_venta_final);
    datos.append('id_producto_editar_stock', id_producto);
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
          
            if(req == 'no_validate'){
                $('form').append('<div class="alert alert-danger alerta text-center">Por Favor introduzca datos válidos</div>');
                return;
            }
            if(req=='success'){
                Swal.fire({
                    title: 'Datos Actualizados Correctamente',
                    type:'success',
                    icon:'success',
                    showCancelButton: false,
                    confirmButtonColor:'#3085d6',
     
       
                    confirmButtonText: 'ACEPTAR'
            
                }).then((result)=>{
                    if(result.value){
                        if(window.location.href.indexOf('productos')!==-1){
                            window.location = "productos";
                            return;
                        }
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

function leerIdProducto(){

    $('#editar_stock_producto').val('')
    $('#nuevo_precio_compra').val('')

    // $('#editar_stock').val('0')
    id_producto = $(this).attr('id_producto_editar_stock');
    //stock_actual = $(this).text();
    consultarInformacionProducto(id_producto);
  
    
       
}

function consultarInformacionProducto(id_producto){
    const datos = new FormData();
    datos.append('id',id_producto);
 
    $.ajax({
        url: 'ajax/AjaxProductos.php',
        data:datos,
        method:'POST',
        contentType:false,
        cache:false,
        processData:false,
        dataType:'json',
        success:function(req){
            info_producto = req;
        },
        error:function(error){
            console.log(error.responseText)
        }
    })
}
}
