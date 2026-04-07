$(document).ready(function () {
    cargarTalleres();
});

function cargarTalleres() {
    $.ajax({
        url: 'index.php?option=talleres_json',
        method: 'GET',
        success: function (res) {
            var talleres = typeof res === 'string' ? JSON.parse(res) : res;
            var tbody = $('#talleres-body');
            tbody.empty();

            if (talleres.length === 0) {
                tbody.html('<tr><td colspan="6" class="text-center text-muted">No hay talleres disponibles</td></tr>');
                return;
            }

            talleres.forEach(function (t) {
                tbody.append(
                    '<tr>' +
                    '<td>' + t.id + '</td>' +
                    '<td>' + t.nombre + '</td>' +
                    '<td>' + t.descripcion + '</td>' +
                    '<td>' + t.cupo_maximo + '</td>' +
                    '<td><span class="badge bg-success">' + t.cupo_disponible + '</span></td>' +
                    '<td><button class="btn btn-primary btn-sm btn-solicitar" data-id="' + t.id + '" data-nombre="' + t.nombre + '">Solicitar</button></td>' +
                    '</tr>'
                );
            });
        },
        error: function () {
            $('#talleres-body').html('<tr><td colspan="6" class="text-danger text-center">Error al cargar talleres</td></tr>');
        }
    });
}
