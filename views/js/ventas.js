// const params = $.parseParams(window.location.search.substring(1))
// console.log(params)
//variables globales para guardar la venta con ajax





if($('#formulario_editar').length>0 || $('.formulario_crear').length>0){



let codigo;
let id_cliente;
let id_vendedor;
let productos;
let descuento = 0;
// if($('#formulario_editar').length>0 ){
//    descuento =  $('#total_pagar').attr('descuento_editar');
// }else{
//     descuento = 0;
// }
console.log(descuento)
let total;

let metodo_pago='efectivo';

let abono=0;


let deuda=0;

let total_precio_de_compra;

let nombre_cliente = '';
let cedula_cliente = '';
let telefono_cliente = '';
let direccion_cliente = '';
let correo_cliente = '';


$(document).ready(function(){
    $('.cambio_efectivo').number(true,0)
    $('.valor_efectivo').number(true,0)
    $('.valor_deuda').number(true,0)
    $('.valor_abono').number(true,0)
    
});




let width_page;
$(document).ready(function() {
    width_page = $(window).width();
    //console.log(width_page);
});

$(window).resize(function() {
   width_page = $(window).width();
  /*  console.log(width_page)
    if(width_page>1100&&width_page<1199 ){
        location.reload();
    }
    if(width_page>1200&&width_page<1300 ){
        location.reload();
    } */
   //console.log(width_page);
});


$(document).ready(function(){
    let cliente_seleccionado;
    if(window.location.href.indexOf('editar-venta')!==-1){
        cliente_seleccionado = $('#id_cliente_venta').attr('id_cliente_venta')
    }
        
        if($('.clienteCrearVenta').length>0){

            $.ajax({
                url:'ajax/AjaxClientes.php',
                dataType: "json",
                success:function(req){
             
                   req.forEach(cliente =>{
                    if(cliente.id == cliente_seleccionado){
                        $('.clienteCrearVenta').append(`<option selected value='${cliente.id}'>${cliente.nombre}</option>`);
                    }else{
                        $('.clienteCrearVenta').append(`<option value='${cliente.id}'>${cliente.nombre}</option>`);
                    }
                      
                   })
                },
                error:function(error){
                    console.log(error)
                }
            })
        }
       
   

})


$(".tablaProductosVentas").dataTable().fnDestroy(); //por si me da error de reinicializar

$('.tablaProductosVentas').DataTable({
    ajax: 'ajax/AjaxTablaProductosVentas.php',
    "deferRender":true,
    "retrieve":true,
    "proccesing":true
});

/* gregar productos a la venta */
$(".tablaProductosVentas").on('click', '.agregarProducto', function(){

    const id_producto_venta = $(this).attr('idProducto');
 
  
    const datos = new FormData();
    datos.append('id', id_producto_venta);
    $.ajax({
        url:'ajax/AjaxProductos.php',
        method:"POST",
        data:datos, 
        cache:false,
        contentType:false,
        processData:false,
        dataType:"json",
        success:function(req){
     
            const descripcion = req['descripcion']
            const stock = req['stock']
          
            const precio = req['precio_venta']
            const precio_compra = req['precio_compra'];
            const id = req['id']
            if(stock==0){
              
                Swal.fire({
                  
                    title:'No disponible en Stock',
                    icon:'error',
                    confirmButtonText:'cerrar'

                })
                return;
            }
         
            // $('.stock_'+id).text(stock-1)
            $(`.agregarProducto[idProducto=${id}]`).removeClass('btn-primary agregarProducto')
            $(`.agregarProducto[idProducto=${id}]`).addClass('btn-default');
            $(`.agregarProducto[idProducto=${id}]`).attr('disabled', true)
            $('.productosVenta').append(` 
                <div class="row mb-4 rowVenta" style="margin-bottom:10px; padding:5px 15px">
                    <div class="col-sm-6" style="padding-right:5px">
                        <div class="input-group" style="padding-right:10px">
                            <span class="input-group-addon">
                                <button class="btn btn-danger btn-xs eliminarProductoVenta" id_producto_eliminar="${id}" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </span>
                            <input type="text" value="${descripcion}" id_producto="${id}" class="form-control descripcion_producto" id="descripcion_producto" name="agregar_producto" placeholder="descripcion"  readonly> 
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-xs-6" class="contenido_cantidad">
                                <input type="number" value="1" class="form-control cantidad_producto" stock_actual="${stock-1}" stock="${stock}" id="cantidad_producto" name="cantidad_producto" min="1" placeholder="cantidad">
                            </div>
                            <div class="col-xs-6 contenido_precio" style="padding-left:0px">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                    <div type="number" class="form-control precio_producto" id="precio_producto" name="precio_producto" style="background-color:#f9f9f9;" precioCompra=${precio_compra} precioProducto = ${precio}>${precio}</div>
                                </div>
                            </div>  
                        </div>
                    </div>  
                </div>            
            `)
            $('.precio_producto').number(true,0)
            
       
            sumarTotalPrecios();   
       
          //modificar el stock en el html
           
 
         
        },
        error:function(error){
            console.log(error.responseText)
            return;
        }
    
    })


});


/* nos ayudamos de localstorage para qu se retornen los cambios del boton agregar despues de haber elñiminado */
$(".tablaProductosVentas").on('draw.dt', function(){ //escucha por cualquie interaccion con la tabla
    if(localStorage.getItem('eliminar_producto_venta')!=null){
        const eliminar_producto_venta = JSON.parse(localStorage.getItem('eliminar_producto_venta'))
        
        for(let i=0; i<eliminar_producto_venta.length; i++){
         console.log(eliminar_producto_venta)
            $(`.recuperarBoton[idProducto='${eliminar_producto_venta[i]["id"]}']`).addClass('btn-primary agregarProducto')
            $(`.recuperarBoton[idProducto='${eliminar_producto_venta[i]["id"]}']`).removeClass('btn-default')
            $(`.recuperarBoton[idProducto='${eliminar_producto_venta[i]["id"]}']`).attr('disabled', false)
        }
    }
})


/* eliminar productos de la venta al dar click enla x y retornar el boton de agregar */
let id_eliminar_producto = [];
localStorage.removeItem('eliminar_producto_venta')//eliminamos el storage cada vez que recargue la pagina

$('.productosVenta').on('click','.eliminarProductoVenta',function(){
        const id = $(this).attr('id_producto_eliminar');
        
       
        if(localStorage.getItem('eliminar_producto_venta')!=null){
            id_eliminar_producto.concat(localStorage.getItem('eliminar_producto_venta'))
        }
        id_eliminar_producto.push({"id":id});
        localStorage.setItem("eliminar_producto_venta", JSON.stringify(id_eliminar_producto))
        
     
        $(this).parent().parent().parent().parent().remove();
        $(`.recuperarBoton[idProducto='${id}']`).addClass('btn-primary agregarProducto')
        $(`.recuperarBoton[idProducto='${id}']`).removeClass('btn-default')
        $(`.recuperarBoton[idProducto='${id}']`).attr('disabled', false)
        sumarTotalPrecios();
      
})


//seleccionar producto
let num_producto = 0;
$('.btnAgregarProducto').click(function(){
  
    num_producto++;
    const datos = new FormData();
    datos.append("consultar_productos", "ok");
   
    $.ajax({
        url:"ajax/AjaxProductos.php",
        method:'POST',
        data:datos,
        cache:false,
        contentType:false,
        processData:false,
        dataType:"json",
        success:function(req){
       
            $('.productosVenta').append(` 
            <div class="row mb-4 rowVenta" style="margin-bottom:10px; padding:5px 15px">
                <div class="col-xs-6" style="padding-right:10px">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <button class="btn btn-danger btn-xs eliminarProductoVenta"  id_producto_eliminar="" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                        </span>
                        
                        <select class="form-control descripcion_producto"  id="producto_${num_producto}" >
                            <option disabled selected>Seleccione</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-3 contenido_cantidad">
                    <input type="number" class="form-control cantidad_producto" stock_actual="" name="cantidad_producto" min="0" placeholder="cantidad" value="1">
                </div>
                <div class="col-xs-3 contenido_precio" style="padding-left:0px">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                        <div  class="form-control precio_producto" name="precio_producto" style="background-color:#f9f9f9;" ></div>
                    </div>
                </div>  
            </div>            
        `);

   
            req.forEach(functionForEach)
            function functionForEach(producto){
                if(producto['stock']!=0){
                    $('#producto_'+num_producto).append(`<option value="${producto['id']}" id_producto='${producto['id']}'">${producto['descripcion']}</option>`)
                   
                    
                }
 
            }
  
            
      
        },
        error:function(error){
            console.log(error.responseText)
        }
    })
})

//imprimir le precio del producto seleccionado
//seleccionar productos para dispositivos
$('.productosVenta').on('change','select.descripcion_producto',function(){
    
    const precio_producto = $(this).parent().parent().parent().children(".contenido_precio").children().children(".precio_producto")
    const cantidad_producto =$(this).parent().parent().parent().children(".contenido_cantidad").children(".cantidad_producto")

    const id_producto_seleccionado  =  $(this).val();

    //console.log(id_producto_seleccionado)
    const datos = new FormData();
    datos.append('id', id_producto_seleccionado);
    $.ajax({
        url:"ajax/AjaxProductos.php",
        method:'POST',
        data:datos,
        cache:false,
        contentType:false,
        processData:false,
        dataType:"json",
        success:function(req){
        
            $('select.descripcion_producto').attr('des_'+id_producto_seleccionado, req["descripcion"])
            $(cantidad_producto).attr('stock', req["stock"]);
           
            $(cantidad_producto).val(1);
            $(cantidad_producto).attr("stock_actual",req["stock"]-1);
        

            $(precio_producto).text(req['precio_venta'])
            $(precio_producto).attr('precioProducto', req['precio_venta'])
            $(precio_producto).attr('precioCompra', req['precio_compra'])

           
            $('.precio_producto').number(true,2)
            sumarTotalPrecios();
         
        },
        error:function(error){
            console.log(error.responseText)
        }

    })
 
});



//modificar la cantidad

$('.productosVenta').on('input', 'input.cantidad_producto', function(){
  
    const stock = Number($(this).attr("stock"))
    
    //$(this).attr("stock",stock)


    const cantidad = Number($(this).val())
    // if(width_page>=1199){
    //     $('.stock_'+id).text(stock-1)
    // }
    const stock_actual = stock-cantidad;
    $(this).attr('stock_actual',stock_actual);


    if(cantidad>stock){
      
        $(this).attr('stock_actual',0);
        //$(this).val(0)
        $(this).val($(this).val()-1)
        //console.log(cantidad +" es mayor que "+stock)
        Swal.fire({
            title:'No disponible de mas productos en el  Stock',
            icon:'error',
            confirmButtonText:'cerrar'

        })
        $(this).val($(this).val()-stock)
        console.log($(this).parent().parent().children('.contenido_precio').children().children('.precio_producto').text(0))
        sumarTotalPrecios();
        // $(this).val(0)
        // console.log($('.productosVenta').find("#precio_producto").val(0));
    }else{
        const precio = $(this).parent().parent().children('.contenido_precio').children().children('.precio_producto')
        const precio_total_producto = ($(this).val())*(precio.attr('precioProducto'));
        const precio_formateado = $.number(precio_total_producto,2)

        precio.text(precio_formateado)
        sumarTotalPrecios();
    }
   // $('.precio_producto').number(true,2)
    
   
    
   
})

//agregar descuento
$('#descuento').on('input',aplicarDescuento);

function aplicarDescuento(){
    $('.valor_abono').val(0)
    $('.valor_deuda').val(0)
    $('.valor_efectivo').val(0)
    $('.cambio_efectivo').val(0)
    sumarTotalPrecios();
  
}



//sumar todos los precios
function sumarTotalPrecios(){
   
    let arreglo_precios = [];

     //$('.precio_producto').number(true,2)
    const precio_producto = $('.precio_producto');
    


    if(precio_producto.length==0){
        $('#total_venta').text(0)
        $('#total_pagar').text(0)
        total=0;
        return;
    }
   
    precio_producto.each(function(index,producto){
        const precio_producto = parseFloat($(producto).text().replace(/,/g, ''));
      
       
        arreglo_precios.push(precio_producto)
     
    })
  

    //sumamos los precios a precio de venta
    let precio_total_pedido = arreglo_precios.reduce(sumarPrecios)
    function sumarPrecios(total, precio_producto){
        return parseInt(total)+parseInt(precio_producto);
    }

    
    //$('#total_venta').attr('total_sin_inpuesto', precio_total_pedido)

    const total_pagar = Number(precio_total_pedido)

    const precio_formateado = $.number(total_pagar);
    $('#total_venta').text(precio_formateado,2)

  
  
   
    //aqui aplicamos el descuento
    if($('#descuento').val()!=''){
        descuento = ($('#descuento').val())/100;
        
    }else{
        descuento = 0;
    }

    const total_exacto_pagar = total_pagar - total_pagar*descuento
    const precio_formateado_total = $.number(total_exacto_pagar);
    $('#total_pagar').text(precio_formateado_total,2)
    //asignar los datos a las variables que se enviaran por ajax para almacenar en la base de datos
  
    total = total_pagar;

   
   

    //$('#total_venta').number(true,2)
   //$('.precio_producto').number(true,2)
   listarProductos()

}



//listar todos los productos seleccionados para la venta

function listarProductos(){

    let listarProductos = [];
    total_precio_de_compra = 0;
    

    const descripcion = $('.descripcion_producto');

    const cantidad = $('.cantidad_producto');
    const precio = $('.precio_producto') ;


   
 
   
    for(let i=0; i<descripcion.length;i++){
        let id;
        let des;
        
        id= $(descripcion[i]).attr("id_producto");
        des = $(descripcion[i]).val()
      
        total_precio_de_compra += $(precio[i]).attr('precioCompra')*$(cantidad[i]).val()
       
            listarProductos.push(
                {
                    "id":id,

                    "descripcion":des,
                    "cantidad":$(cantidad[i]).val(),
                    "stock_actual":$(cantidad[i]).attr('stock_actual'),
                    "precio_producto":$(precio[i]).attr('precioProducto'),
                    "precio_compra":$(precio[i]).attr('precioCompra'),
                    "precio_total":$(precio[i]).text().replace(/,/g,'')


                })
                    //console.log(listarProductos);
          
         
           
    }
  
    listarProductos = JSON.stringify(listarProductos)
    

    productos = listarProductos; //se almacenara en la base de datos 


    $('#listaProductos ').val(listarProductos)
}

//seleccionar metodo dde pago
$('#metodo_pago').change(function(){
    $('.cambio_efectivo').val(0)
    $('.valor_efectivo').val(0)
    $('.valor_deuda').val(0)
    $('.valor_abono').val(0)
    //dejar los datos del cliente vacios al cambiar el metodo de pago
    $('#nombre_cliente').val('')
    $('#cedula_cliente').val('')
    $('#telefono_cliente').val('')
    $('#direccion_cliente').val('')
    $('#correo_cliente').val('')

    //al cambiar el metodo de pago dejar en (seleccion un cliente) el selected
    $('.clienteCrearVenta option:first').prop('selected',true);

    //quitar la propeidad de solo lectura al elegir un cliente
    $('#correo_cliente').prop('readonly',false);
    $('#nombre_cliente').prop('readonly',false)
    $('#cedula_cliente').prop('readonly',false)
    $('#telefono_cliente').prop('readonly',false)
    $('#direccion_cliente').prop('readonly',false)
    $('#correo_cliente').prop('readonly',false)

    //resetear variables
    nombre_cliente = '';
    cedula_cliente = '';
    telefono_cliente = '';
    direccion_cliente = '';
    correo_cliente = '';

    //resetear valores 
    $('.contenedor_metodo_pago input').val('')
    
    //$('.contenedor_credito').addClass('hidden')
    const metodo = $(this).val();
    $('.info_cliente').removeClass('hidden');
    if(metodo == "efectivo"){
       
        // $(this).parent().parent().removeClass('col-md-6')
        // $(this).parent().parent().addClass('col-md-4')
        // $('.contenedor_metodo_pago').empty();
        // $('.contenedor_metodo_pago').append(`
        //     <div class="col-xs-6 contenedor_valor_efectivo" style="">
        //         <div class="input-group">
        //              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
        //              <input type="text"  val="" class="form-control valor_efectivo" placeholder="00000">
        //         </div>
              
        //     </div>
        //     <div class="col-xs-6 contenedor_cambio_efectivo" style="padding-left:0px ">
        //         <div class="input-group">
        //             <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
        //             <input type="text" val="" class="form-control cambio_efectivo" placeholder="0000" readonly>
        //         </div>
        //     </div>
        // `)
        $('.cambio_efectivo').number(true,0)
        $('.valor_efectivo').number(true,0)
      
    }else if(metodo=='credito'){
        $('.info_cliente').addClass('hidden');
        $('.contenedor_credito').removeClass('hidden')
        $(this).parent().parent().removeClass('col-md-6')
        $(this).parent().parent().addClass('col-md-4')
        $('.contenedor_metodo_pago').empty();
        $('.contenedor_metodo_pago').append(`
            <div class="col-xs-6 contenedor_valor_abono" style="">
                <div class="input-group">
                     <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                     <input type="text"  val="" class="form-control valor_abono" placeholder="abono" style="font-size:20px">
                </div>
              
            </div>
            <div class="col-xs-6 contenedor_valor_deuda" style="padding-left:0px ">
                <div class="input-group">
                    <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                    <input type="text" val="" class="form-control valor_deuda" placeholder="deuda" readonly style="font-size:20px">
                </div>
            </div>
        `)
        $('.valor_deuda').number(true,0)
        $('.valor_abono').number(true,0)
        
    }else{
        $('.contenedor_metodo_pago').empty();
    }

    metodoPago()
})


//cambio en efectivo
$('.contenedor_metodo_pago').on('input', 'input.valor_efectivo', calcular_cambio)
$('.contenedor_metodo_pago').on('input', 'input.valor_abono', calcular_deuda)
$('.valor_abono').on('input',calcular_deuda)
$('.valor_efectivo').on('input',calcular_deuda)

function calcular_cambio(){

    const valor_efectivo = $(this).val();
    const total_venta = parseFloat($('#total_pagar').text().replace(/,/g, ''));

    const cambio_efectivo = valor_efectivo-total_venta
   
    $('.cambio_efectivo').val(cambio_efectivo)

        
}
function calcular_deuda(){

    const valor_efectivo = $(this).val();
   
    const total_venta = parseFloat($('#total_pagar').text().replace(/,/g, ''));

    const cambio_efectivo = valor_efectivo-total_venta

    $('.valor_deuda').val(cambio_efectivo)

        
}
//cambio en transaccion
$('.contenedor_metodo_pago').on('input', 'input.valor_efectivo', function(){
    const valor_efectivo = $(this).val();
    const total_venta = parseFloat($('#total_pagar').text().replace(/,/g, ''));

    const cambio_efectivo = valor_efectivo-total_venta
   
    $('.valor_deuda').val(cambio_efectivo)

    
        
})


$('.contenedor_metodo_pago').on('input', 'input#codigo_transaccion', metodoPago) //ejecutar metodo de pago al introducir el codigo de transaccon


function metodoPago(){
    
    id_cliente = undefined;
    metodo_pago = $('#metodo_pago').val();

    $('#lista_metodo_pago').val(metodo_pago)
    $('#alerta').empty()
  
}

//id del cliente al crear la venta
$('.clienteCrearVenta').change(function(){
    id_cliente = $(this).val();
    const datos = new FormData();
    datos.append('id_cliente',id_cliente);
    $.ajax({
        url:'ajax/AjaxClientes.php',
        method:'POST',
        data:datos,
        contentType:false,
        cache:false,
        processData:false,
        dataType:'json',
        success:function(req){
            //if($('.info_cliente '))
            if($('.info_cliente').hasClass('hidden')){
                $('.info_cliente').removeClass('hidden')  
            }
          
            nombre_cliente = req['nombre'];
            cedula_cliente = req['cedula'];
            telefono_cliente = req['telefono'];
            direccion_cliente = req['direccion'];
            correo_cliente = req['correo'];
            console.log(direccion_cliente)
            $('#nombre_cliente').val(nombre_cliente)
            $('#cedula_cliente').val(cedula_cliente)
            $('#telefono_cliente').val(telefono_cliente)
            $('#direccion_cliente').val(direccion_cliente)
            $('#correo_cliente').val(correo_cliente)
            $('#correo_cliente').prop('readonly',true);
            $('#nombre_cliente').prop('readonly',true)
            $('#cedula_cliente').prop('readonly',true)
            $('#telefono_cliente').prop('readonly',true)
            $('#direccion_cliente').prop('readonly',true)
            $('#correo_cliente').prop('readonly',true)
          
        },
        error:function(error){
            console.log(error.responseText)
        }
    })
})
//id del cliente al editar la venta

/* $(document).ready(function(){
    id_cliente = $('.clienteEditarVenta').val();
}) */








$('#formulario_editar').submit(validar_enviar);
function validar_enviar(e){
 
   metodo_pago = $('#metodo_pago').val();

   e.preventDefault();
    $('#alerta').empty()
    if(!($('.productosVenta').children().length > 0)){
        console.log('depurando errores')
        $('#alerta').append('<div class="alert alert-danger text-center">por favor llenar el formulario de manera correcta</div>"')
      return;
    }
   
    codigo = $('#codigo').text();
    id_vendedor = $('#id_vendedor').val();
  

    id_cliente = $('.clienteCrearVenta').val();
   
    if(id_cliente ==undefined && metodo_pago=='credito'){
      
            $('#alerta').append('<div class="alert alert-danger text-center">Para Fiar es necesario elegir un cliente</div>"')
            return;
    }

   
    if($('.clienteEditarVenta').length>0){
        id_cliente = $('.clienteEditarVenta').val();
       
    }
    let array = [];
    if(metodo_pago=='credito'){
        array.push( codigo,id_cliente,id_vendedor,productos,total)
    }else{
        array.push( codigo,id_vendedor,productos,total)
    }
    


    if(array.some(dato=> dato==undefined)){
        $('#alerta').append('<div class="alert alert-danger text-center">por favor llenar el formulario de maner correcta a</div>"')
        return;
    }
    if(metodo_pago==undefined){
        $('#alerta').append('<div class="alert alert-danger  text-center">elija un meotodo de pago </div>"')
        return;
    }

    if(metodo_pago=='efectivo'){

        const valor_efectivo = $('.valor_efectivo').val();
        const cambio_efectivo = $('.cambio_efectivo').val();
        deuda = 0;
        
        if(valor_efectivo == "" || cambio_efectivo ==""){
           
            $('#alerta').append('<div class="alert alert-danger text-center">porfavor introduzca un valor en efectivo</div>"')
            return;
        }
        if(valor_efectivo<(total-total*descuento)){
            $('#alerta').append('<div class="alert alert-danger text-center">su efectivo no es suficiente</div>"')
            return;
        }
    
    }
    if(metodo_pago=='credito'){
        abono = $('.valor_abono').val();
        deuda = $('.valor_deuda').val();
  

        if(abono == "" || deuda ==""){
           
            $('#alerta').append('<div class="alert alert-danger text-center">porfavor introduzca un valor de abono sin importar si es cero</div>"')
            return;
        }
        
    
    }
    if(metodo_pago =='Transferencia Bancaria' || metodo_pago=='nequi'){
        console.log(metodo_pago)
        deuda = 0;
    }

   
    
    enviarDatos();
}


function enviarDatos(){
    $('.btn_crear_venta').prop('disabled',true)


   //console.log(productos)
   cedula_cliente = $('#cedula_cliente').val()
   nombre_cliente = $('#nombre_cliente').val()
   telefono_cliente = $('#telefono_cliente').val()
   direccion_cliente = $('#direccion_cliente').val()
   correo_cliente = $('#correo_cliente').val()
    const datos = new FormData();
    datos.append('codigo',codigo)
    
    datos.append('id_vendedor',id_vendedor)
    datos.append('productos',productos)
    datos.append('deuda',deuda)
    datos.append('total',(total-total*descuento))
    datos.append('descuento',descuento)
    datos.append('total_costo',total_precio_de_compra)
    datos.append('metodo_pago',metodo_pago)
    datos.append('nombre_cliente',nombre_cliente)
    datos.append('cedula_cliente',cedula_cliente)
    datos.append('telefono_cliente',telefono_cliente)
    datos.append('direccion_cliente',direccion_cliente)
    datos.append('correo_cliente',correo_cliente)


    if(metodo_pago == 'credito'){
        datos.append('id_cliente',id_cliente);
        datos.append('abono',abono)
        
    }
    if(window.location.href.indexOf('crear-venta')!==-1){ //zonasoftware.online
        console.log('creando venta')
        const create = 'create';
        datos.append('create',create)
        console.log('haciendo ajax')
        $.ajax({
            url : "ajax/AjaxVentas.php",
            method: 'POST',
            data: datos,
            contentType:false,
            processData:false,
            cache:false,
            dataType:"json",
            success:function(req){
                console.log(req);
                $('.btn_crear_venta').prop('disabled',false)
                if(req=='success'){
                    console.log('entro');
                    
                    Swal.fire({
                        title: 'Compra guardada exitosamente',
                        icon:'success',
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'aceptar',
                        
                    }).then((result) => {
                      
                        if (result.isConfirmed) {
                            window.location.href = 'administrar-ventas';
                           
                        } 
    
                    })
                }
            },
            error:function(error){
                console.log('error')
                console.log(error.responseText)
            }
    
        })
    }else{ //editar venta
    
        const id = $('#id_venta_editar').val()
        const update = 'update';
        datos.append('id',id)
        datos.append('update',update)
   
        $.ajax({
            url : "ajax/AjaxVentas.php",
            method: 'POST',
            data: datos,
            contentType:false,
            processData:false,
            cache:false,
            dataType:"json",
            success:function(req){
                console.log(req)
                if(req=='success'){
                  
                    
                    Swal.fire({
                        title: 'Compra actualizada exitosamente',
                        icon:'success',
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'aceptar',
                        
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            window.location.href = 'administrar-ventas';
                           
                        } 
    
                    })
                }
            },
            error:function(error){
          
                console.log(error.responseText)
            }
    
        })
    }
   


}


/* edicion */

    $('#formulario').submit(validar_enviar);

    $(document).ready(function(){

        sumarTotalPrecios()
    });
}




