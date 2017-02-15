<?php

// Change this following line to use the correct relative path (../, ../../, etc)
$res=0;
if (! $res && file_exists("../main.inc.php")) $res=@include '../main.inc.php';					// to work if your module directory is into dolibarr root htdocs directory
if (! $res && file_exists("../../main.inc.php")) $res=@include '../../main.inc.php';			// to work if your module directory is into a subdir of root htdocs directory
if (! $res && file_exists("../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../dolibarr/htdocs/main.inc.php';     // Used on dev env only
if (! $res && file_exists("../../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../../dolibarr/htdocs/main.inc.php';   // Used on dev env only
if (! $res) die("Include of main fails");
// Change this following line to use the correct relative path from htdocs




require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/date.lib.php';
include_once(DOL_DOCUMENT_ROOT.'/core/class/html.formcompany.class.php');
dol_include_once('/Descuentos/class/vendedor.class.php');
dol_include_once('/Descuentos/class/ruta.class.php');

// Load traductions files requiredby by page
$langs->load("Descuentos");
$langs->load("other");

// Get parameters
$id			= GETPOST('id','int');  // id del vendedor que estas seleccionando
$ruta	= GETPOST('ruta','alpha');			// ruta que queremos ver


// Protection if external user
$socid=0;
if ($user->societe_id > 0)
{
    $socid = $user->societe_id;
	accessforbidden();
}

//$morejs = array("/descuentos/js/funciones.js");
$morecss = array("descuentos/css/descuentos.css");


 llxHeader('','Reporte Rutas','','','','','',$morecss,0,0); 

//llxHeader('','Modulo Descuentos','');

//dol_fiche_head();


$vendedores = new Vendedor($db);  //Nueva instancia de vendedor

$listado = $vendedores->getVendedores();  //trae todos los vendedores

$lista_clientes= "";						// variable para alnmacenar los clientes segun los parametros 


if($ruta== ""){

	$ruta= date("w");

}else{

	if(!is_numeric($ruta)){

		$ruta=1;

	}
}


	$rutas = new Ruta($db);
	if(isset($id) and $id!= ""){

		$rutas->setIdVendedor($id);
		$rutas->setIdRuta($ruta);


	}else{

		$rutas->setIdVendedor(0);
		$rutas->setIdRuta(0);
	}

	$lista_clientes= $rutas->getRutas();


?>


<style>


</style>

  <body>

    <div class="container-fluid">
	<div class="row">
		<div class="col-md-4">



<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id= "formRuta" class="form-horizontal"  role="form" autocomplete="off">

<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Seleccionar Ruta</label>
  <div class="col-md-4 ">

    <select id="ruta" name="ruta" class="form-control btn-block" onchange="cambioSelect()" >

	  <?php

	if($ruta <= 0){    // si es domingo te muestra la ruta de lunes

		$ruta= 1;
	}


	$dias = array('','Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');

	$limit = count($dias);
	$limit--;         // le saco el domingo
	$selected = "";  // para que quede la opcion seleccionada de a cuerdo al dia
		for ($i = 1; $i <= $limit ; $i++) {
			
			if($i == $ruta){

					$selected= "selected";
			}else{

					$selected= "";
			}
			
			echo '<option value="'. $i .'" '. $selected.'> Ruta '. $i .' '. $dias[$i] .'</option>';

		}

?>

 </select>   



  </div>
</div>


</form>


            <div class="list-group" id= "listVendedor">
            <a href="#" class="list-group-item disabled">
                Vendedores
            </a>



<?php


		foreach( $listado as $vendedor){

			echo('<a href="reportes.php?id='. $vendedor['idVendedor']  .'&ruta='. $ruta .'" class="list-group-item">'. $vendedor['nom'] . ' '. $vendedor['lastname'] . '</a>');

		}

?>


   




            </div>



		</div>
		<div class="col-md-8">




            <div class="panel panel-default">
                <div class="panel-heading">
					<h3 class="panel-title">Reporte de Rutas  
					
					<?php 
					
					echo $vendedores->getVendedor($id); 
					$_SESSION["vendorPrint"]= $vendedores->getVendedor($id);
					?> </h3>



						<a href="printTable.php" target="_blank" >	<span class="pull-right clickable "><i class="glyphicon glyphicon-print"></i> Imprimir </span></a>

				</div>
                <div class="panel-body">


<table class="table table-bordered table-hover" id="tableprint">
				<thead>
					<tr>
						<th>
							Cod Cliente
						</th>
						<th>
							Nombre
						</th>
						<th>
							Direccion
						</th>
						<th>
							Ruta
						</th>
					</tr>
				</thead>
				<tbody>
					
<?php

// compruebo las sessiones y la creo o regenero con los datos para el print

if(isset($_SESSION["dataPrint"])){

	unset($_SESSION["dataPrint"]);

}

	$_SESSION["dataPrint"]= $lista_clientes;






	if(isset($lista_clientes)){

		foreach( $lista_clientes as $cliente){

			//echo('<a href="reportes.php?id='. $vendedor['rowid']  .'" class="list-group-item">'. $vendedor['nom'] . ' '. $vendedor['lastname'] . '</a>');


			echo(

				'<tr><td>'.$cliente['cod_client'].'</td><td>'.$cliente['nom'].'</td><td> ' . $cliente['adress']. '</td><td> '. $cliente['ruta'].' </td></tr>'
			);


		}


	}



?>



				</tbody>
			</table>


                </div>
            </div>

		</div>
	</div>
</div>

   
    <script src="/dolibar_local/htdocs/descuentos/js/scriptReporte.js"></script>
  </body>
</html>


<?php

//echo('hoy es '.$valor);
    //dol_fiche_end();
?>


