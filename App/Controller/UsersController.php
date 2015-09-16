<?php
//
// Created by Grégoire JONCOUR on 12/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//

namespace App\Controller;


use App\Vendor\String;

class UsersController extends Controller
{
    public function __construct(){
        parent::__construct();
        $this->loadModel('user');
        $this->loadModel('group');
    }

    public function index(){
        $this->loadJs('delete_user.js', ['position'=>'last']);
        $this->data['title'] = 'utilisateurs';
        $users = $this->user->all();
        $groups = $this->group->all();
        $this->data['breadcrumb'] = array(
            "Accueil" => $this->app->urlFor('home'),
            ucfirst($this->data['title']) => "",
        );
        $this->render('Lo', compact("users", "groups"));
    }

    public function getId($firstname, $lastname, $id){
        $user = $this->user->find($id);
        if($user) {//on verifie si l'id user existe
            $this->loadJs("essai.js",['position'=>'last']);
            $this->data['title'] = $user->name;
            $this->data['breadcrumb'] = array(
                "Accueil" => $this->app->urlFor('home'),
                "Utilisateurs" => $this->app->urlFor('Lo'),
                ucfirst($this->data['title']) => "",
            );
            if ($firstname !== String::rm_accent(mb_strtolower($user->firstname)) || $lastname !== String::rm_accent(mb_strtolower($user->lastname))) {
                $this->app->redirect(ROOT . "users/" . String::rm_accent(mb_strtolower($user->firstname . "-" . $user->lastname . "-" . $user->id)));
            }
            $this->render('LoId', compact("user", "group"));
        }else{
            $this->app->notFound();
        }
    }

    public function delete($firstname, $lastname, $id) {
        $user = $this->user->find($id);
        if($user) {//on verifie si l'id user existe
            $this->user->delete($id);
        }else{
            $this->app->notFound();
        }

        if (!$this->app->request->isXhr()) { // si requete envoyé est (xhr) ajax
            $this->app->redirect($this->app->urlFor('Lo'));
        }
    }
}