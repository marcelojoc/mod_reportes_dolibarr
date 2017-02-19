<?php
include_once DOL_DOCUMENT_ROOT .'vendedor.class.php';
/*

En esta serie de lclases vamos a necesitar aproximadamente 3

reportes, que sera la encargada de generar todas las consultas de los Reportes

terceros que sera la encargada de cargar los datos de vendedor y rart las listas de cleintes correspondientes

productos que  solos e encarga de traer los productos 

completos y extendida para algunos datos mas.

*/



class Reportes 
{
    var $db;      // instancia de conexion
	var $id_usuario; // el identificador del usuario (vendedores)
	var $codVendedor;  // codigo de vendedor

	var $fecha_ini;   // fecha de inicio rango de fecha
	var $fecha_fin;   // fecha de fin de rango  para consultas
	var $producto;     // codigo de referencia del producto 


	function __construct($db, $id_usuario, $fecha_ini, $fecha_fin, $producto )
	{
		$this->db = $db;
        $this->id_usuario = $id_usuario;
        $this->fecha_ini= $fecha_ini;
        $this->fecha_fin= $fecha_fin;		
        $this->producto= $producto;
		$vendedor = new Vendedor($this->db, $this->id_usuario);
		$this->codVendedor = $vendedor->getCodVendedor($id_usuario);
	}





// metodos



function getClientes()  //trae los clientes correspondientes al vendedor
{

$sql="	                SELECT  llx_societe.code_client, 
                        llx_societe.rowid , 
                        llx_societe.nom, llx_societe.address

                        FROM    llx_societe, llx_societe_extrafields
                        WHERE   llx_societe_extrafields.vendedor = " .$this->codVendedor."
                        AND     llx_societe.rowid = llx_societe_extrafields.fk_object
                        ORDER BY code_client ASC";

        $this->db->begin();
        $resql = $this->db->query($sql);

        if ($resql)
        {
            $num = $this->db->num_rows($resql);
            $i = 0;
            if ($num)
            {
                    while ($i < $num)
                    {
                            $obj = $this->db->fetch_object($resql);
                            if ($obj)
                            {
                                    // You can use here results
                                    $respuesta[]= array(
										'rowid'=> $obj->rowid,
                                        'code_client'=> $obj->code_client,
                                        'nom'=>$obj->lastname,
                                        'address'=> $obj->address
                                    );
                            }
                            $i++;
                    }
            }
        }else{ $respuesta = 'hay un error en la conexion';}

        $this->db->commit();

        return  $respuesta;




}








}