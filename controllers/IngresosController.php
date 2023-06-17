<?php 

    class IngresosController{
        public static function agregarIngreso(){
            session_start();
            
            //en caso de que haya un id debemos validarlo
            $id = $_POST['id_editar'];
            if($id!=''){
                $id = filter_var($id, FILTER_VALIDATE_INT);
                if(!$id){
                    return 'no_validate';
                }
                $id = htmlspecialchars($id);
            }

            $ingreso = filter_var((int)$_POST['ingreso'], FILTER_VALIDATE_INT);
            $descripcion = $_POST['descripcion'];
            $nota = $_POST['nota'];
          
            if(!$ingreso || !is_string($descripcion) || !is_string($nota)){
                return 'no_validate';
              
            }
          
            $ingreso = htmlspecialchars($ingreso);
            $descripcion = htmlspecialchars($descripcion);
            $nota = htmlspecialchars($nota);
            date_default_timezone_set('America/Bogota');
            
            $args = ['ingreso'=>$ingreso,'responsable'=>$_SESSION['nombre'], 'descripcion'=>$descripcion,'nota'=>$nota,'estado'=>0,  'fecha'=>date('Y-m-d H:i:s')];
            
            $ingresos = new Ingresos();
            if($id!=''){
           
                $args['id'] = $id;
            }
          
            return $ingresos->agregarIngreso($args);
            
            
   
        }
        public static function consultarIngresos($columna=null, $valor=null){
         
            if($valor){
                $id = filter_var($valor, FILTER_VALIDATE_INT);
                if(!$id){
                    return 'no_validate';
                }

            }
            $ingresos = Ingresos::consultarIngresos($columna, $valor);
            return $ingresos;
        }
        public static function eliminarIngreso(){
         

          
            $id = filter_var($_POST['id_eliminar'], FILTER_VALIDATE_INT);
            if(!$id){
                return 'no_validate';
            }
         

            
            $ingresos = new Ingresos();

            return $ingresos->eliminarIngreso($id);
        }
    }