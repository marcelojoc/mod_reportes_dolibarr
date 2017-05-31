(function(){


})();


var params = {

data:{


    fechaIni:"",
    fechaFin:"",
    ruta: "",
    idVendedor: ""
},

update: function(){

// cada evento que sucede en los componentes actualizo mi modelo



},

    beginComponents: function(){

    // disparo los eventos para cada componente  

    $('#fecha_inicio').on('focusout', function(){

        params.data.fechaIni= $(this).val();
                                
    });

    $('#fecha_fin').on('focusout', function(){

        params.data.fechaFin= $(this).val();
                                
    });

    $('#ruta').on('change, click', function(){

        params.data.idVendedor= $(this).val();
                                
    });


    }

}


var getValores = function(){





    alert('ejecutando get Valores');
}