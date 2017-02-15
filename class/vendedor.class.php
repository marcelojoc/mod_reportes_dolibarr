<?php


class Vendedor 
{
  var $idVendedor;
  

	public function __construct(DoliDB $db, $id = null, $admin=null)
	{
		$this->db = $db;
		$this->idVendedor = $id;
		return 1;
		
	}


	public function setIdVendedor( $idVendedor){

		$this->idVendedor = $idVendedor;

	}


	public function getIdVendedor(){

		return $this->idVendedor;
	}
 
 

 	public function getVendedor($idVendedor){

         $sql= "SELECT lastname, `firstname` FROM 
         `llx_user_extrafields`, `llx_user` WHERE 
         `codvendedor`=".$idVendedor."  AND  
         `llx_user_extrafields`.`fk_object`= `llx_user`.`rowid`";

            $this->db->begin();
            $resql = $this->db->query($sql);
        if ($resql)
        {
            $num = $this->db->num_rows($resql);
            $i = 0;
            if ($num)
            {

                            $obj = $this->db->fetch_object($resql);
                            if ($obj)
                            {
                                    // You can use here results
                                    $respuesta = $obj->lastname . " ". $obj->firstname;
                            }

            }
        }else{

            $respuesta = 'Sin Vendedor Asignado';
        }

        $this->db->commit();


        return  $respuesta;

	}
 


 // metodos para traer los vendedores


    function getVendedores (){

       
// SELECT `rowid`, `lastname`, firstname FROM `llx_user` WHERE llx_user.`admin` != 1


        $sql= "
        SELECT `lastname`, firstname, llx_user_extrafields.`codvendedor` FROM `llx_user`, `llx_user_extrafields` WHERE llx_user.`admin` != 1    
AND `llx_user_extrafields`.`fk_object`= `llx_user`.`rowid` 
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
                                        'idVendedor'=> $obj->codvendedor,
                                        'nom'=>$obj->lastname,
                                        'lastname'=> $obj->firstname
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