<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inscripción - ClicTerapia.es</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
        <a class="navbar-brand" href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>">ClicTerapia.es</a>
        </div>
    </nav>

    <div class="container min-vh-100 ">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center mb-4">Formulario de Inscripción</h1>
                <form>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Ingrese su nombre">
                    </div>
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="text" class="form-control" id="dni" placeholder="Ingrese su DNI">
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" placeholder="Ingrese su teléfono">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="Ingrese su email">
                    </div>
                    <div class="mb-3">
                        <label for="tipoCita" class="form-label">Tipo de cita</label>
                        <select class="form-select" id="tipoCita">
                            <option selected>Seleccione el tipo de cita</option>
                            <option value="primeraConsulta">Primera consulta</option>
                            <option value="revision">Revisión</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();
        
        let formData = {
            nombre: $('#nombre').val(),
            dni: $('#dni').val(), 
            telefono: $('#telefono').val(),
            email: $('#email').val(),
            tipoCita: $('#tipoCita').val()
        };

        $.ajax({
            type: 'POST',
            url: 'procesar_inscripcion',
            data: formData,
            success: function(response) {
                // alert('Inscripción enviada correctamente');
                
                console.log(response)
                $('form')[0].reset();
            },
            error: function(xhr, status, error) {
                alert('Error al enviar la inscripción');
            }
        });
    });
});
</script>
</html>
