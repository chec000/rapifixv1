/* * * Funciones Genearales para Login * * */
$(document).ready(function() {
    /* Login Section */
    $('#btnFormLoginSection').on({
        click: function() {
            validateLoginSection();
        }
    });

    $('#btnCloseLoginSection').click(function() {
        cleanMessagesLogin('section');
    });

    /* Login Modal */
    $('#btnLoginShopping').on({
        click: function() {
            validateLoginShopping();
        }
    });

    $('#btnCloseLoginModal').click(function() {
        cleanMessagesLogin('modal');
    });

    /* Cerrar Sesión */
    $('#btnLogoutSection').click(function() {
        $('.loader').removeClass('hide').addClass('show');

        $.get(URL_PROJECT + '/login/logout', function (data) {
            if (data.success == true) {
                location.href = data.message;
            }
        });
    });
});

function validateLoginSection() {
    var url     = URL_PROJECT + '/login/auth';
    var form    = $('#formLoginSection');
    var tipo    = 'section';

    validateLogin(url, form, tipo);
}

function validateLoginShopping() {
    var url     = URL_PROJECT + '/login/auth';
    var form    = $('#formLoginShopping');
    var tipo    = 'modal';

    validateLogin(url, form, tipo);
}

function validateLogin(url, form, tipo) {
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'JSON',
        data: form.serialize(),
        statusCode: {
            419: function() {
                window.location.href = URL_PROJECT;
            }
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(data) {
            if (data.success == true) {
                location.href = data.message;
            }
            else if (data.success == false) {
                $.each(data.message, function(key, message) {
                    if (key == 'error_ws') {
                        $('#error_ws_' + tipo).show();
                        $('#error_ws_ul_' + tipo).append('<li>' + message + '</li>');
                    }
                    else {
                        addErrorMessageLogin(key, message, tipo);
                    }
                });
            }
        },
        beforeSend: function() {
            cleanMessagesLogin(tipo);
            $('.loader').removeClass('hide').addClass('show');
        },
        complete: function() {
            $('.loader').removeClass('show').addClass('hide');
        }
    });
}

function addErrorMessageLogin(key, message, tipo) {
    if (tipo == 'modal') {
        $('#' + key + '_modal').addClass('has-error');
        $('#div_' + key + '_modal').append(message);
    }
    else {
        $('#' + key).addClass('has-error');
        $('#div_' + key).append(message);
    }
}

function cleanMessagesLogin(tipo) {
    $('#error_ws_' + tipo).hide();
    $('#error_ws_ul_' + tipo).empty();
    $('.error-msg').empty();
    $('.has-error').removeClass('has-error');
}


/* * * Funciones Generales para Reset Password * * */
function validateStepResetPassword(url, form, step) {
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'JSON',
        data: form.serialize(),
        statusCode: {
            419: function() {
                window.location.href = URL_PROJECT;
            }
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(data) {
            if (data.success == true) {
                location.href = data.message;
            }
            else if (data.success == false) {
                $.each(data.message, function(key, message) {
                    addErrorMessageResetPassword(key, message);
                })

                $('.loader').removeClass('show').addClass('hide');
            }
            else if (data.success == 'errors_corbiz') {
                $('#error_ws_' + step).show();

                $.each(data.message, function(key, message) {
                    $('#error_ws_ul_' + step).append('<li>' + $.trim(message.messUser) + '</li>');
                });

                $('.loader').removeClass('show').addClass('hide');
            }
        },
        beforeSend: function() {
            cleanMessagesResetPassword(step);
            $('.loader').removeClass('hide').addClass('show');
        }
    });
}

function addErrorMessageResetPassword(key, message) {
    $('#' + key).addClass('has-error');
    $('#div_' + key).append(message);
}

function cleanMessagesResetPassword(step) {
    $('#error_ws_' + step).hide();
    $('#error_ws_ul_' + step).empty();
    $('.error-msg').empty();
    $('.has-error').removeClass('has-error');
}