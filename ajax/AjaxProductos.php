<?php 

    require_once '../controllers/ProductosController.php';
    require_once '../controllers/CategoriasController.php';
    require_once '../models/Productos.php';
    require_once '../models/Categorias.php';

    class AjaxProductos{

        public function ajaxCrearCodigoProducto($id_categoria){
            $respuesta = ProductosController::consultarProductos('id_categoria', $id_categoria);
            echo json_encode($respuesta);
        }

        public function ajaxRegistrarProducto(){
            
            $respuesta = ProductosController::crearProducto();
            echo json_encode($respuesta);
        }
        public function ajaxConsultarProducto($columna, $valor){
           
            $respuesta = ProductosController::consultarProductos($columna, $valor);
            echo json_encode($respuesta);
        }
        public function ajaxConsultarCategoria(){ //me traigo los datos de una categoria ocn el id
            $respuesta = CategoriasController::consultarCategorias('id', $_POST['id_categoria_consulta']);
            echo json_encode($respuesta);
        }
        public function ajaxEditarProducto(){
           
            $respuesta = ProductosController::editarProducto();
            echo json_encode($respuesta);
        }

        public function ajaxEliminarProducto(){
            $respuesta = ProductosController::eliminarProducto();
            echo json_encode($respuesta);
        }
        //consultar productos ordenados por el numero de ventas de manera ascendente
        public function ajaxConsultarProductosDes(){ 
            $respuesta = ProductosController::consultarProductosDes('ventas');
            echo json_encode($respuesta);
        }

        public function ajaxAgregarStock(){
            $respuesta = ProductosController::agregarStock();
            echo json_encode($respuesta);
        }
    }

    $producto = new AjaxProductos();

    if(isset($_POST['id_categoria'])){
   
        $id_categoria = $_POST['id_categoria'];
         $producto->ajaxCrearCodigoProducto($id_categoria);
    }

    if(isset($_POST['idCategoria']) && isset($_POST['codigo'])){
    
       $producto->ajaxRegistrarProducto();
      
    
    }
    if(isset($_POST['id'])){
        $producto->ajaxConsultarProducto('id', $_POST['id']);
  
    }
    if(isset($_POST['id_categoria_consulta'])){
        $producto->ajaxConsultarCategoria();
    }
    if(isset($_POST['id_producto'])){
        $producto->ajaxEditarProducto();
    }
    if(isset($_POST['id_eliminar'])){
       $producto->ajaxEliminarProducto();
    }
    if(isset($_POST['consultar_productos'])){

        $producto->ajaxConsultarProducto(null, null);
    }
    if(isset($_POST['consultar_productos_desc'])){

        $producto->ajaxConsultarProductosDes();
    }
    if(isset($_POST['agregar_stock'])){

        $producto->ajaxAgregarStock();
    }
  
?>
   