<?php

use Symfony\Component\HttpFoundation\Request;
use symfony\Component\HttpFoundation\Response;

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
    echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

$app->get('/blog/latest', function (Silex\Application $app) {
	$response = new Response();
	try {
		$query = $conn->prepare("SELECT title, body, author, createDate FROM paulsheets_blog ORDER BY createdDate DESC LIMIT 1;");
		$query->execute();
		$result = $query->setFetchMode(PDO::FETCH_ASSOC);
		$response->setStatusCode(200);
		$response->setContent(json_encode($result));
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


// Close DB Connection
$conn->close();

// This should be the last line
$app->run(); // Start the application, i.e. handle the request
