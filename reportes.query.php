<?php
require_once '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/reportes/class/reportes.class.php';
require_once DOL_DOCUMENT_ROOT.'/reportes/class/tercero.class.php';
// validar acceso


$consulta = GETPOST("consulta", "alpha");
$datos     = GETPOST("dato", "alpha");



//var_dump($datos);

// $consulta = $_GET["consulta"];
// $dato     =  $_GET["dato"];

$clientes = new Tercero($db);

$ruta   = new Reportes ($db);


$respuesta=null;


//$prueba = $ruta->getRutas();

//$prueba= $vendor->getVendedores();

        $clientes = new Tercero($db);

       


 switch ($consulta)
{

    	default:

        $redirection = DOL_URL_ROOT.'/cashdesk/affIndex.php?menutpl=validation';
        break;



        case 'get_valProduct':                        // consulta datos del producto  y si tiene tabla de descuentos la devuelve esta de otro modo devuelve una nula

        

        $respuesta = $clientes->getClienteAsociado(2);
         break;
}


echo json_encode($respuesta);