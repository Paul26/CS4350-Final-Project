<?php

use Symfony\Component\HttpFoundation\Request;
use symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/../vendor/autoload.php'; // Add the autoloading mechanism of Composer


$app = new Silex\Application(); // Create the Silex application, in which all configuration is going to go

// Section A
// We will later add the configuration, etc. here
$app['debug'] = true;

//  DB Connection 
$link = mysqli_connect("107.170.222.199", "donstringham", "1234pass", "final");
 
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
 
echo "Success: A proper connection to MySQL was made! The database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;


$app->get('/blog', function (Silex\Application $app) {

});

$app->get('/blog/{id}', function (Silex\Application $app, $id) {

});



mysqli_close($link);

// This should be the last line
$app->run(); // Start the application, i.e. handle the request
