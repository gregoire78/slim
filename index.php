<?php
//
// Created by Grégoire JONCOUR on 02/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//

require 'vendor/autoload.php';
$app = new \Slim\Slim(['debug' => true,'templates.path' => 'App/View/templates']);

/*$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $app->request->getRootUri() . "/"; // racine pour le public (pour mail etc...)
define('ROOTHOST', $root);*/
$uri = $app->request->getRootUri().'/'; // racine URI
$server =$app->request->getHost();
define('URI', $uri);
$root = $uri."public/"; // racine pour le public
define('ROOT', $root);
$app->setName('Slim');

$app->get('/', 'App\Controller\HomeController:index')->name('home');

$app->group('/users', function () use ($app) {

    $app->get('/', 'App\Controller\UsersController:index')->name('Lo');
    $app->get('/:firstname-:lastname-:id', 'App\Controller\UsersController:getId')->conditions(['id' => '[0-9]+'])->name('LoUser');

    $app->get('/add/', 'App\Controller\UserformController:addGet')->name('add');
    $app->post('/add/', 'App\Controller\UserformController:addPost');

    $app->get('/edit/:firstname-:lastname-:id', 'App\Controller\UserformController:editGet')->conditions(['id' => '[0-9]+'])->name('edit');
    $app->post('/edit/:firstname-:lastname-:id', 'App\Controller\UserformController:editPost')->conditions(['id' => '[0-9]+']);

    $app->get('/delete/:firstname-:lastname-:id', 'App\Controller\UsersController:delete')->conditions(['id' => '[0-9]+'])->name('delete');
});

$app->group('/groups', function () use ($app) {
    $app->get('/', 'App\Controller\GroupsController:index')->name('groups_index');

});
$app->error(function (\Exception $e) use ($app) {
    $app->render('error.php');
});
//$app->notFound(function () use ($app) {
//    $app->render('404.html');
//});
$app->run();