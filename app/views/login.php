<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:400px">
    <div class="card shadow">
        <div class="card-body p-4">
            <h4 class="mb-4">Iniciar Sesion</h4>
            <div id="mensaje"></div>
            <form id="formLogin">
                <input class="form-control mb-2" name="username" id="username" placeholder="Usuario" required>
                <input type="password" class="form-control mb-2" name="password" id="password" placeholder="Contraseña" required>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                <a href="index.php?page=registro" class="btn btn-link w-100 mt-1">¿No tienes una super cuenta? Registrarse</a>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>window.jQuery || document.write('<script src="public/js/jquery-4.0.0.min.js"><\/script>')</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="public/js/auth.js"></script>
</body>
</html>
