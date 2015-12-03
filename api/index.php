<?php
require_once 'include/DbHandler.php';
require_once 'include/PassHash.php';
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

/**
 * User Creation
 */
$app->post('/newxml', function () use ($app) {

    $json = $app->request->getBody();

    $input = json_decode($json, true);
    $xml = $input['xml'];
    $author = $input['author'];

    var_dump($xml);
    var_dump($author);


    $db = new DbHandler();
    $res = $db->addxml($xml, $author);


    echo $res;



});


/**
 * Get candidates
 * method GET
 * params - none
 * url - /events
 */
$app->get('/xml', function () use ($app) {
    echo "xmlget is working";
});

/**
 * Echoing json response to client
 *
 * @param String $status_code
 *            Http response code
 * @param Int $response
 *            Json response
 */
function echoResponse($status_code, $response)
{
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

$app->run();
