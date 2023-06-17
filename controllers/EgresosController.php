<?php 

    class EgresosController{
        public static function agregarEgreso(){
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

            $egreso = filter_var((int)$_POST['egreso'], FILTER_VALIDATE_INT);
            $descripcion = $_POST['descripcion'];
            $nota = $_POST['nota'];
          
            if(!$egreso || !is_string($descripcion) || !is_string($nota)){
                return 'no_validate';
              
            }
          
            $egreso = htmlspecialchars($egreso);
            $descripcion = htmlspecialchars($descripcion);
            $nota = htmlspecialchars($nota);
            date_default_timezone_set('America/Bogota');
            
            $args = ['egreso'=>$egreso,'responsable'=>$_SESSION['nombre'], 'descripcion'=>$descripcion,'nota'=>$nota,'estado'=>0,  'fecha'=>date('Y-m-d H:i:s')];
            
            $egresos = new Egresos();
            if($id!=''){
           
                $args['id'] = $id;
            }
          
            return $egresos->agregarEgreso($args);
            
            
   
        }
        public static function consultarEgresos($columna=null, $valor=null){
         
            if($valor){
                $id = filter_var($valor, FILTER_VALIDATE_INT);
                if(!$id){
                    return 'no_validate';
                }

            }
            $egresos = Egresos::consultarEgresos($columna, $valor);
            return $egresos;
        }
        public static function eliminarEgreso(){
         

          
            $id = filter_var($_POST['id_eliminar'], FILTER_VALIDATE_INT);
            if(!$id){
                return 'no_validate';
            }
         

            
            $egresos = new Egresos();

            return $egresos->eliminarEgreso($id);
        }
    }