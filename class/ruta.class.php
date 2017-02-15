<?php


class Ruta 
{
  private $idRuta;
  private $idVendedor;

  // constructor

	public function __construct(DoliDB $db, $id = null)
	{
		$this->db = $db;
		$this->idRuta = $id;
		return 1;	
	}



// Set  and Get ruta
	public function setIdRuta( $idRuta){

		$this->idRuta = $idRuta;
	}
	public function getidRuta(){

		return $this->idRuta;
	}

// Set  and Get Vendedor  

    public function setIdVendedor( $idVendedor){

        $this->idVendedor = $idVendedor;

    }

    public function getVendedor(){

        return $this->idVendedor;
    }


// metodos de rutas


    public function getRutas (){

        $nombreRutaBd = 'ruta1';

        $sql= "
        SELECT 
            soc.code_client, 
            soc.nom, 
            soc.address ,  
            extra.".$nombreRutaBd."
            FROM 
                llx_societe AS soc , 
                llx_societe_extrafields AS extra 
            WHERE  
                soc.rowid = extra.fk_object  
                AND extra.ruta1 = ".$this->idRuta."
                AND extra.vendedor=". $this->idVendedor ." 
            ORDER BY soc.nom ASC
        ";


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
                                        'cod_client'=> $obj->code_client,
                                        'nom'=>$obj->nom,
                                        'adress'=> $obj->address,
                                        'ruta'=> $obj->ruta1,
                                    );
                            }
                            $i++;
                    }
            }
        }else{

            $respuesta = 'hay un error en la conexion';
        }

        $this->db->commit();


        return  $respuesta;


    }





    

}