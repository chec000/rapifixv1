/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function update() {
    var form = $('#updateLanguage');
    var request = $.ajax({
        url: form.attr('action'),
        data: form.serialize(),
        error: function(jqXHR, timeout, message) {
            var contentType = jqXHR.getResponseHeader("Content-Type");
            if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
                window.location.reload();
            }
        }
    });
    request.done(function(data) {
        console.log(data);
    });
    request.fail(function() {
        alert("fallo");
    });
}
