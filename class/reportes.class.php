<?php
require_once ('tercero.class.php');
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
        $this->fecha_ini= $this->change_fecha($fecha_ini);
        $this->fecha_fin= $this->change_fecha($fecha_fin);		
        $this->producto= $producto;
		$tercero = new Tercero($this->db, $this->id_usuario);
		$this->codVendedor = $tercero->getCodVendedor($this->id_usuario);
	}





// metodos






function getReporte()
{

        $clientes = $this->getClientes();
        $dato= null;

        if($clientes != null)
        {

            foreach($clientes as $cliente)
            {

                $cantidades = $this->getFacturas($cliente['rowid']);

                $dato[]= array( "codigo" => $cliente['code_client'],

                "nombre" => $cliente['nom'],
                "direccion" => $cliente['address'],
                "importe" => $cantidades['valor'],
                "cantidad" => $cantidades['cantidad']

                );

            }


        }
        else{

            $dato= "No hay Clientes asignados";
        }

        return $dato;

}




















    function getClientes()  //trae los clientes correspondientes al vendedor
    {

    $sql="	SELECT  llx_societe.code_client, 
            llx_societe.rowid , 
            llx_societe.nom, llx_societe.address

            FROM    llx_societe, llx_societe_extrafields
            WHERE   llx_societe_extrafields.vendedor = " .$this->codVendedor."
            AND     llx_societe.rowid = llx_societe_extrafields.fk_object
            ORDER BY code_client ASC";

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
                                            'nom'=>$obj->nom,
                                            'address'=> $obj->address
                                        );
                                }
                                $i++;
                        }
                }
            }else{ $respuesta = 'hay un error en la conexion';}

            $this->db->free($resql);
            return  $respuesta;


    }



    function getFacturas($id_cliente)
    {

    $sql ="SELECT rowid, datef FROM llx_facture
    WHERE fk_soc = ".$id_cliente." AND  datef BETWEEN '".$this->fecha_ini."' AND '".$this->fecha_fin."' ORDER BY datef ASC ";

  
        $res = $this->db->query($sql);
        
        // si devuelve producto  entro al proceso
        if ($res){

            $num = $this->db->num_rows($res);

            $i = 0;
            if ($num)
            {
                $tmp_cantidad=0;
                $tmp_valor =0;

                    while ($i < $num)
                    {
                            $factura = $this->db->fetch_object($res);
                            if ($factura)
                            {

                        // llamar al metodo que traE las cantidades 
                     $dato= $this->getcantidadDetalle($factura->rowid);

                     
                     $tmp_cantidad= $tmp_cantidad +(int)$dato['cantidad'];
                     $tmp_valor = $tmp_valor + (float)$dato['valor'];
                                    
                            }
                            $i++;
                    }
            }


                $datos= ['cantidad'=> $tmp_cantidad,
                         'valor'=> $tmp_valor
                ];

                $this->db->free($res);
                return $datos;
        }

    }


function getcantidadDetalle($id_factura_detalle)

{


    $sql ="SELECT SUM(qty) AS productos, SUM(total_ht) AS valor FROM llx_facturedet WHERE fk_facture = ".$id_factura_detalle." AND fk_product= ".$this->producto;


        $res = $this->db->query($sql);
        $num = $this->db->num_rows($res);
        // si devuelve producto  entro al proceso
        if ($num){

            $obj = $this->db->fetch_object($res);
            if ($obj)
            {

                $datos= ['cantidad'=> $obj->productos,
                         'valor'=> $obj->valor
                ];
            }

            
        }

return $datos;
}





private function change_fecha($fecha)
{

    $dia = substr($fecha, 0, 2);
    $mes   = substr($fecha, 3, 2);
    $ano = substr($fecha, -4);
    // fechal final realizada el cambio de formato a las fechas europeas
    $fecha = $ano . '-' . $mes . '-' . $dia;

    return $fecha;

}




}