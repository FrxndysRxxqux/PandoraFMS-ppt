<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

// Incluir el autoload generado por Composer
require 'vendor/autoload.php'; // Esto carga automáticamente todas las dependencias de Composer

// Crear una instancia de AltoRouter
$router = new AltoRouter();
use App\Resources\View;


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
    $response = [
        'status' => 'success',
        'message' => 'Inscripción procesada correctamente',
        'post' => $_POST
    ];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
});

// Match de ruta
$match = $router->match();
if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    echo "Ruta no encontrada 🚫";
}