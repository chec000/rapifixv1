$(function() {

    // Get the form.
    var form = $('#cart-form');

    // Get the messages div.
    var formMessages = $('.form-messege');

    // Set up an event listener for the contact form.
    $(form).submit(function(e) {
    
        // Stop the browser from submitting the form.
        e.preventDefault();
    $("#mensajeBloqueo").text("Enviando");

    $("#bloqueo").show();
        // Serialize the form data.
        var formData = $(form).serialize();

        // Submit the form using AJAX.
        $.ajax({
            type: 'GET',
            url: $(form).attr('action'),
            data: formData
        })
            .done(function(response) {
                // Make sure that the formMessages div has the 'success' class.
                $(formMessages).removeClass('error');
                $(formMessages).addClass('success');

                // Set the message text.
                $(formMessages).text(response);
        $("#bloqueo").hide();
swal({
  title: "Exito",
  text: "El presupuesto se ha enviado correctamente",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-success",
  confirmButtonText: "Aceptar",
  closeOnConfirm: false
}
);
                // Clear the form.
                $('#contact-form input,#contact-form textarea').val('');
            })
            .fail(function(data) {
             
                $(formMessages).removeClass('success');
                $(formMessages).addClass('error');

                if (data.responseText !== '') {
                    $(formMessages).text(data.responseText);
                } else {
                    $(formMessages).text('Oops! An error occured and your message could not be sent.');
                }
  $("#bloqueo").hide();
            });
    });

});
