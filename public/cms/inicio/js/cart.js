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
                    
                    $("#bloqueo").hide();
                    Swal.fire({
                        title: 'Exito',
                        text: "El presupuesto se ha enviado correctamente",
                        type: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick:false,
                        allowEscapeKey:false
                    }).then((result) => {
                        if (result.value) {
                            var a = document.createElement("a");                            
		a.target = "_blank";
		a.href = URL_PROJECT + '/shopping-cart/cart-report';
		a.click();
                            window.location.href = window.origin
                        }
                    });
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
