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
                <div id="alets">

                </div>
                <form>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" onkeyup="validateInput(this.value,'validationNombre')" placeholder="Ingrese su nombre" required>
                        <span id="validationNombre"></span>

                    </div>
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="text" class="form-control" id="dni" onkeyup="validateInput(this.value,'validationDni')" placeholder="Ingrese su DNI" required>
                        <span id="validationDni"></span>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" onkeyup="validateInput(this.value,'validationTelefono')" placeholder="Ingrese su teléfono" required> 
                        <span id="validationTelefono"></span>

                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" onkeyup="validateInput(this.value,'validationEmail')" id="email" placeholder="Ingrese su email" required>
                        <span id="validationEmail"></span>

                    </div>
                    <div class="mb-3">
                        <label for="tipoCita" class="form-label">Tipo de cita</label>
                        <select class="form-select" id="tipoCita" onkeyup="validateInput(this.value,'validationTipoCita')" required>
                            <option selected>Seleccione el tipo de cita</option>
                            <option value="primeraConsulta">Primera consulta</option>
                            <option value="revision" disabled>Revisión</option>
                        </select>
                        <span id="validationTipoCita"></span>

                    </div>
                    <div class="d-grid">
                        <button type="submit" id="btn-submit" class="btn btn-primary">Enviar</button>
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
                    if(response.status == 'success') {
                        const alertDiv = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;
                        $('form').before(alertDiv);
                    }else{
                        const alertDiv = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;

                    }
                    $('form')[0].reset();
                },
                error: function(xhr, status, error) {
                    alert('Error al enviar la inscripción');
                }
            });
        });
    });


    function validateEmpty(value, errorSpan) {
        if (value.trim() === '') {
            $(`#${errorSpan}`).text('Este campo no puede estar vacío').addClass('text-danger small').show();;
            return false;
        }
        $(`#${errorSpan}`).text('');
        return true;
    }
    function validateOnlyText(value, errorSpan) {
        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value)) {
            $(`#${errorSpan}`).text('Solo se permiten letras').addClass('text-danger small').show();
            return false;
        }
        $(`#${errorSpan}`).text('');
        return true;
    }

    function validateOnlyNumber(value, errorSpan) {
        if (!/^[0-9]+$/.test(value)) {
            $(`#${errorSpan}`).text('Solo se permiten números').addClass('text-danger small').show();
            return false;
        }
        $(`#${errorSpan}`).text('');
        return true;
    }

    function validateMaxLength(value, errorSpan,textLength) {
        if (value.length > textLength) {
            $(`#${errorSpan}`).text('El valor excede el límite permitido').addClass('text-danger small').show();;
            return false;
        }
        return true;
    }

    function validateEmail(value, errorSpan) {
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            $(`#${errorSpan}`).text('Email no válido').addClass('text-danger small').show();;
            return false;
        }
        $(`#${errorSpan}`).text('');

        return true;
    }


    function validateInput(value, errorSpan) {
        let result_validation;
        switch (errorSpan) {
            case 'validationNombre':
                result_validation = validateOnlyText(value, errorSpan) && 
                                    validateMaxLength(value, errorSpan,40);
                                    break;
            case 'validationEmail':
                result_validation = validateEmail(value, errorSpan);
                break;
                       
            case 'validationDni':
                    validateDniAjax(value);
                result_validation = validateDNI(value, errorSpan);
                break;
            case 'validationTelefono':
                result_validation = validateOnlyNumber(value, errorSpan) &&  validateMaxLength(value, errorSpan,9);
                ;
                break;
            default:
                result_validation = validateEmpty(value, errorSpan);
                break;
        }

        $("#btn-submit").prop('disabled', result_validation ? false : true);
        return result_validation

    }

    function validateDniAjax(value){
        $.ajax({
            type: 'POST',
            url: 'validateDniDB',
            data: {dni:value},
            success: function(response) {
                //upadte input disabled if exist dni on db
                if(response.exist === 1) {
                    $('option[value="revision"]').prop('disabled', false);
                } else {
                    $('option[value="revision"]').prop('disabled', true); 
                }
            },
            error: function(xhr, status, error) {
                alert('Error al enviar la inscripción');
            }
        });
    }



    function validateDNI(value, errorSpan) {
        // Validación de DNI/NIE
        const dniRegex = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i;
        const nieRegex = /^[XYZ][0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKE]$/i;
        const letrasValidacion = 'TRWAGMYFPDXBNJZSQVHLCKE';

        // restore select of tipoCita to primera consulta
        $('#tipoCita').val('primeraConsulta');
        value = value.trim();
            
        if(validarDNI(value,dniRegex,letrasValidacion) || validarNIE(value,nieRegex,letrasValidacion)) {
            $(`#${errorSpan}`).text('').hide();
            return true;
        }
            
        $(`#${errorSpan}`).text('DNI/NIE no válido').addClass('text-danger small').show();
        return false;
    }

    function validarDNI(value,dniRegex,letrasValidacion) {
        value = value.toUpperCase();
        
        if (!dniRegex.test(value)) {
            return false;
        }
        
        const numero = value.substr(0,8);
        const letra = value.substr(8,1);
        const letraCorrecta = letrasValidacion.charAt(numero % 23);
        
        return letra === letraCorrecta;
    }
    
    function validarNIE(value,nieRegex,letrasValidacion) {
        value = value.toUpperCase();
        
        if (!nieRegex.test(value)) {
            return false; 
        }
        
        const primeraLetra = value.charAt(0);
        let numero = value.substr(1,7);
        const letra = value.substr(8,1);
        
        // Convertir primera letra a número según especificación NIE
        const letraANumero = {
            'X': 0,
            'Y': 1,
            'Z': 2
        };
        
        numero = letraANumero[primeraLetra] + numero;
        const letraCorrecta = letrasValidacion.charAt(numero % 23);
        
        return letra === letraCorrecta;
    }

</script>
</html>
