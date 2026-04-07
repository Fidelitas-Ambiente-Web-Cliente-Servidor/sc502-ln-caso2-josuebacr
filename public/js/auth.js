$(document).ready(function () {

    // login
    $('#formLogin').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'index.php',
            method: 'POST',
            data: {
                option: 'login',
                username: $('#username').val(),
                password: $('#password').val()
            },
            success: function (res) {
                var data = typeof res === 'string' ? JSON.parse(res) : res;
                if (data.response === '00') {
                    if (data.rol === 'admin') {
                        window.location.href = 'index.php?page=admin';
                    } else {
                        window.location.href = 'index.php?page=talleres';
                    }
                } else {
                    alert(data.message);
                }
            },
            error: function () {
                alert('Error al conectar con el servidor');
            }
        });
    });

    // Logout
    $('#btnLogout').on('click', function () {
        $.ajax({
            url: 'index.php',
            method: 'POST',
            data: { option: 'logout' },
            success: function () {
                window.location.href = 'index.php?page=login';
            }
        });
    });
});
