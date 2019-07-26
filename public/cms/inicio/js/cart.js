$(function () {

    // Get the form.
    var form = $('#cart-form');

    // Get the messages div.
    var formMessages = $('.form-messege');

    // Set up an event listener for the contact form.
    $(form).submit(function (e) {

        // Stop the browser from submitting the form.
        e.preventDefault();
        $("#mensajeBloqueo").text("Enviando");

        $("#bloqueo").show();
        // Serialize the form data.
        var formData = $(form).serialize();
     
        $.ajax({
            type: 'GET',
            url: $(form).attr('action'),
            data: formData
        })
                .done(function (response) {     
                    var json=JSON.stringify(response);
            if(json!==false){
                        $("#bloqueo").hide();
                    Swal.fire({
                        title: 'Exito',
                        text: "El presupuesto se ha enviado correctamente",
                        type: 'success',
                         html:    
                        '<a href='+response.archivo.replace(/['"]+/g, '')+'  download="orden">Descargar orden</a> ',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick:false,
                        allowEscapeKey:false
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = window.origin;
                        }
                    });
            }
            
                })
                .fail(function (data) {

                    $("#bloqueo").hide();
                    swal({
                        title: "Error",
                        text: "Ha existido un error, favor de comunicarse con el administrador.",
                        type: "danger",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    });

                });
    });

});
