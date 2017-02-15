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
// function ImprovedTable($header, $data)
// {
//     // Anchuras de las columnas
//     $w = array(40, 35, 45, 40);
//     // Cabeceras
//     for($i=0;$i<count($header);$i++)
//         $this->Cell($w[$i],7,$header[$i],1,0,'C');
//     $this->Ln();
//     // Datos
//     foreach($data as $row)
//     {
//         $this->Cell($w[0],6,$row[0],'LR');
//         $this->Cell($w[1],6,$row[1],'LR');
//         $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
//         $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
//         $this->Ln();
//     }
//     // Línea de cierre
//     $this->Cell(array_sum($w),0,'','T');
// }

// Tabla coloreada
function FancyTable($header, $data)
{

    $this->SetFont('Arial','',8);
    // Color de fondo
    $this->SetFillColor(200,220,255);
    // Título
    $this->Cell(0,9,"Reporte de Ruta ".$_SESSION["vendorPrint"],0,1,'C',true);
    // Salto de línea
    $this->Ln(4);
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Cabecera
    $w = array(20, 80, 80, 10);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row['cod_client'],'LRB',0,'C');
        $this->Cell($w[1],6,$row['nom'],'LRB',0,'L');
        $this->Cell($w[2],6,$row['adress'],'LRB',0,'L');
        $this->Cell($w[3],6,$row['ruta'],'LRB',0,'C');
        $this->Ln();
        
    }
    // Línea de cierre
    //$this->Cell(array_sum($w),0,'','T');
}
}



//$data = unserialize($_SESSION["dataPrint"]);

if (isset($_SESSION["dataPrint"])){


    $pdf = new PDF();
    // Títulos de las columnas

    $header = array('Codigo', 'Nombre', 'Direccion', 'Ruta');
    // Carga de datos
    $data = $_SESSION["dataPrint"];
    $pdf->SetFont('Arial','',11);
    
    $pdf->AddPage();
    $pdf->SetTextColor(0);
    // $pdf->BasicTable($header,$data);
    // $pdf->AddPage();
    // $pdf->ImprovedTable($header,$data);
    // $pdf->AddPage();
    $pdf->FancyTable($header,$data);
    $pdf->Output();




}else{

    echo "No hay datos disponibles para imprimir";
}


?>