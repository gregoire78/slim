<?php
//
// Created by Grégoire JONCOUR on 10/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//

namespace App\Controller;

use App\App;
use App\Vendor\Stringly;
use App\Vendor\Validator;

class UserformController extends Controller
{
    public function __construct(){
        parent::__construct();
        $this->loadModel('group');
        $this->loadModel('user');

        $this->loadJs('bootstrap_feedback.js', ['position'=>'last']);
        $this->loadJs('add_user.js', ['position'=>'after:bootstrap_feedback.js']);
        $this->loadJs(ROOT.'bootstrap-sweetalert-dist/lib/sweet-alert.min.js', ['location' => 'external', 'position'=>'after:add_user.js']);
        $this->loadCss(ROOT.'bootstrap-sweetalert-dist/lib/sweet-alert.css', ['location' => 'external', 'position'=>'last']);
    }

    public function index($return){
        $groups = $this->group->all();
        $this->render('Add', compact("groups","return"));
    }

    public function addGet()
    {
        $this->data['title'] = 'ajouter utilisateur';
        $this->data['breadcrumb'] = array(
            "Accueil" => $this->app->urlFor('home'),
            "Utilisateurs" => $this->app->urlFor('Lo'),
            ucfirst($this->data['title']) => ""
        );
        $return['h1']='Ajouter un utilisateur';
        $this->index($return);
    }

    public function addPost()
    {
        //sleep(3);
        $validator = $this->validatorUser();
        if ($validator->isValid()) {
            $this->user->create([
                'firstname' => Stringly::ucName(trim($_POST['firstname'])),
                'lastname' => ucfirst(trim($_POST['lastname'])),
                'email' => /*trim($_POST['email'])*/
                    'exempla@email.com',
                'streetAddress' => trim($_POST['street']),
                'city' => trim(mb_strtoupper($_POST['city'])),
                'postalcode' => trim($_POST['postalCode']),
                'phonenumber' => str_replace(' ', '', $_POST['phone']),
                'ip' => '192.168.0.1',
                'date_register' => date("Y-m-d H:i:s"),
                'id_group' => $_POST['group']
            ]);
            $return['success'] = 'Utilisateur créé';
            $user = $this->user->find(App::getInstance()->getDb()->lastInsertId()); // on récupère le dernier id pour le lien de retour
            $return['urlRedirect'] = $this->app->urlFor('LoUser', array('firstname' => Stringly::urlFormat($user->firstname), 'lastname' =>  Stringly::urlFormat($user->lastname), 'id' => $user->id));
        } else {
            $return['errors'] = $validator->getErrors();
        }

        if ($this->app->request->isXhr()) { // si requete envoyé est (xhr) ajax
            //if (!empty($return['errors'])) {
            //    header('Internal Error', true, 500);
            //}
            $this->app->response->headers->set('Content-Type', 'application/json');
            die(json_encode($return));
        }else{
            if (!empty($return['errors'])) {
                $this->addGet();
            }else{
                $this->app->redirect($return['urlRedirect']);
            }
        }
    }

    public function editGet($firstname, $lastname, $id){
        $user = $this->user->find($id); // on cherche les infos
        if($user){
            $this->data['title'] = 'modifier '.$user->name;
            $this->data['breadcrumb'] = array(
                "Accueil" => $this->app->urlFor('home'),
                "Utilisateurs" => $this->app->urlFor('Lo'),
                $user->name => $this->app->urlFor('LoUser', array('firstname' => $firstname, 'lastname' =>  $lastname, 'id' => $user->id)),
                "modifier" => ""
            );
            $return['h1']='Modifier : '.$user->name;
            $return['dataUser'] = $user;
            if ($firstname !== Stringly::urlFormat($user->firstname) || $lastname !== Stringly::urlFormat($user->lastname)) {
                $this->app->redirect(URI . "users/edit/" . Stringly::urlFormat($user->firstname . "-" . $user->lastname . "-" . $user->id));
            }
            $this->index($return);
        }else{
            $this->app->notFound();
        }
    }

    public function editPost($firstname, $lastname, $id)
    {
        $user = $this->user->find($id); // on cherche les infos
        if ($user) {
            $validator = $this->validatorUser();
            if ($validator->isValid()) {
                $parentdata = array($user->firstname, $user->lastname, $user->email, $user->streetAddress, $user->city, $user->postalcode, $user->phonenumber, $user->id_group);
                $updatedata = array(
                    'firstname' => Stringly::ucName(trim($_POST['firstname'])),
                    'lastname' => ucfirst(trim($_POST['lastname'])),
                    'email' => trim($_POST['email']),
                    'streetAddress' => trim($_POST['street']),
                    'city' => trim(mb_strtoupper($_POST['city'])),
                    'postalcode' => trim($_POST['postalCode']),
                    'phonenumber' => str_replace(' ', '', $_POST['phone']),
                    'id_group' => $_POST['group']
                );
                $fieldUpdated = array_diff($updatedata,$parentdata);
                if(!empty($fieldUpdated)){ // si il y a des éléments qui ont changées apres la comparaison des tableaux
                    $this->user->update($id,$fieldUpdated);
                    $return['success'] = "Utilisateur modifié avec succès";
                    $return['urlRedirect'] = $this->app->urlFor('LoUser', array('firstname' => $firstname, 'lastname' =>  $lastname, 'id' => $user->id));
                }else{
                    $return['info'] = 'Rien n\'a été modifié';
                }
            }else {
                $return['errors'] = $validator->getErrors();
            }

            if ($this->app->request->isXhr()) { // si requete envoyé est (xhr) ajax
                //if (!empty($return['errors'])) {
                //    header('Internal Error', true, 500);
                //}
                $this->app->response->headers->set('Content-Type', 'application/json');
                die(json_encode($return));
            } else {
                if (!empty($return['errors'])) {
                    $this->editGet($firstname, $lastname, $id);
                } else {
                    $this->app->redirect($return['urlRedirect']);
                }
            }
        }else{
            $this->app->notFound();
        }
    }

    private function validatorUser(){
        $validator = new Validator($_POST);
        $validator->isAlpha('firstname', 'Veuillez entrer un prénom');
        $validator->isAlpha('lastname', 'Veuillez entrer un nom');
        $validator->isEmail('email', 'Veuillez entrer un email');
        $validator->isStreet('street', 'Veuillez entrer une adresse');
        $validator->isCity('city', 'Veuillez entrer une ville');
        $validator->isPotalcode('postalCode', 'Veuillez entrer un code postal');
        $validator->isPhone('phone', 'Veuillez entrer un numéro de téléphone');
        $validator->isGroup('group', 'Veuillez choisir un groupe');
        return $validator;
    }
}