<?php
//require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';


class My_Productos 

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




public function getProducts()
{

//$this->db->begin();
 $resql= $this->db->query("SELECT * FROM llx_product WHERE tosell =1"); // hago la consulta

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

























}