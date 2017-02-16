<?php
// Change this following line to use the correct relative path (../, ../../, etc)
$res=0;
if (! $res && file_exists("../main.inc.php")) $res=@include '../main.inc.php';					// to work if your module directory is into dolibarr root htdocs directory
if (! $res && file_exists("../../main.inc.php")) $res=@include '../../main.inc.php';			// to work if your module directory is into a subdir of root htdocs directory
if (! $res && file_exists("../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../dolibarr/htdocs/main.inc.php';     // Used on dev env only
if (! $res && file_exists("../../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../../dolibarr/htdocs/main.inc.php';   // Used on dev env only
if (! $res) die("Include of main fails");




$morejs=array("/reportes/js/datepicker/bootstrap-datepicker.min.js" );
$morecss=array("/reportes/css/datepicker/bootstrap-datepicker.css" );




llxHeader('','Modulo Descuentos','','','','',$morejs,$morecss,0,0);

 //dol_fiche_head(); // encabezado de la ficha de dolibarr
 //var_dump($_SESSION);

 unset($_SESSION['dataPrint']);
 unset($_SESSION['vendorPrint']);






 ?>


 <!-- Page Content -->
    <div class="container-fluid">


<div class="row">


    <h3>Reportes </h3> <hr>
</div>

    <div class="row">


        <div class="col-md-5">

            <div class="form-group">
            <label class="col-md-2 control-label" for="selectbasic">Fechas</label>
            <div class="col-md-10">

                    <div class="input-daterange input-group" id="datepicker">
                        <input type="text" class="input-sm form-control" name="start" />
                        <span class="input-group-addon">to</span>
                        <input type="text" class="input-sm form-control" name="end" />
                    </div>

            </div>
            </div>

        </div>



        <div class="col-md-5 col-md-offset-2">
            <!--<button type="button" class="btn btn-primary btn-block">Primary</button>-->

        </div>


    </div>

    <hr>




<div class="row">



    <div class="col-md-5">


        <div class="form-group">
        <label class="col-md-2 control-label" for="selectbasic">Vendedor</label>
        <div class="col-md-10">
            <select id="selectbasic" name="selectbasic" class="form-control">
            <option value="1">Option one</option>
            <option value="2">Option two</option>
            </select>
        </div>
        </div>

    </div>

    <div class="col-md-5">
        

        <div class="form-group">
        <label class="col-md-2 control-label" for="selectbasic">Producto</label>
        <div class="col-md-10">
            <select id="selectbasic" name="selectbasic" class="form-control">
            <option value="1">Option one</option>
            <option value="2">Option two</option>
            </select>
        </div>
        </div>

     </div>





        <div class="col-md-2">

        <button type="button" class="btn btn-primary btn-block">Buscar</button>
        </div>

<br>
<br>
<br>
</div>










<div class="row">

                    <div class="panel panel-default">
                    <div class="panel-heading">Reporte Nombre vendedor</div>
                    <div class="panel-body">




               
                            
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                        </tr>
                        <tr>
                            <td>Mary</td>
                            <td>Moe</td>
                            <td>mary@example.com</td>
                        </tr>
                        <tr>
                            <td>July</td>
                            <td>Dooley</td>
                            <td>july@example.com</td>
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
    language: "es",
    daysOfWeekDisabled: "0",
    daysOfWeekHighlighted: "6"
});
</script>


 <?php



//dol_fiche_end();  // Cierre  de la ficha de dolibarr


$db->close();

?>