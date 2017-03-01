<?php

class Tercero 

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





public function getPermiso($login)  // devuelve los datos del usuatio que accede al area de reportes
{

         $sql= "SELECT u.rowid, u.firstname, u.lastname, extra.codvendedor  FROM 
         llx_user_extrafields AS extra, llx_user AS u WHERE 
         
         u.login='".$login."' AND u.rowid = extra.fk_object";

        $this->db->begin();
        $resql= $this->db->query($sql); // hago la consulta

		if ($resql) {     //  verifico que se hizo
			$numrows = $this->db->num_rows($resql);

			while ($obj = $this->db->fetch_object($resql)) {


					$datos= array('rowid'=>$obj->rowid, 'nombre'=>$obj->firstname, 'apellido'=>$obj->lastname, 'codVendedor'=>$obj->codvendedor ); 
                    	
			}

			return $datos;

			$this->db->free($resql);

		} else {
			$this->errors[] = 'Error ' . $this->db->lasterror();
			dol_syslog(__METHOD__ . ' ' . join(',', $this->errors), LOG_ERR);

			return -1;
		}

}






public function getVendedores()  // me trae todos los vendedores activos 
{

		$sql= "SELECT u.rowid, u.firstname, u.lastname, extra.codvendedor FROM 
		llx_user_extrafields AS extra, llx_user AS u 
		WHERE u.rowid = extra.fk_object ORDER BY extra.codvendedor ASC";

		$resql= $this->db->query($sql); // hago la consulta

		$this->db->begin();
			$resql= $this->db->query($sql); // hago la consulta

			if ($resql) {     //  verifico que se hizo
				$numrows = $this->db->num_rows($resql);

				while ($obj = $this->db->fetch_object($resql)) {


						$datos[]= array('rowid'=>$obj->rowid, 'nombre'=>$obj->firstname, 'apellido'=>$obj->lastname, 'codVendedor'=>$obj->codvendedor ); 
							
				}

				return $datos;

				$this->db->free($resql);

			} else {
				$this->errors[] = 'Error ' . $this->db->lasterror();
				dol_syslog(__METHOD__ . ' ' . join(',', $this->errors), LOG_ERR);

				return -1;
			}

}



public function getClienteAsociado($codVendedor)
{


if ($codVendedor != 0)
{

	$sql="	SELECT  llx_societe.code_client, 
				llx_societe.rowid , 
				llx_societe.nom, llx_societe.address

				FROM    llx_societe, llx_societe_extrafields
				WHERE   llx_societe_extrafields.vendedor = " .$codVendedor."
				AND     llx_societe.rowid = llx_societe_extrafields.fk_object
				ORDER BY code_client desc";

}else{


	$sql= " SELECT  llx_societe.code_client, 
		llx_societe.rowid , 
		llx_societe.nom, llx_societe.address
		FROM    llx_societe WHERE  llx_societe.status = 1
		ORDER BY code_client DESC";


}






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






 	public function getCodVendedor($idVendedor)  // a partir de id de Uusario  este metodo devuelve el numero de vendedor del 1 al 5 
	 
	{

         $sql= "SELECT u.firstname, u.lastname, extra.codvendedor FROM 
         llx_user_extrafields as extra, llx_user as u WHERE 
         u.rowid= ". $idVendedor." AND  
         extra.fk_object = u.rowid";


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
						$respuesta = $obj->codvendedor ;
				}

            }
        }else{

            $respuesta = 'Sin Vendedor Asignado';
        }


        return  $respuesta;

	}



}
