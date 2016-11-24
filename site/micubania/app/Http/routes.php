<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/*$app->get('/', function () use ($app) {
    //return $app->version();
    return $app['twig']->render('home.twig', []);
});*/

$app->get('/', 'Controller@getHome');
$app->get('/staff', 'Controller@getStaff');
$app->get('/contactus', 'Controller@getContactus');
$app->get('/events', 'Controller@getEvents');