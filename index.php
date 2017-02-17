<?php
// Change this following line to use the correct relative path (../, ../../, etc)
$res=0;
if (! $res && file_exists("../main.inc.php")) $res=@include '../main.inc.php';					// to work if your module directory is into dolibarr root htdocs directory
if (! $res && file_exists("../../main.inc.php")) $res=@include '../../main.inc.php';			// to work if your module directory is into a subdir of root htdocs directory
if (! $res && file_exists("../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../dolibarr/htdocs/main.inc.php';     // Used on dev env only
if (! $res && file_exists("../../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../../dolibarr/htdocs/main.inc.php';   // Used on dev env only
if (! $res) die("Include of main fails");

dol_include_once('/reportes/class/productos.class.php');
dol_include_once('/reportes/class/tercero.class.php');
// importaciones de el modulo





$morejs=array("/reportes/js/datepicker/bootstrap-datepicker.min.js" , 
              "/reportes/js/spin/spin.min.js" );


$morecss=array("/reportes/css/datepicker/bootstrap-datepicker.css" , 
                "/reportes/css/style.reportes.css"
                 );


llxHeader('','Modulo Descuentos','','','','',$morejs,$morecss,0,0);

 //dol_fiche_head(); // encabezado de la ficha de dolibarr
 //var_dump($_SESSION);


    $user = new Tercero ($db); // verifico quen es el que esta ingresando al mcrypt_module_open


    $dato_usuario= $user->getPermiso($_SESSION['dol_login']);

    $_SESSION['codVendedor']= $dato_usuario->codVendedor;




    $productos = new My_Productos($db);

 





 ?>


 <!-- Page Content -->
    <div class="container-fluid " id="foo">


<div class="row">


    <h3>Reportes </h3> <hr>
</div>

    <div class="row">


        <div class="col-md-6" id="sandbox-container">

            <div class="form-group">
            <label class="col-md-2 control-label" for="selectbasic">Fechas</label>
            <div class="col-md-10">

                    <div class="input-daterange input-group" id="datepicker">
                        <input type="text" class="input-sm form-control" name="start" id="fecha_inicio" />
                        <span class="input-group-addon">al</span>
                        <input type="text" class="input-sm form-control" name="end" id="fecha_fin"/>
                    </div>

            </div>
            </div>

        </div>



        <div class="col-md-4 col-md-offset-2">
            <!--<button type="button" class="btn btn-primary btn-block">Primary</button>-->

        </div>


    </div>

    <hr>




<div class="row">



    <div class="col-md-5">


        <div class="form-group">
        <label class="col-md-2 control-label" for="selVendedor">Vendedor</label>
        <div class="col-md-10">
            <select id="selVendedor" name="selVendedor" class="form-control">

        <?php
                if($dato_usuario['codVendedor'] == -1 )
                {   

                        // el parametro -1 indica permiso para ver tdods los usuarios

                        $vendedores= $user->getVendedores();

                        foreach($vendedores as $vendedor)
                        {

                            print'<option value="'.$vendedor['rowid'].'">'.$vendedor ['nombre'] .' '. $vendedor ['apellido'] .'</option>';

                        }

                }
                else
                {

                          print'<option value="'.$dato_usuario['rowid'].'">'.$dato_usuario ['nombre'] .' '. $dato_usuario ['apellido'] .'</option>';

                }


        ?>

            </select>
        </div>
        </div>

    </div>

    <div class="col-md-5">
        

        <div class="form-group">
        <label class="col-md-2 control-label" for="selProducto">Producto</label>
        <div class="col-md-10">
            <select id="selProducto" name="selProducto" class="form-control">

            <?php
                    $prod = $productos->getProducts();

                    if( $prod != -1) // si no tiene nada  no imprime
                    {
                            foreach ($prod as $producto)
                            {

                                print'<option value="'.$producto['id'].'">'.$producto ['producto'].'</option>';

                            }

                    }

            ?>
            </select>

        </div>
        </div>

     </div>





        <div class="col-md-2">

        <button type="button" class="btn btn-primary btn-block" id="search_btn">Buscar</button>
        </div>

<br>
<br>
<br>
</div>










<div class="row segundo" >

                    <div class="panel panel-default">
                    <div class="panel-heading">Reporte Nombre vendedor</div>
                    <div class="panel-body">




               
                            
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Cliente</th>
                            <th>Domicilio</th>
                            <th>Importe</th>
                            <th>Cantidad</th>
                            <th>Ultima Compra</th>


                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>3343</td>
                            <td>Carlos pepeeeeeeeeeeeee</td>
                            <td>avenida </td>
                            <td>12334 (16.3%)</td>
                            <td>1324 (12.5%)</td>
                            <td>21/01/2017</td>
                        </tr>

                        </tbody>
                    </table>

                   
                        




                    </div>
                    </div>




</div>

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->



<script>

    $('#sandbox-container .input-daterange').datepicker({
    format: "dd/mm/yyyy",
    todayBtn: true,
    language: "es",
    daysOfWeekDisabled: "0",
    daysOfWeekHighlighted: "6",
    autoclose: true
});
</script>


 <?php



//dol_fiche_end();  // Cierre  de la ficha de dolibarr


$db->close();

?>

<script src="js/app/mainReportes.js"></script>