<?php
$res=0;
if (! $res && file_exists("../main.inc.php")) $res=@include '../main.inc.php';					// to work if your module directory is into dolibarr root htdocs directory
if (! $res && file_exists("../../main.inc.php")) $res=@include '../../main.inc.php';			// to work if your module directory is into a subdir of root htdocs directory
if (! $res && file_exists("../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../dolibarr/htdocs/main.inc.php';     // Used on dev env only
if (! $res && file_exists("../../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../../dolibarr/htdocs/main.inc.php';   // Used on dev env only
if (! $res) die("Include of main fails");

require('lib/fpdf.php');

class PDF extends FPDF
{
// Cargar los datos
function LoadData($file)
{
    // Leer las líneas del fichero
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}


// Tabla simple
function BasicTable($header, $data)
{
    // Cabecera
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Datos
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}
// // Tabla simple
// function BasicTable($header, $data)
// {
//     // Cabecera
//     foreach($header as $col)
//         $this->Cell(40,7,$col,1);
//     $this->Ln();
//     // Datos
//     foreach($data as $row)
//     {
//         foreach($row as $col)
//             $this->Cell(40,6,$col,1);
//         $this->Ln();
//     }
// }

// // Una tabla más completa
function ImprovedTable($header, $data, $reporte , $totales)
{

    $productos=(int)$totales['total_prod'];

    $monto =(float) $totales['total_importe'];


    $this->SetFont('Arial','',8);
    // Color de fondo
    $this->SetFillColor(200,220,255);
    // Título
    $this->Cell(0,9,"Reporte de Ventas desde  ". $reporte['fechaini'] . " Hasta " . $reporte['fechafin'] ,0,1,'C',true);
    // Salto de línea
    $this->Ln(4);

    $this->Cell(0,9,"Vendedor ". $reporte['nombre'] . "     Producto: ".$reporte['nom_prod'],0,1,'L',true);
    // Salto de línea
    $this->Ln(4);

    $this->Cell(0,9,"Clientes ". $totales['total_clientes'] . "       Clientes con Ventas ". $totales['clientes_con_ventas']."       Clientes sin Ventas ". $totales['clientes_sin_ventas'] ,0,1,'L',true);
    // Salto de línea
    $this->Ln(4);

    // Anchuras de las columnas
    $w = array(17, 50, 50, 25,25,20,10);
    // Cabeceras
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Datos
    foreach($data as $row)
    {
        //var_dump($row);
        $this->Cell($w[0],6,$row['codigo'],'LR',0,'C');
        $this->Cell($w[1],6,$row['nombre'],'LR',0,'L');
        $this->Cell($w[2],6,$row['direccion'],'LR',0,'L');
        $this->Cell($w[3],6,$row['importe']  ." % (". round (($row['importe'] * 100)/ $monto, 2)     ." )"   ,'LR',0,'C');
        $this->Cell($w[4],6,$row['cantidad'] ." % (". round (($row['cantidad'] * 100)/ $productos, 2)     ." )" ,'LR',0,'C');

        if($row['ultimaFactura']== null)
        {

            $this->Cell($w[5],6,"Sin registro",'LR',0,'C');

        }else{

            $this->Cell($w[5],6,$row['ultimaFactura'],'LR',0,'C');

        }
        
        $this->Cell($w[6],6,$row['ruta'],'LR',0,'C');

        $this->Ln();
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');

    $this->Ln(4);

    $this->Cell(0,9,"Total productos ". $productos .  "           Valor $". $monto ,0,1,'L',true);
    // Salto de línea
    $this->Ln(4);
}

}


    $pdf = new PDF();
    // Títulos de las columnas

    $header = array('Codigo', 'Cliente', 'Domicilio', 'importe', 'Cantidad', 'fecha', 'Ruta');
    // Carga de datos
    // $data = $_POST['tabla'][0];
    // $resumen = $_POST['tabla'][1];

    $pdf->SetFont('Arial','',8);
    
    $pdf->AddPage();
    $pdf->SetTextColor(0);

    $data = $_SESSION['tmp_pdf'][0];

    $totales= $_SESSION['tmp_pdf'][1];

    $reporte = $_SESSION['reporte'];

//     var_dump($reporte);



// //unset($_SESSION['reporte']);


// $totales['total_prod'];;
// $totales['total_clientes'];
// $totales['clientes_con_ventas'];
// $totales['clientes_sin_ventas'];
// var_dump($totales);

//       var_dump($totales);
//    var_dump($reporte['fechaini']);
    // $pdf->BasicTable($header,$data);
    // $pdf->AddPage();
    // $pdf->ImprovedTable($header,$data);
    // $pdf->AddPage();
    $pdf->ImprovedTable($header,$data, $reporte, $totales);
    $pdf->Output("reporte.pdf", "I");

unset($_SESSION['tmp_pdf']);
unset($_SESSION['tmp_pdf']);


?>