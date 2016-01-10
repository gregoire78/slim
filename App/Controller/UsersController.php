<?php
//
// Created by Grégoire JONCOUR on 12/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//

namespace App\Controller;


use App\Vendor\Stringly;

class UsersController extends Controller
{
    public function __construct(){
        parent::__construct();
        $this->loadModel('user');
        $this->loadModel('group');

        $this->loadJs(ROOT.'bootstrap-sweetalert-dist/lib/sweet-alert.min.js', ['location' => 'external', 'position'=>'last']);
        $this->loadCss(ROOT.'bootstrap-sweetalert-dist/lib/sweet-alert.css', ['location' => 'external', 'position'=>'last']);
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
            if ($firstname !== Stringly::urlFormat($user->firstname) || $lastname !== Stringly::urlFormat($user->lastname)) {
                $this->app->redirect(URI . "users/" . Stringly::urlFormat($user->firstname . "-" . $user->lastname . "-" . $user->id));
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