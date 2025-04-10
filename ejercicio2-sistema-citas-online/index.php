<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

// Incluir el autoload generado por Composer
require 'vendor/autoload.php'; // Esto carga automáticamente todas las dependencias de Composer

// Crear una instancia de AltoRouter
$router = new AltoRouter();
use App\Resources\View;
use App\Controllers\DbController;


// Configurá el basePath
//configuramos basepath para poder ejecutar index.php desde cualquier dentro del servidor php
$basePath = dirname($_SERVER['SCRIPT_NAME']);
$router->setBasePath($basePath);


// start routing defining
$router->map('GET', "/", function() {
    $view = new View();
    $view->render('app/Resources/Views/welcome.php');
});

$router->map('GET', "/inscription_form", function() {

    $view = new View();
    $view->render('app/Resources/Views/inscriptionForm.php');

});

$router->map('POST', "/procesar_inscripcion", function() {

    header('Content-Type: application/json');
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $tipoCita = $_POST['tipoCita'];

    // First check if there are any events registered, ordered by end date (most recent first)
    $dbController = new DbController();
    $citas = $dbController->select('citas',[],'*','feha_hora_fin DESC');

    //validate if any event is registered, add 1 more hour to the new event taking the last event. If the new event ends after 10pm,
    // add one day instead and start the event at 10am
    if ($citas) {
        $ultimaCita = $citas[0];
        $ultimaFechaFin = $ultimaCita->feha_hora_fin;
        $nuevaFechaInicio = $ultimaFechaFin;
        $nuevaFechaFin = date('Y-m-d H:i:s', strtotime($nuevaFechaInicio . ' +1 hour'));
        
        if(date("H:i",strtotime($nuevaFechaFin)) > date("H:i",strtotime('22:00'))){
             $nuevaFechaInicio = date('Y-m-d 10:00:00', strtotime($nuevaFechaInicio . ' +1 day'));
             $nuevaFechaFin = date('Y-m-d H:i:s', strtotime($nuevaFechaInicio . ' +1 hour'));
        }

    } else {
        //if there are no events, register a new default event starting at the next o'clock hour
        $nuevaFechaInicio = date('Y-m-d H:00:00', strtotime('next hour'));
        $nuevaFechaFin = date('Y-m-d H:i:s', strtotime($nuevaFechaInicio . ' +1 hour'));

        if(date("H:i",strtotime($nuevaFechaFin)) > date("H:i",strtotime('22:00'))){
            $nuevaFechaInicio = date('Y-m-d 10:00:00', strtotime($nuevaFechaInicio . ' +1 day'));
            $nuevaFechaFin = date('Y-m-d H:i:s', strtotime($nuevaFechaInicio . ' +1 hour'));
       }
    }

    // creating array with event data
    $newCita = [
        'nombre' => $nombre,
        'dni' => $dni,
        'telefono' => $telefono,
        'email' => $email,
        'tipo_cita' => $tipoCita,
        'feha_hora_inicio' => $nuevaFechaInicio,
        'feha_hora_fin' => $nuevaFechaFin
    ];
    
    //try inserting event data capturing exception
    try {
        if($dbController->insert('citas', $newCita)){
            // returning the event if we want to show it to the user (not required in the test)
            $response = [
                'status' => 'success',
                'message' => 'Se ha generado la cita',
                'cita' => $newCita 
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error desconocido al crear la cita'
            ];
        }
    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => 'Error al crear la cita: ' . $e->getMessage()
        ];
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
});

$router->map('POST', "/validateDniDB", function() {

    header('Content-Type: application/json');

    $dbController = new DbController();
    $citas = $dbController->select('citas',['dni' => $_POST['dni']]);

    if($citas){
        $response = [
            'status' => 'success',
            'exist' => 1,
        ];
    }else{
        $response = [
            'status' => 'success',
            'exist' => 0,
        ];
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
});



// Match de ruta
$match = $router->match();
if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    echo "Ruta no encontrada 🚫";
}