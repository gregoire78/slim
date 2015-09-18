<?php
//
// Created by Grégoire JONCOUR on 18/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//

namespace App\Controller;


class GroupsController extends Controller
{
    public function __construct(){
        parent::__construct();
        $this->loadModel('group');
        $this->loadModel('user');

        $this->loadJs('bootstrap_feedback.js', ['position'=>'last']);
        $this->loadJs('add_user.js', ['position'=>'after:bootstrap_feedback.js']);
    }

    public function index(){
        $groups = $this->group->all();
        $this->data['title'] = 'groupes';
        $this->data['breadcrumb'] = array(
            "Accueil" => $this->app->urlFor('home'),
            ucfirst($this->data['title']) => "",
        );
        $this->render('Groups', compact("groups"));
    }
}