$(document).ready(function () {

    $(document).on('click', '.btn-solicitar', function () {
        var tallerId = $(this).data('id');
        var tallerNombre = $(this).data('nombre');

        if (!confirm('¿Deseas solicitar inscripción al taller: ' + tallerNombre + '?')) return;

        $.ajax({
            url: 'index.php',
            method: 'POST',
            data: {
                option: 'solicitar',
                taller_id: tallerId
            },
            success: function (res) {
                var data = typeof res === 'string' ? JSON.parse(res) : res;
                mostrarMensaje(data.success ? 'success' : 'danger', data.message);
                if (data.success) {
                    cargarTalleres();
                }
            },
            error: function () {
                mostrarMensaje('danger', 'Error al conectar con el servidor');
            }
        });
    });

    function mostrarMensaje(tipo, texto) {
        $('#mensaje').html(
            '<div class="alert alert-' + tipo + ' alert-dismissible fade show" role="alert">' +
            texto +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
            '</div>'
        );
        setTimeout(function () { $('#mensaje .alert').fadeOut(); }, 4000);
    }
});
