<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClicTerapia.es</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>">ClicTerapia.es</a>
        </div>
    </nav>

    <div class="container min-vh-100 d-flex align-items-center">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 text-center">
                <h1 class="display-4 mb-4">Bienvenido a ClicTerapia.<span class="text-primary">es</span></h1>
                <p class="lead mb-5">La forma más sencilla de gestionar tus citas y consultas online</p>
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <a href="inscription_form" class="btn btn-primary btn-lg px-4 w-50">Formulario de inscripcion</a>
                    <!-- <a href="/register" class="btn btn-outline-secondary btn-lg px-4">Registrarse</a> -->
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 ClicTerapia.es. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
