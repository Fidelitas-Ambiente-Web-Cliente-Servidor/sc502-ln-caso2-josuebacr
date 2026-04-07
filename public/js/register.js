$(document).ready(function () {
    $('#formRegister').on('submit', function (e) {
        e.preventDefault();

        var username = $('#username').val().trim();
        var password = $('#password').val().trim();

        if (!username || !password) {
            mostrarMensaje('warning', 'Usuario y contraseña son obligatorios');
            return;
        }

        $.ajax({
            url: 'index.php',
            method: 'POST',
            dataType: 'json',
            data: {
                option: 'register',
                username: username,
                nombre: $('#nombre').val(),
                email: $('#email').val(),
                password: password
            },
            success: function (data) {
                if (data.response === '00') {
                    mostrarMensaje('success', '' + data.message + ' — Redirigiendo...');
                    setTimeout(function () {
                        window.location.href = 'index.php?page=login';
                    }, 1500);
                } else {
                    mostrarMensaje('danger', '' + data.message);
                }
            },
            error: function (xhr) {
                mostrarMensaje('danger', 'Error del servidor: ' + xhr.responseText);
            }
        });
    });

    function mostrarMensaje(tipo, texto) {
        $('#mensaje').html(
            '<div class="alert alert-' + tipo + ' mt-2">' + texto + '</div>'
        );
    }
});
