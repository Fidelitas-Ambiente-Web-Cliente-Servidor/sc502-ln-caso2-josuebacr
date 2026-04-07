$(document).ready(function () {
    cargarSolicitudes();
});

function cargarSolicitudes() {
    $('#solicitudes-body').html('<tr><td colspan="6" class="text-center">Cargando solicitudes...</td></tr>');

    $.ajax({
        url: 'index.php?option=solicitudes_json',
        method: 'GET',
        dataType: 'json',
        success: function (solicitudes) {
            var tbody = $('#solicitudes-body');
            tbody.empty();

            if (!solicitudes || solicitudes.length === 0) {
                tbody.html('<tr><td colspan="6" class="text-center text-muted">No hay solicitudes pendientes</td></tr>');
                return;
            }

            solicitudes.forEach(function (s) {
                tbody.append(
                    '<tr id="row-' + s.id + '">' +
                    '<td>' + s.id + '</td>' +
                    '<td>' + s.taller + '</td>' +
                    '<td>' + s.usuario + '</td>' +
                    '<td><span class="badge bg-info text-dark">' + s.cupo_disponible + '</span></td>' +
                    '<td>' + s.fecha_solicitud + '</td>' +
                    '<td>' +
                    '<button class="btn btn-success btn-sm btn-aprobar me-1" data-id="' + s.id + '">Aprobar</button>' +
                    '<button class="btn btn-danger btn-sm btn-rechazar" data-id="' + s.id + '">Rechazar</button>' +
                    '</td>' +
                    '</tr>'
                );
            });
        },
        error: function (xhr, status, error) {
            $('#solicitudes-body').html(
                '<tr><td colspan="6" class="text-danger text-center">' +
                'Error al cargar solicitudes: ' + xhr.responseText +
                '</td></tr>'
            );
        }
    });
}

$(document).on('click', '.btn-aprobar', function () {
    accionSolicitud('aprobar', $(this).data('id'));
});

$(document).on('click', '.btn-rechazar', function () {
    accionSolicitud('rechazar', $(this).data('id'));
});

function accionSolicitud(accion, id) {
    $.ajax({
        url: 'index.php',
        method: 'POST',
        dataType: 'json',
        data: { option: accion, id_solicitud: id },
        success: function (data) {
            mostrarMensaje(data.success ? 'success' : 'danger', data.message);
            if (data.success) {
                $('#row-' + id).fadeOut(400, function () {
                    $(this).remove();
                    if ($('#solicitudes-body tr').length === 0) {
                        $('#solicitudes-body').html('<tr><td colspan="6" class="text-center text-muted">No hay solicitudes pendientes</td></tr>');
                    }
                });
            }
        },
        error: function (xhr) {
            mostrarMensaje('danger', 'Error: ' + xhr.responseText);
        }
    });
}

function mostrarMensaje(tipo, texto) {
    $('#mensaje').html(
        '<div class="alert alert-' + tipo + ' alert-dismissible fade show" role="alert">' +
        texto +
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
        '</div>'
    );
    setTimeout(function () { $('#mensaje .alert').fadeOut(); }, 4000);
}
