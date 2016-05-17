<?php
//
// Created by Grégoire JONCOUR on 11/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//
?>
<h1>Accueil</h1>
<p>Ce site est un test d'ajout et édition de profils avec api Google maps en PHP (<a href="http://www.slimframework.com/" target="_blank">Slim</a>) et javascript (JQuery).<br>
Créé pour le besoin d'un projet extra-scolaire.</p>
<a class="btn btn-lg btn-link" href="<?= \Slim\Slim::getInstance()->urlFor('Lo') ?>" >Utilisateurs</a><br>
<a class="btn btn-lg btn-link" href="<?= \Slim\Slim::getInstance()->urlFor('groups_index') ?>">Groupes</a>