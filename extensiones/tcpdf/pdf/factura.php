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
    public $descuento;
    public $cliente;
    public $vendedor;
    public $total_pagar;
    public $nombre_cliente;
    public $cedula_cliente;
    public $telefono_cliente;
    public $direccion_cliente;
    public $correo_cliente;
    public $abono;
    public $metodo_pago;
    public $total_pagar_sin_descuento;
    public $valor_descuento;
    
  
    
    public function consultar(){

        $venta = VentasController::consultarDatosVenta('codigo', $this->codigo);
        $this->metodo_pago = $venta['metodo_pago'];
        $this->total_pagar_sin_descuento =  number_format($venta['total']/(1-$venta['descuento']),2);
        $this->valor_descuento =  number_format(($venta['total']/(1-$venta['descuento']))-$venta['total'],2);
        $this->fecha = substr($venta['fecha'],0,-8);
        $this->productos = json_decode($venta['productos'],true);
        $this->total = number_format($venta['total'],2);
        $this->descuento =$venta['descuento']*100;
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
    //    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    //     $pdf->setPrintHeader(false); //quitamos el header
    //     $pdf->setPrintFooter(false);
      
    //     $pdf->AddPage('P','A7'); //DAMOS EL FORMATO DEL PDF

      
   // Establecer una altura personalizada
   $pdf = new TCPDF('P', 'mm', array(80, 190), true, 'UTF-8', false);
   //$pdf = new TCPDF('P', 'mm', 'A7', true, 'UTF-8', false);
    $altura_personalizada = 190; // Altura en mm
    $pdf->setPrintHeader(false); //quitamos el header
    $pdf->setPrintFooter(false);
    
    // Agregar una página al PDF con la altura personalizada
    $pdf->AddPage();
    
    // Agregar contenido al PDF
    $pdf->SetFont('helvetica', '', 12);
   

        // Establecer una altura personalizada







// Agregar una página al PDF con la altura personalizada
       // $pdf->AddPage('P', array($pdf->getPageWidth(), $altura_personalizada));

        $bloque_1 = <<<EOF
           
            <div  style="font-size:10px;width:160px; height:500px; text-align:center; font-size:8px margin-bottom:0;">
                FERROAGROPECUARIA CAMPO VIDA
                <br>
                Nit: 98395261-7
                <br>
                Cel: 3175881174, 3104624214
                <br>
                Email: gildardobenavides@hotmail.com
                <br>
                La Victoria
                <br>
                <br>
                **********************************************
                <br>
                <br>
                Ticket No: $this->codigo
                <br>
                <br>
                Fecha Compra No: $this->fecha
                
              
            </div>    
               

        EOF;

        $pdf->writeHTML($bloque_1, false, false, false, false, '');

        if($this->nombre_cliente != ''){
                $bloque_nombre = <<<EOF
             
                    <div  style="font-size:10px;width:160px; text-align:center; font-size:8px margin-bottom:0;">
                        Cliente: $this->nombre_cliente
                    </div>
                    
                EOF;

        $pdf->writeHTML($bloque_nombre, false, false, false, false, '');
        }
        if($this->cedula_cliente != ''){
            $bloque_cedula = <<<EOF
               
                <div  style="font-size:10px;width:160px; text-align:center; font-size:8px margin-bottom:0;">
                    Cedula: $this->cedula_cliente
                </div>
            EOF;
             $pdf->writeHTML($bloque_cedula, false, false, false, false, '');
        }
        if($this->telefono_cliente != ''){
            $bloque_telefono = <<<EOF
               
                <div  style="font-size:10px;width:160px; text-align:center; font-size:8px margin-bottom:0;">
                    Telefono: $this->telefono_cliente
                </div>
            EOF;
             $pdf->writeHTML($bloque_telefono, false, false, false, false, '');
        }
        if($this->direccion_cliente != ''){
            $bloque_direccion = <<<EOF
            
                <div  style="font-size:10px;width:160px; text-align:center; font-size:8px margin-bottom:0;">
                    Dirección: $this->direccion_cliente
                </div>
            EOF;
             $pdf->writeHTML($bloque_direccion, false, false, false, false, '');
        }
        if($this->correo_cliente != ''){
            $bloque_correo = <<<EOF
            
                <div  style="font-size:10px;width:160px; text-align:center; font-size:8px margin-bottom:0;">
                    Email: $this->correo_cliente
                </div>
            EOF;
             $pdf->writeHTML($bloque_correo, false, false, false, false, '');
        }

        $bloque_vendedor = <<<EOF
            
            <div  style="font-size:10px;width:160px; text-align:center; font-size:8px margin-bottom:0;">
                Vendedor: $this->vendedor
            </div>
        EOF;
        $pdf->writeHTML($bloque_vendedor, false, false, false, false, '');
        
        $bloque_salto = <<<EOF
               
            <div  style="font-size:10px;width:160px; text-align:center; font-size:8px margin-bottom:0;">
                <br>
                **********************************************
                Productos
               
               
            </div>
        EOF;
    
        $pdf->writeHTML($bloque_salto, false, false, false, false, '');
        foreach($this->productos as $producto){
            $total_producto = number_format($producto['precio_producto']*$producto['cantidad'],2);
            $valor_unitario = number_format($producto['precio_producto'],2);
            $description = substr($producto['descripcion'], 0 , 15);
            $bloque_productos = <<<EOF
            <br>
            <div  style="font-size:10px;width:160px; text-align:left; font-size:8px">
          
               <span style=""> {$description}</span>  : {$valor_unitario}X{$producto['cantidad']} = {$total_producto} 
                <br>
                  
                         
            </div>

         <br>

        EOF;
    
        $pdf->writeHTML($bloque_productos, false, false, false, false, '');
        }
        $bloque_salto = <<<EOF
               
            <div  style="font-size:10px;width:160px; text-align:center; font-size:8px margin-bottom:0;">
                <br>
                **********************************************
              
              
            
            </div>
        EOF;
        $pdf->writeHTML($bloque_salto, false, false, false, false, '');
        
        

        if($this->metodo_pago == 'efectivo'){
            $bloque_correo = <<<EOF
            
                <div  style="font-size:10px;width:160px; text-align:right; font-size:8px margin-bottom:0;">
                    Pago en efectivo
                    <br>
                    <br>
                    <strong>Importe:</strong> $this->total_pagar_sin_descuento
                    <br>
                    <strong>Descuento :</strong> {$this->descuento}% =  {$this->valor_descuento}
                    <br>
                    <strong>Total:</strong> $this->total
                    <br>
                    
                </div>
        EOF;
        $pdf->writeHTML($bloque_correo, false, false, false, false, '');
       }else{
            $bloque_correo = <<<EOF
            
                <div  style="font-size:10px;width:160px; text-align:right; font-size:8px margin-bottom:0;">
                    Pago a Credito
                    <br>
                    <br>
                    <strong>Importe:</strong> $this->total_pagar_sin_descuento
                    <br>
                    <strong>Descuento :</strong> {$this->descuento}% =  {$this->valor_descuento}
                    <br>
                    <strong>Total:</strong> $this->total
                    <br>
                    <strong>Abono:</strong> $this->abono
                    <br>
                    <strong>Saldo Pendiente:</strong> $this->deuda
                </div>
            EOF;
            $pdf->writeHTML($bloque_correo, false, false, false, false, '');
       }


       //final
       $bloque_salto_fin = <<<EOF
                
        <div  style="font-size:15px;width:160px; text-align:center; font-size:8px margin-bottom:0;">
            <br>
            **********************************************
            <br>
            Agradecemos Su Compra
      
         
         
          
         
      
         
        
        </div>
       EOF;
       $pdf->writeHTML($bloque_salto_fin, false, false, false, false, '');

        

 

      
        




        $pdf->Output('factura.pdf');

    }
}
$impresion = new imprimirFactura();
$impresion->codigo = $_GET['id'];
$impresion->consultar();
$impresion->imprimir();


?>
