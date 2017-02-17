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





public function getVendedor($id)
{

         $sql= "SELECT lastname, `firstname` FROM 
         `llx_user_extrafields`, `llx_user` WHERE 
         `codvendedor`=".$idVendedor."  AND  
         `llx_user_extrafields`.`fk_object`= `llx_user`.`rowid`";

//$this->db->begin();
 $resql= $this->db->query($sql); // hago la consulta

		if ($resql) {     //  verifico que se hizo
			$numrows = $this->db->num_rows($resql);

            $datos=array();
			while ($obj = $this->db->fetch_object($resql)) {


					$datos[]= array('producto'=>$obj->label, 'id'=>$obj->rowid, 'price'=> number_format($obj->price, 2, ',', '')); 
                    	
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






}
