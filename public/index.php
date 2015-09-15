<?php
//
// Created by Grégoire JONCOUR on 02/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//

require '../vendor/autoload.php';
$app = new \Slim\Slim(['templates.path' => '../App/View/templates']);

/*$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $app->request->getRootUri() . "/"; // racine pour le public (pour mail etc...)
define('ROOTHOST', $root);*/
$root = $app->request->getRootUri() . "/"; // racine pour le public
define('ROOT', $root);
$app->setName('Slim');

$app->get('/', 'App\Controller\HomeController:index')->name('home');

$app->group('/users', function () use ($app) {

    $app->get('/', 'App\Controller\UsersController:index')->name('Lo');
    $app->get('/:firstname-:lastname-:id', 'App\Controller\UsersController:getId')->conditions(array('id' => '[0-9]+'))->name('LoUser');

    $app->get('/add/', 'App\Controller\UserformController:addGet')->name('add');
    $app->post('/add/', 'App\Controller\UserformController:addPost');

    $app->get('/edit/:firstname-:lastname-:id', 'App\Controller\UserformController:editGet')->conditions(array('id' => '[0-9]+'))->name('edit');
    $app->post('/edit/:firstname-:lastname-:id', 'App\Controller\UserformController:editPost')->conditions(array('id' => '[0-9]+'));
});

$app->run();