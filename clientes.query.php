<?php
require_once '../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/reportes/class/reportes.class.php';
//require_once DOL_DOCUMENT_ROOT.'/reportes/class/tercero.class.php';
// validar acceso


// $consulta = GETPOST("consulta", "alpha");
// $datos     = GETPOST("dato", "alpha");


//var_dump($datos);

$consulta = $_POST["consulta"]; // recibir datos de metodo a ejecutar
$dato     =  $_POST["dato"];	// recibo un arreglo con los datos del formulario

// Separo cada dato enviado para instanciar el reporte
$id_usuario   = $dato['idVendedor'];
$fecha_ini    = $dato['fechaIni'];
$fecha_fin    = $dato['fechaFin'];
$nombre_vendedor = $dato['nombre'];
$id_producto = null;   // no interesa el producto  solo el comprobante
$ruta         = $dato['ruta'];


// var_dump($consulta);
 var_dump($dato);

$reporte   = new Reportes ($db, $id_usuario, $fecha_ini, $fecha_fin , $id_producto, $ruta );
//$reporte   = new Reportes ($db, 0, '02/11/2016', '20/02/2017' , 2 ,4);


$respuesta=null;