<?php 

require_once('../../../models/Ventas.php');
require_once('../../../models/Clientes.php');
require_once('../../../models/Usuarios.php');
require_once('../../../controllers/VentasController.php'); 
// require_once('../../../controllers/ClienteController.php'); 


ob_start();
class imprimirFactura{
    public $codigo;
    public $fecha;
    public $productos;
    public $neto;
    public $impuesto;
    public $total;
    public $cliente;
    public $vendedor;
    public $total_pagar;
    public $nombre_cliente;
    public $cedula_cliente;
    public $telefono_cliente;
    public $direccion_cliente;
    public $correo_cliente;
    public $abono;
    
  
    
    public function consultar(){
        $venta = VentasController::consultarDatosVenta('codigo', $this->codigo);
        $this->fecha = substr($venta['fecha'],0,-8);
        $this->productos = json_decode($venta['productos'],true);
        $this->total = number_format($venta['total'],2);
        $this->deuda = number_format($venta['deuda'],2);
        $this->abono = number_format($venta['total']-$venta['deuda'],2);
        $this->total_pagar = number_format($venta['total'],2);
        $this->nombre_cliente = $venta['nombre_cliente'];
        $this->cedula_cliente = $venta['cedula_cliente'];
        $this->telefono_cliente = $venta['telefono_cliente'];
        $this->correo_cliente = $venta['correo'];
        $this->direccion_cliente = $venta['direccion'];
       

        $this->vendedor = $venta['nombre_vendedor'];

        //$this->cliente = ClienteController::consultarClientes('id',$venta['id_cliente']);
        // $this->vendedor = UsuarioController::consultarUsuario('usuarios','id',$venta['id_vendedor']);
   

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
               
             
                <td style="background-color:white; width:140px; text-align:center; color:red">
                    <br><br>Factura N.<br>$this->codigo<br>
                </td>
            </tr>
        </table>
        EOF; 
        $pdf->writeHTML($bloque_1, false, false, false, false, '');


        $bloque_2 = <<<EOF
        <br><br>
        
        
            <table style="font-size:10px; padding:5px 10px">
                <tr>
                    <td style="border:1px solid #666; background-color:white; width:390px">
                        Vendedor: <strong>$this->vendedor</strong>
                    </td>
                    <td style="border:1px solid #666; background-color:white; width:150px">
                        Fecha: <strong>$this->fecha</strong>
                    </td>
                </tr>
            
            </table>
            
            <h3> Cliente</h3>
            <br>
            <table style="font-size:10px; padding:5px 10px">
                <tr>
                    <td style="border:1px solid #666; background-color:white; width:270px">
                        Nombre:   <strong>$this->nombre_cliente</strong>
                    </td>
                    <td style="border:1px solid #666; background-color:white; width:270px">
                       Cédula:   <strong>$this->cedula_cliente</strong>
                    </td>
                  
                
                </tr>
            
            </table>

            <table style="font-size:10px; padding:5px 10px">
                <tr>
                    <td style="border:1px solid #666; background-color:white; width:270px">
                        Telefono:   <strong>$this->telefono_cliente</strong>
                    </td>
                    <td style="border:1px solid #666; background-color:white; width:270px">
                        Correo:   <strong>$this->correo_cliente</strong>
                    </td>
                </tr>
            </table>
            <table style="font-size:10px; padding:5px 10px">
                <tr>
                    <td style="border:1px solid #666; background-color:white; width:270px">
                        Dirección:   <strong>$this->direccion_cliente</strong>
                    </td>
                    
                </tr>
            </table>

          
           
        EOF;
        $pdf->writeHTML($bloque_2, false, false, false, false, '');


        $bloque_3 = <<<EOF
        <br><br>
        
        
            <table style="font-size:10px; padding:5px 10px">
                <tr>
                    <td style="border:1px solid #666; background-color:white; width:260px"> Producto</td>
                    <td style="border:1px solid #666; background-color:white; width:80px">Cantidad</td>
                    <td style="border:1px solid #666; background-color:white; width:100px">Valor Unitario</td>
                    <td style="border:1px solid #666; background-color:white; width:100px">Valor total</td>
          
                </tr>
               
            </table>
        EOF;
        $pdf->writeHTML($bloque_3, false, false, false, false, '');

        foreach($this->productos as $producto){
            $total_producto = number_format($producto['precio_producto']*$producto['cantidad'],2);
            $valor_unitario = number_format($producto['precio_producto'],2);
            $bloque_4 = <<<EOF
        
            
            
                <table style="font-size:10px; padding:5px 10px">
                    <tr>
                        <td style="border:1px solid #666; background-color:white; width:260px"> {$producto['descripcion']}</td>
                        <td style="border:1px solid #666; background-color:white; width:80px">{$producto['cantidad']}</td>
                        <td style="border:1px solid #666; background-color:white; width:100px">$ $valor_unitario</td>
                        <td style="border:1px solid #666; background-color:white; width:100px"><strong>$ $total_producto</strong></td>
            
                    </tr>
                
                </table>
            EOF;
            $pdf->writeHTML($bloque_4, false, false, false, false, '');
        }
        $bloque_5 = <<<EOF
        <br><br>
        
        
            <table style="font-size:10px; padding:5px 10px">
                <tr>
                    <td style="border-right:1px solid #666;background-color:white; width:340px"> </td>
                    <td style="border:1px solid #666; background-color:white; width:100px">Total Compra: </td>
                    <td style="border:1px solid #666;border-left::1px solid #666; background-color:white; width:100px"><strong>$ $this->total</strong></td>
                </tr>
                <tr>
                    <td style="border-right:1px solid #666;background-color:white; width:340px"> </td>
                    <td style="border:1px solid #666; background-color:white; width:100px">Abono: </td>
                    <td style="border:1px solid #666;border-left::1px solid #666; background-color:white; width:100px"><strong>$ $this->abono</strong></td>
                </tr>
                <tr>
                    <td style="border-right:1px solid #666;background-color:white; width:340px"> </td>
                    <td style="border:1px solid #666; background-color:white; width:100px">Total Pagar: </td>
                    <td style="border:1px solid #666;border-left::1px solid #666; background-color:white; width:100px"><strong>$ $this->deuda</strong></td>
                </tr>
               
            </table>
        EOF;
        $pdf->writeHTML($bloque_5, false, false, false, false, '');


        $pdf->Output('factura.pdf');

    }
}
$impresion = new imprimirFactura();
$impresion->codigo = $_GET['id'];
$impresion->consultar();
$impresion->imprimir();


?>
