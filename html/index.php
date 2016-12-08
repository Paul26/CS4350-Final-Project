


<?php

use Symfony\Component\HttpFoundation\Request;
use symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/../vendor/autoload.php'; // Add the autoloading mechanism of Composer


$app = new Silex\Application(); // Create the Silex application, in which all configuration is going to go

// Section A
// We will later add the configuration, etc. here
$app['debug'] = true;


$app->get('/blog', function (Silex\Application $app) {

});

$app->get('/blog/{id}', function (Silex\Application $app, $id) {

});




// This should be the last line
$app->run(); // Start the application, i.e. handle the request



function bootstrap()
{
    $dic = new Container();
    
    $dic['app'] = function() {
        return new Silex\Application();
    };

    $dic['db-driver'] = function() {
        $host    = '107.170.222.199';
        $db      = 'final';
        $user    = 'paulsheets';
        $pass    = '1234pass';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = {
            PDO::ATTR_ERRMODE                   => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE        => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES          => false,       
        };
        return new PDO($dsn, $user, $pass, $opt);
    };
}


