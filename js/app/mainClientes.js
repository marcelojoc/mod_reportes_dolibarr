

var params = {


init: function(){

    params.beginComponents();   
    params.update();
},

data:{


    fechaIni:"",
    fechaFin:"",
    ruta: "0",
    idVendedor: "0",
	selector: '1'
},

	update: function(){

			// cada evento que sucede en los componentes actualizo mi modelo


			if (params.validate()){   // valido que los campos esten completos

				$('#search_btn').attr("disabled", false);
			}else{

				$('#search_btn').attr("disabled", true);
			}




	},

    beginComponents: function(){

        // disparo los eventos para cada componente  

        // $('#fecha_inicio, #fecha_fin').on('change click', function(){

        //     params.data.fechaIni= $('#fecha_inicio').val();
        //     params.data.fechaFin= $('#fecha_fin').val();                        
        // });

        $('#search_btn').on('click', function(e){

            e.preventDefault(); // detengo el proceso del boton por defecto

                if(params.validate()){

                        
						if(params.data.selector == "1"){

							$('#text_table').text('Comprobantes');
						}else{

							$('#text_table').text('Bultos');

						}

                        getComprobanteClientes(params.data);

                }else{

                        console.log('error de validacion')
                }    

            params.update();                             
        });

        $('#ruta').on('change click', function(){

            params.data.ruta= $(this).val();
            params.update();                        
        });

        $('#selVendedor').on('change, click', function(){

            params.data.idVendedor= $(this).val();
            params.update();                       
        });


        $('.input-daterange').datepicker()
            .on('changeDate', function(e) {
            
            params.data.fechaIni= $('#fecha_inicio').val();
            params.data.fechaFin= $('#fecha_fin').val();  
            params.update();

        });

		$( "input[name=opciones]:radio" ).on('change', function(){

            params.data.selector= $(this).val();
            params.update();                       
        });


    },


validate: function(){

    var resul = false;
    if(this.data.fechaFin != "" && this.data.fechaIni != "" ){

            result= true;
    }else{

            result= false;
    }

    return result;

}

};




// disparo la funcion de inicio

$(function() {
  // Handler for .ready() called.

  params.init();

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

});



var getComprobanteClientes= function( valor){

			$.ajax(
					{
					url : 'clientes.query.php',
					type: "POST",
					data : {
							consulta: 'get_valProduct',
							dato    : valor
							},
					dataType: 'JSON',

					success : function(json) {

							localStorage.removeItem('tabla_cliente');
							localStorage.setItem('tabla_cliente', JSON.stringify(json));
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



var cargarTabla = function(datos){

			$('#table_body tr').remove();
				for (var i =0 ; i < datos.length; i++)
				{
					
						// fila de la tabla con los datos modificados
						var lista=  " <tr><td>" + datos[i]['codigo'] + "</td><td>" + datos[i]['nombre'] + "</td><td>" 
						+ datos[i]['direccion'] + "</td><td>"+ datos[i]['localidad']+"</td><td>" + datos[i]['comprobantes'] +"</td><td> "
						+ datos[i]['ruta'] +"   </td> </tr>"

						$('#table_body').append(lista.replace('null', 'Sin registro'));

				}


			//var total_tabla = "  <tr> <td colspan='3'> <b> TOTAL </b></td> <td> $ "+ totales['total_importe'] +"</td><td>"+ totales['total_prod'] +"</td><td></td></tr> "
								
			//$('#table_body').append(total_tabla);






}