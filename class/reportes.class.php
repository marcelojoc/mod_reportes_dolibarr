<?php

/*

En esta serie de lclases vamos a necesitar aproximadamente 3

reportes, que sera la encargada de generar todas las consultas de los Reportes

terceros que sera la encargada de cargar los datos de vendedor y rart las listas de cleintes correspondientes

productos que sera una extencion de productos nativa de dolibarr, solos e encarga de traer los productos 

completos y extendida para algunos datos mas.

*/



class Reportes 
{
    var $db;      // instancia de conexion


	function __construct($db )
	{
		$this->db = $db;
        // $this->vendedor = $vendedor;
        // $this->hoy= $hoy;
        // $this->caja= $caja;
		//$this->reponse(null);
	}











}