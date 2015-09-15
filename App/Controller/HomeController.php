<?php
//
// Created by Grégoire JONCOUR on 04/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//
namespace App\Controller;


class HomeController extends Controller
{

    public function __construct(){
        parent::__construct();
        $this->data['title'] = 'Accueil';
        $this->data['breadcrumb'] = array(
            ucfirst($this->data['title']) => ""
        );
    }

    public function index(){
        $this->render('Home');
    }
}