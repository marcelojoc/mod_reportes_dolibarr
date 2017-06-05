<?php
require_once '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/reportes/class/reportes.class.php';
//require_once DOL_DOCUMENT_ROOT.'/reportes/class/tercero.class.php';
// validar acceso


// $consulta = GETPOST("consulta", "alpha");
// $datos     = GETPOST("dato", "alpha");


//var_dump($datos);

$consulta = $_POST["consulta"]; // recibir datos de metodo a ejecutar
$dato     =  $_POST["dato"];	// recibo un arreglo con los datos del formulario

// Separo cada dato enviado para instanciar el reporte
$id_usuario   = 8;
$fecha_ini    = '02/11/2015';
$fecha_fin    = '05/06/2017';
$id_producto  = 2;
$nombre_vendedor = "FRANCO AGUSTIN BERTOLO";
$nom_prod     = "Speed Unlimited 250 ml x 24 latas";
$ruta         =1;


// var_dump($consulta);
// var_dump($datos);

$reporte   = new Reportes ($db, $id_usuario, $fecha_ini, $fecha_fin , $id_producto, $ruta );
//$reporte   = new Reportes ($db, 0, '02/11/2016', '20/02/2017' , 2 ,4);


$respuesta=null;


//$respuesta= $reporte->getClientes();
//$respuesta= $reporte->getCantidadComprobantes("527");
$respuesta= $reporte->getReportecomprobantes();

//echo($respuesta['comprobantes']);
var_dump($respuesta);


// $_SESSION['tmp_pdf']= $respuesta;

// $_SESSION['reporte'] ["fechaini"]=  $fecha_ini;
// $_SESSION['reporte'] ["fechafin"]=  $fecha_fin;
// $_SESSION['reporte'] ["nombre"]  =  $nombre_vendedor;
// $_SESSION['reporte'] ["nom_prod"]  =  $nom_prod;



// $_SESSION['reporte'] ["total_prod"]=  $respuesta[1]['total_prod'];;
// $_SESSION['reporte'] ["total_clientes"]=  $respuesta[1]['total_clientes'];
// $_SESSION['reporte'] ["clientes_con_ventas"]=  $respuesta[1]['clientes_con_ventas'];
// $_SESSION['reporte'] ["clientes_sin_ventas"]=  $respuesta[1]['clientes_sin_ventas'];





       
//var_dump($respuesta);

//  switch ($consulta)
// {

//     	default:

//         $redirection = DOL_URL_ROOT.'/cashdesk/affIndex.php?menutpl=validation';
//         break;



//         case 'get_valProduct':                        // consulta datos del producto  y si tiene tabla de descuentos la devuelve esta de otro modo devuelve una nula

        

//         $respuesta = $clientes->getClienteAsociado(2);
//          break;
// }


//echo json_encode($respuesta);