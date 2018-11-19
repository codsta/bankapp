<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Given a bank branch IFSC code, get branch details
$app->get('/api/bank/{ifsc}', function(Request $request, Response $response){
    $ifsc = $request->getAttribute('ifsc');
    $db = new Database();
    $bank_details = $db->fetch_bankdetails_ifsc($ifsc);
    echo $bank_details;
});
// Given a bank name and city, gets details of all branches of the bank in the city
$app->get('/api/bank/{bank_name}/{city}', function(Request $request, Response $response){
    $bank_name = $request->getAttribute('bank_name');
    $city = $request->getAttribute('city');
    $db = new Database();
    $bank_details = $db->fetch_bankdetails_bank_city($bank_name,$city);
    echo $bank_details;
});
