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


$app->get('/xml', function () use ($app) {
    $db = new DbHandler();
    $res = $db->getxml();
    //var_dump($res);
    echoResponse(200, $res);
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
