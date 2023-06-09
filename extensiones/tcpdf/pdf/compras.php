<?php 

require_once('../../../models/Proveedores.php');
require_once('../../../models/Productos.php');
require_once('../../../controllers/ProveedorController.php');
require_once('../../../controllers/ProductosController.php'); 
// require_once('../../../controllers/ClienteController.php'); 


ob_start();
class imprimirFactura{
    public $nombre;
    public $stock_minimo;
    public $stock_maximo;
    public $stock_actual;
    public $proveedor;
    public $tel_proveedor;
    public $productos_filtrados;
    
    
  
    
    public function consultar(){
        $productos_all = ProductosController::consultarProductos(null, null);
        $this->productos_filtrados = [];
        foreach($productos_all as $key=>$producto){
            if($producto['stock']>=$producto['stock_minimo']){
                continue;
            }
            $producto['proveedor'] = ProveedorController::consultarProveedores('id',$producto['id_proveedor']);
            $this->productos_filtrados[] = $producto;
        }


    }
    public function imprimir(){
      
        require('tcpdf_include.php'); 
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->startPageGroup();
        $pdf->AddPage();
   
        $bloque_1 = <<<EOF
        <table>
            <tr>
                <td style="width:400px"><img src="images/baner_gildardo.PNG"></td>
               
             
                <td style="background-color:white; width:140px; text-align:center; color:black">
                    <br><br>Compras Pendientes<br><br>
                </td>
            </tr>
        </table>
        EOF; 
        $pdf->writeHTML($bloque_1, false, false, false, false, '');


        
        $bloque_3 = <<<EOF
        <br><br>
        
        
            <table style="font-size:9px; padding:2x">
                <tr>
          
                    <td style="border:1px solid #666; background-color:white; width:30px; text-align:center">#</td>
                    <td style="border:1px solid #666; background-color:white; width:120px">Producto</td>
                    <td style="border:1px solid #666; background-color:white; width:60px">S Mínimo</td>
                    <td style="border:1px solid #666; background-color:white; width:60px">S Mínimo</td>
                    <td style="border:1px solid #666; background-color:white; width:60px"><strong>S Actual</strong></td>
                    <td style="border:1px solid #666; background-color:white; width:120px">Proveedor</td>
                    <td style="border:1px solid #666; background-color:white; width:80px">Tel</td>
          
                </tr>
               
            </table>
        EOF;
        $pdf->writeHTML($bloque_3, false, false, false, false, '');
        
        $i = 0;
        foreach($this->productos_filtrados as $producto){
            $i++;
            $bloque_4 = <<<EOF
        
            
            
                <table style="font-size:8px; padding:2px">
                    <tr>
                      
                        <td style="border:1px solid #666; background-color:white; width:30px; text-align:center"> {$i}</td>
                        <td style="border:1px solid #666; background-color:white; width:120px"> {$producto['descripcion']}</td>
                        <td style="border:1px solid #666; background-color:white; width:60px; text-align:center">{$producto['stock_minimo']}</td>
                        <td style="border:1px solid #666; background-color:white; width:60px; text-align:center">{$producto['stock_maximo']}</td>
                        <td style="border:1px solid #666; background-color:white; width:60px; text-align:center"><strong>{$producto['stock']}</strong></td>
                        <td style="border:1px solid #666; background-color:white; width:120px"> {$producto['proveedor']['nombre']}</td>
                        <td style="border:1px solid #666; background-color:white; width:80px"> {$producto['proveedor']['telefono']}</td>
            
                    </tr>
                
                </table>
            EOF;
            $pdf->writeHTML($bloque_4, false, false, false, false, '');
        }

        $pdf->Output('factura.pdf');

    }
}
$impresion = new imprimirFactura();

$impresion->consultar();
$impresion->imprimir();


?>
