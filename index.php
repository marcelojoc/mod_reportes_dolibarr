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
dol_include_once('/reportes/class/vendedor.class.php');
dol_include_once('/reportes/class/ruta.class.php');
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
    $fecha = date("d/m/Y");                  // fecha actual en campo hidden para limitar el datepicker



 ?>


 <!-- Page Content -->
    <div class="container-fluid " id="cont_principal">


            <div class="row">
                <h3>Reportes por Monto</h3> <hr>
            </div>

            <div class="row">


                    <div class="col-md-6" id="sandbox-container">
                        <input type="hidden" name="hiddenDate" id="hiddenDate" value= "<?php print $fecha ; ?>">
                        <div class="form-group">
                        <label class="col-md-2 control-label" for="selectbasic">Fechas</label>
                        <div class="col-md-10">

                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" name="start" id="fecha_inicio" />
                                    <span class="input-group-addon">al</span>
                                    <input type="text" class="input-sm form-control" name="end" id="fecha_fin" data-date-end-date="0d" />
                                </div>

                        </div>
                        </div>

                    </div>

                    <div class="col-md-3">


                        <label class="col-md-2 control-label" for="selProducto">Ruta</label>
                        <div class="col-md-10">
                            <select id="ruta" name="ruta" class="form-control btn-block" >
                                <option value="0"> Todas las rutas</option>
                                <option value="1"> Ruta 1 Lunes</option>
                                <option value="2"> Ruta 2 Martes</option>
                                <option value="3"> Ruta 3 Miercoles</option>
                                <option value="4"> Ruta 4 Jueves</option>
                                <option value="5"> Ruta 5 Viernes</option>
                                <option value="6"> Ruta 6 Sabado</option>

                            </select>

                        </div>
                    </div>


                    <div class="col-md-3">

                        <a class="btn btn-info  btn-block " id= "btnPrint" href="printTable.php" target="_blank" >Imprimir PDF</a>
                    
                
                            <!--<button class="btn btn-warning  dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Large button <span class="caret"></span>
                            </button>-->
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
                                print'<option value="0">Todos los Vendedores</option>';
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
                                    print'<option value="0">Todos los Productos</option>';
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



</div>






<div class="row " id="content_table" >

                    <div class="panel panel-default">
                    <div class="panel-heading">Reporte Ventas</div>
                    <div class="panel-body">
               
                     <h3 id= "resumen_clientes"></h3>

                     <br>


                    <table class="table table-bordered table-responsive table-striped table-condensed text-center" id= "table_complete" >
                        <thead>
                        <tr>
                            <th>Vendedor</th>
                            <th>Codigo</th>
                            <th>Cliente</th>
                            <th>Domicilio</th>
                            <th>Localidad</th>
                            <th>Importe</th>
                            <th>Cantidad</th>
                            <th>Comprobante</th>
                            <th>Ultima Compra</th>
                            <th>Ruta</th>

                        </tr>
                        </thead>
                        <tbody id="table_body">










                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-12 text-center">

                             <a href="#" id="top" class="scroll-repo" alt= "ir arriba"><span class="glyphicon glyphicon-chevron-up btn-lg" aria-hidden="true"></span></a>

                        </div>
                    </div>
                    
                    </div>
                    </div>

</div>

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; TMS group 2017</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->



<script>

    var fechaActual = $('#hiddenDate').val();
    $('#sandbox-container .input-daterange').datepicker({
    format: "dd/mm/yyyy",
    endDate: fechaActual,
    todayHighlight: true,
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