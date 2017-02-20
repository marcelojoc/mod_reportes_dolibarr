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

		$sql= "SELECT 
			soc.rowid,
            soc.code_client, 
            soc.nom, 
            soc.address ,  
            extra.ruta1
            FROM 
                llx_societe AS soc , 
                llx_societe_extrafields AS extra 
            WHERE  
                soc.rowid = extra.fk_object   AND extra.vendedor='".$codVendedor."' 
            ORDER BY soc.nom ASC";




		$resql= $this->db->query($sql); // hago la consulta

		$this->db->begin();
			$resql= $this->db->query($sql); // hago la consulta

			if ($resql) {     //  verifico que se hizo
				$numrows = $this->db->num_rows($resql);

				while ($obj = $this->db->fetch_object($resql)) {


						$datos[]= array('rowid'=>$obj->rowid, 
										'codigo'=>$obj->code_client, 
										'nombre'=>$obj->nom, 
										'direccion'=>$obj->address 
						); 
							
				}

				return $datos;

				$this->db->free($resql);

			} else {
				$this->errors[] = 'Error ' . $this->db->lasterror();
				dol_syslog(__METHOD__ . ' ' . join(',', $this->errors), LOG_ERR);

				return -1;
			}

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
