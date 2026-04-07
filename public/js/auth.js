$(document).ready(function () {

    // LOGIN
    $('#formLogin').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'index.php',
            method: 'POST',
            dataType: 'json',
            data: {
                option: 'login',
                username: $('#username').val(),
                password: $('#password').val()
            },
            success: function (data) {
                if (data.response === '00') {
                    if (data.rol === 'admin') {
                        window.location.href = 'index.php?page=admin';
                    } else {
                        window.location.href = 'index.php?page=talleres';
                    }
                } else {
                    $('#mensaje').html('<div class="alert alert-danger mt-2">' + data.message + '</div>');
                }
            },
            error: function (xhr) {
                $('#mensaje').html('<div class="alert alert-danger mt-2">Error del servidor: ' + xhr.responseText + '</div>');
            }
        });
    });

    // LOGOUT
    $('#btnLogout').on('click', function () {
        $.ajax({
            url: 'index.php',
            method: 'POST',
            dataType: 'json',
            data: { option: 'logout' },
            success: function () {
                window.location.href = 'index.php?page=login';
            }
        });
    });
});
