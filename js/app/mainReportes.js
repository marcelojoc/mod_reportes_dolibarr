(function(){

	$("#btnPrint").addClass('disabled');
	$("#search_btn").on('click', function(e){

	e.preventDefault();

	var fecha_ini = $('#fecha_inicio').val();
	var fecha_fin = $('#fecha_fin').val();
	if (fecha_ini != "" && fecha_fin != ""){


		var vendedor  = $('#selVendedor').val();
		var producto  = parseInt($('#selProducto').val());
		var nombre    = $('#selVendedor  option:selected').html();
		var prod_name = $('#selProducto  option:selected').html();
		var ruta      = $('#ruta').val();

		var data= {
			inicio  :  fecha_ini,
			fin     :  fecha_fin,
			producto:  producto,
			vendedor:  vendedor,
			nombre  :  nombre,
			prod_name  :  prod_name,
			ruta       : ruta
		}

		get_reporte(data);
		$("#btnPrint").removeClass('disabled');

	}else{

		alert('No especifico los campos de fecha');

	}

})



$("#btnPrint").on('click', function(e){


	$("#btnPrint").addClass('disabled');

})




	$("a[href='#top']").on('click', function() {
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});


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

							localStorage.removeItem('tabla_venta');
							localStorage.setItem('tabla_venta', JSON.stringify(json));
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

			$('#table_body tr').remove();
				for (var i =0 ; i < datos.length; i++)
				{
					
						// fila de la tabla con los datos modificados
						var lista=  " <tr><td>" + datos[i]['codigo'] + "</td><td>" + datos[i]['nombre'] + "</td><td>" 
						+ datos[i]['direccion'] + "</td><td> $ " + datos[i]['importe'] 
						+ " ( % "+  porcentaje( parseFloat(totales['total_importe']), parseFloat(datos[i]['importe'])) +")"
						+ "</td><td>" + datos[i]['cantidad'] +" ( % " + porcentaje( totales['total_prod'] ,datos[i]['cantidad']) + ") </td><td> "
						+ datos[i]['ultimaFactura']+"   </td><td>"+ datos[i]['ruta'] +"</td> </tr>"

						$('#table_body').append(lista.replace('null', 'Sin registro'));

				}


			var total_tabla = "  <tr> <td colspan='3'> <b> TOTAL </b></td> <td> $ "+ totales['total_importe'] +"</td><td>"+ totales['total_prod'] +"</td><td></td></tr> "
								
			$('#table_body').append(total_tabla);

			var clientes_con_ventas= "Total Clientes <span class='label label-default'>"+ totales['total_clientes']
			clientes_con_ventas+= "</span> -  Clientes con ventas <span class='label label-default'>"+ totales['clientes_con_ventas'];
			clientes_con_ventas+= "</span> - Clientes sin ventas <span class='label label-default'>"+ totales['clientes_sin_ventas']+"</span>"

			$('#resumen_clientes').html("");
			$('#resumen_clientes').html(clientes_con_ventas);


	}


	function porcentaje( valorTotal, valor2)
	{
		var result = (valor2 * 100) / valorTotal;

		return result.toFixed(2);

	}

