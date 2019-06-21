/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function activeDesactiveMembresia (id){
 form = $("#active_membresia");
   $("#id").val(id);
            var membresia=$('#membresia_status-'+id);

    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize()
    }).done(function (data) {
        if (data==="1") {
          membresia.removeClass('badge-danger');
           membresia.addClass('badge-success');       
           membresia.text("activo");
    }else{
          membresia.removeClass('badge-success');
           membresia.addClass('badge-danger');
               membresia.text("inactivo");

    }
    })

            .fail(function (data) {
                console.log(data);
            });
   
}

function getEstadoPais(id_pais){
     var optVal= $("#pais option:selected").val();

 form = $("#form_estado");
   $("#id_pais").val(optVal);
    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize()
    }).done(function (data) {

        if (data) {
        var e=$("#estado"); 
        e.empty();    
$.each(data, function( index, value ) {
         e.append("<option  value="+value.id+">"+value.nombre+" </option");
});            

    
    }
    })

            .fail(function (data) {
                console.log(data);
            });

}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    }
}


function showPosition(position) {
     form = $("#form_pais");
        $("#lat").val(position.coords.latitude);
        $("#lon").val(position.coords.longitude);
        $.ajax({
             type: "POST",
         url: form.attr('action'),
           data: form.serialize()
    }).done(function (data) {
  var  register=$("#register");
   
    $("<input name='lat' value="+position.coords.latitude+" >").attr('type','hidden').appendTo(register);
    $("<input name='lon' value="+position.coords.longitude+" >").attr('type','hidden').appendTo(register);

        $("#pais").val(data.pais.id);
        
          getEstadosPromise(data.pais.id).done(function (estado) {
        if (estado) {
        var e=$("#estado"); 
        e.empty();    
                $.each(estado, function( index, value ) {
                  e.append("<option  value="+value.id+">"+value.nombre+" </option");
                });  
        $("#estado").val(data.estado.id);

    }

          });
    });

 
}



function getEstadosPromise(id_pais) {
    form = $("#form_estado");
   $("#id_pais").val(id_pais);
    var request = $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize()
    });
    return request;
}





function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
                        console.log(error);

            break;
        case error.POSITION_UNAVAILABLE:
        
           console.log(error);
            break;
        case error.TIMEOUT:
           
            console.log(error);
            break;
        case error.UNKNOWN_ERROR:
            console.log(error);
            break;
    }
}

$(window).on('load', function(){ 
getLocation();    

});
    
