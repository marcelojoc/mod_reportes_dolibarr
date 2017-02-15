<?php
// Change this following line to use the correct relative path (../, ../../, etc)
$res=0;
if (! $res && file_exists("../main.inc.php")) $res=@include '../main.inc.php';					// to work if your module directory is into dolibarr root htdocs directory
if (! $res && file_exists("../../main.inc.php")) $res=@include '../../main.inc.php';			// to work if your module directory is into a subdir of root htdocs directory
if (! $res && file_exists("../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../dolibarr/htdocs/main.inc.php';     // Used on dev env only
if (! $res && file_exists("../../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../../dolibarr/htdocs/main.inc.php';   // Used on dev env only
if (! $res) die("Include of main fails");

$morejs=array("/mimomulo/js/monmodule.js");
llxHeader('','Modulo Descuentos','','','','',$morejs,'',0,0);

 dol_fiche_head(); // encabezado de la ficha de dolibarr
 var_dump($_SESSION);
print('tu vieja');

dol_fiche_end();  // Cierre  de la ficha de dolibarr

?>