<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Darkside - Solicitudes Pendientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-danger px-4 mb-4">
    <a class="navbar-brand fw-bold" href="index.php?page=talleres">Talleres</a>
    <div class="ms-auto d-flex align-items-center gap-3">
        <a href="index.php?page=admin" class="btn btn-light btn-sm">Gestionar Solicitudes</a>
        <span class="text-white">Perfil de: <?= htmlspecialchars($_SESSION['user'] ?? 'Administrador') ?></span>
        <button id="btnLogout" class="btn btn-outline-light btn-sm">Cerrar sesion</button>
    </div>
</nav>

<div class="container">
    <h3 class="mb-3">Solicitudes Pendientes de Aprobación</h3>
    <div id="mensaje"></div>

    <table class="table table-bordered table-hover bg-white shadow-sm rounded" id="tabla-solicitudes">
        <thead class="table-danger">
            <tr>
                <th>#</th>
                <th>Taller</th>
                <th>Solicitante</th>
                <th>Cupos Restantes</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="solicitudes-body">
            <tr><td colspan="6" class="text-center">Cargando solicitudes...</td></tr>
        </tbody>
    </table>
</div>

<!-- Scripts al final del body -->
<script src="public/js/jquery-4.0.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="public/js/admin.js"></script>
<script src="public/js/auth.js"></script>
</body>
</html>
