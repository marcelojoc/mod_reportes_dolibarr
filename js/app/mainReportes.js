(function(){

$("#search_btn").on('click', function(e){

e.preventDefault();

var fecha_ini = $('#fecha_inicio').val();
var fecha_fin = $('#fecha_fin').val();
var vendedor  = $('#selVendedor').val();
var producto  = $('#selProducto').val();
var data= {
            inicio  :  fecha_ini,
            fin     :  fecha_fin,
            producto:  producto,
            vendedor:  vendedor
          }

get_reporte(data);

})


opts = {
  lines: 13 // The number of lines to draw
, length: 28 // The length of each line
, width: 10 // The line thickness
, radius: 42 // The radius of the inner circle
, scale: 0.25 // Scales overall size of the spinner
, corners: 1 // Corner roundness (0..1)
, color: '#000' // #rgb or #rrggbb or array of colors
, opacity: 0.25 // Opacity of the lines
, rotate: 0 // The rotation offset
, direction: 1 // 1: clockwise, -1: counterclockwise
, speed: 1 // Rounds per second
, trail: 60 // Afterglow percentage
, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
, zIndex: 2e9 // The z-index (defaults to 2000000000)
, className: 'spinner' // The CSS class to assign to the spinner
, top: '49%' // Top position relative to parent
, left: '56%' // Left position relative to parent
, shadow: false // Whether to render a shadow
, hwaccel: false // Whether to use hardware acceleration
, position: 'absolute' // Element positioning
}
target = document.getElementById('cont_principal')
spinner = new Spinner(opts);


// $(window).scroll(function(){
//             if ($(this).scrollTop() > 100) {
//                 $('.scrollup').fadeIn();
//             } else {
//                 $('.scrollup').fadeOut();
//             }
//         });
  
//         $('.scrollup').click(function(){
//             $("html, body").animate({ scrollTop: 0 }, 600);
//             return false;
//         });




// funciones ajax


function get_reporte(parametro= null){

		
		$.ajax(
				{
				url : 'reportes.query.php',
				type: "POST",
				data : {
						consulta: 'get_valProduct',
						dato    : parametro
						},
				dataType: 'JSON',

				success : function(json) {

                        cargarTabla(json);
				},

				error : function(xhr, status) {
					alert('Disculpe, existió un problema ');
					//location.reload(true);
                    //alert('Disculpe, existió un problema '+ status + xhr );

				},

                beforeSend: function(){
                // Code to display spinner
                    
                    $('#content_table').addClass('opacidad');
                    spinner.spin(target)

                },

                complete: function(){
                // Code to hide spinner.
                    $('#content_table').removeClass('opacidad');
                    spinner.stop()
                }


		})

	}

})();



function cargarTabla(datos_json)
{

var datos= datos_json[0];
var totales = datos_json[1];

console.log(totales);

    $('#table_body tr').remove();
        for (var i =0 ; i < datos.length; i++)
        {
            
                // fila de la tabla con los datos modificados
                var lista=  " <tr><td>" + datos[i]['codigo'] + "</td><td>" + datos[i]['nombre'] + "</td><td>" 
                + datos[i]['direccion'] + "</td><td> $ " + datos[i]['importe'] 
                + " ( % "+  porcentaje( parseFloat(totales['total_importe']), parseFloat(datos[i]['importe'])) +")"
                + "</td><td>" + datos[i]['cantidad'] +" ( % " + porcentaje( totales['total_prod'] ,datos[i]['cantidad']) + ") </td><td> "
                + datos[i]['ultimaFactura']+"   </td></tr>"

                $('#table_body').append(lista.replace('null', 'Sin registro'));

        }


var totales = "  <tr> <td colspan='3'> <b> TOTAL </b></td> <td> $ "+ totales['total_importe'] +"</td><td>"+ totales['total_prod'] +"</td><td></td></tr> "
        				
$('#table_body').append(totales);
}


function porcentaje( valorTotal, valor2)
{

    var result = (valor2 * 100) / valorTotal;

    return result.toFixed(2);

}