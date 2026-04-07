<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Talleres Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary px-4 mb-4">
    <a class="navbar-brand fw-bold" href="index.php?page=talleres">Talleres</a>
    <div class="ms-auto d-flex align-items-center gap-3">
        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
            <a href="index.php?page=admin" class="btn btn-warning btn-sm">Gestionar Solicitudes</a>
        <?php endif; ?>
        <span class="text-white"><?= htmlspecialchars($_SESSION['user'] ?? 'Usuario') ?></span>
        <button id="btnLogout" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
    </div>
</nav>

<div class="container">
    <h3 class="mb-3">Talleres Disponibles</h3>
    <div id="mensaje"></div>

    <table class="table table-bordered table-hover bg-white shadow-sm rounded">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Cupo Máximo</th>
                <th>Cupos Disponibles</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody id="talleres-body">
            <tr><td colspan="6" class="text-center">Cargando talleres...</td></tr>
        </tbody>
    </table>
</div>

<!-- Scripts al final del body -->
<script src="public/js/jquery-4.0.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="public/js/taller.js"></script>
<script src="public/js/solicitud.js"></script>
<script src="public/js/auth.js"></script>
</body>
</html>
