<?php
require_once '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/reportes/class/reportes.class.php';
require_once DOL_DOCUMENT_ROOT.'/reportes/class/tercero.class.php';
// validar acceso


// $consulta = GETPOST("consulta", "alpha");
// $datos     = GETPOST("dato", "alpha");


//var_dump($datos);

$consulta = $_POST["consulta"]; // recibir datos de metodo a ejecutar
$dato     =  $_POST["dato"];	// recibo un arreglo con los datos del formulario

// Separo cada dato enviado para instanciar el reporte
$id_usuario= $dato['vendedor'];
$fecha_ini= $dato['inicio'];
$fecha_fin= $dato['fin'];
$id_producto= $dato['producto'];





// var_dump($consulta);
// var_dump($datos);

$reporte   = new Reportes ($db, $id_usuario, $fecha_ini, $fecha_fin , $id_producto );
//$reporte   = new Reportes ($db, 8, '02/11/2016', '20/02/2017' , 2 );


$respuesta=null;

		
//$respuesta = $vendedor->getCodVendedor(8);

//$prueba = $ruta->getRutas();

//$prueba= $vendor->getVendedores();

//var_dump($reporte);

//$respuesta = $reporte->getFacturas(527);


$respuesta= $reporte->getreporte();

       
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


echo json_encode($respuesta);