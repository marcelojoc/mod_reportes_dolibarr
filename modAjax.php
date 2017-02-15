<?php

require_once '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/descuentos/class/vendedor.class.php';
require_once DOL_DOCUMENT_ROOT.'/descuentos/class/ruta.class.php';
// validar acceso


$consulta = GETPOST("action", "alpha");
$ruta     = GETPOST("r", "alpha");
$id    = GETPOST("id", "alpha");


// $consulta = $_GET["consulta"];
// $dato     =  $_GET["dato"];

$vendor = new Vendedor($db);

$ruta   = new Ruta ($db);

$ruta->setIdRuta(1);
$ruta->setIdVendedor(8);

$respuesta=null;


//$prueba = $ruta->getRutas();

$prueba= $vendor->getVendedores();


//  switch ($consulta)
// {

//     	default:

//         $redirection = DOL_URL_ROOT.'/cashdesk/affIndex.php?menutpl=validation';
//         break;



//         case 'get_valProduct':                        // consulta datos del producto  y si tiene tabla de descuentos la devuelve esta de otro modo devuelve una nula

//         if(!isset($_SESSION['serObjFacturation'])){  // si no hay variable de sesion para el objeto facturacion  la creo


//                  $obj_facturation = new Facturation();

//         }else{                                       // si ya existe. la desserializo  y la elimino, debo recrear el objeto

                
//                 $obj_facturation = unserialize($_SESSION['serObjFacturation']);
//                 unset ($_SESSION['serObjFacturation']);

//         }


//                break;
// }


echo json_encode($prueba);