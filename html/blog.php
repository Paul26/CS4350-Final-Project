<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/../vendor/autoload.php'; // Add the autoloading mechanism of Composer


$app = new Silex\Application(); // Create the Silex application, in which all configuration is going to go

// Section A
// We will later add the configuration, etc. here
$app['debug'] = true;

//  DB Connection
$servername = "107.170.222.199";
$username   = "paulsheets";
$password   = "1234pass";

try {
    $conn = new PDO("mysql:host=$servername;dbname=final", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
        $response = new Response();
        $response->setStatusCode(500);
        $response->setContent(json_encode("Error: " . $e));
        return $response;
    }

$app->get('/blog/latest', function (Silex\Application $app) use($conn) {
        $response = new Response();
        try {
                $query = $conn->prepare("SELECT title, body, author, createdDate FROM paulsheets_blog ORDER BY createdDate DESC LIMIT 1;");
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $response->setStatusCode(200);
                $response->setContent(json_encode($result));
                $query = null;
                return $response;
        }
        catch(PDOException $e) {
                $response->setStatusCode(500);
                $response->setContent(json_encode("Error: " . $e));
                return $response;
        }
});

$app->get('/blog/{id}', function (Silex\Application $app, $id) {

});

$app->post('/blog/create', function (Request $request) use($app, $conn) {
        $response = new Response();
        try {
                // It's just easier to deal with the data this way.
                $post = array(
                    'title' => $request->request->get('title'),
                    'body' => $request->request->get('body'),
                    'author' => $request->request->get('author')
                );
                $query = $conn->prepare(
                    'INSERT INTO paulsheets_blog (title, body, author, createdDate) VALUES("'.$post['title'].'", "'.$post['body'].'", "'.$post['author'].'", NOW());'
                );
                $query->execute();
                $query = null;
                $rdate = array('date' => date('m-d-Y h:i:sa'));
                $response->setStatusCode(201);
                $response->setContent(json_encode($rdate));
                return $response;
        }       
        catch(PDOException $e) {
                $response->setStatusCode(500);
                $response->setContent(json_encode("Error: " . $e));
                return $response;           
        }
});

// Close DB Connection
$conn = null;

// This should be the last line
$app->run(); // Start the application, i.e. handle the request
