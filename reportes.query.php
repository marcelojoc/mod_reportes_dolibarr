<?php
require_once '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/reportes/class/reportes.class.php';
require_once DOL_DOCUMENT_ROOT.'/reportes/class/tercero.class.php';
// validar acceso


$consulta = GETPOST("consulta", "alpha");
$datos     = GETPOST("dato", "alpha");



//var_dump($datos);

$consulta = $_GET["consulta"];
$dato     =  $_GET["dato"];

//$clientes = new Tercero($db);


// $reporte   = new Reportes ($db, 8, "fecha ini", "fecha fin", 2 );


$respuesta=null;

		$vendedor = new Vendedor($db);
		$respuesta = $vendedor->getCodVendedor(2);

//$prueba = $ruta->getRutas();

//$prueba= $vendor->getVendedores();

//var_dump($reporte);

$respuesta = $reporte->getClientes();


var_dump($respuesta);

       


//  switch ($consulta)
// {

//     	default:

//         $redirection = DOL_URL_ROOT.'/cashdesk/affIndex.php?menutpl=validation';
//         break;



//         case 'get_valProduct':                        // consulta datos del producto  y si tiene tabla de descuentos la devuelve esta de otro modo devuelve una nula

        

//         $respuesta = $clientes->getClienteAsociado(2);
//          break;
// }


echo json_encode($respuesta);