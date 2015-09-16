<?php
//
// Created by Grégoire JONCOUR on 04/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//
use App\Vendor\String;
?>
<h1>Utilisateurs</h1>
<!--<ul>
<?php /*foreach ($groups as $group): */?>

    <li><a href="<?/*= $group['id']; */?>"><?/*= $group['name']; */?></a></li>

<?php /*endforeach; */?></ul>-->

<table class="table table-striped table-hover">
    <tr>
        <th>#</th>
        <th>Noms</th>
        <th>Prénoms</th>
        <th>Groupe</th>
        <th>Dates</th>
        <th></th>
    </tr>
    <?php foreach ($users as $i => $user): ?>
        <?php  $urluser = $this->app->urlFor('LoUser', array('firstname' => String::urlFormat($user->firstname), 'lastname' =>  String::urlFormat($user->lastname), 'id' => $user->id)); /** Init on click */
               $onclick = " onclick=\"window.location.href = '$urluser'\" style=\"cursor: pointer\"" ?>
    <tr>
        <td <?= $onclick ?>><?= $user->id; ?></td>
        <td <?= $onclick ?>><?= $user->lastname; ?></td>
        <td <?= $onclick ?>><?= $user->firstname; ?></td>
        <td <?= $onclick ?>><?= App\Vendor\String::my_mb_ucfirst($user->group) ?></td>
        <td <?= $onclick ?>><?= $user->dateRegister; ?></td>
        <td><!--<a href="<?/*=$this->app->urlFor('Lo').$url; */?>" type="button" class="btn btn-default btn-xs">Voir la fiche</a>-->
            <noscript>
                <a href="<?= $urluser ?>" class="btn btn-default btn-xs" title="voir fiche de <?= $user->name ?>">Fiche</a>
            </noscript>
            <a href="<?= $this->app->urlFor('edit', array('firstname' => String::urlFormat($user->firstname), 'lastname' =>  String::urlFormat($user->lastname), 'id' => $user->id)); ?>" type="button" class="btn btn-info btn-xs" title="Editer <?= $user->name ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
            <a href="<?= $this->app->urlFor('delete', array('firstname' => String::urlFormat($user->firstname), 'lastname' =>  String::urlFormat($user->lastname), 'id' => $user->id)); ?>" class="btn btn-danger btn-xs" type="button" title="Supprimer <?= $user->name ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
        </td>
    </tr>
    <?php endforeach; ?>
    <tr onclick="window.location.href = '<?= \Slim\Slim::getInstance()->urlFor('add') ?>'" style="cursor: pointer">
        <td colspan="6"><a href="<?= \Slim\Slim::getInstance()->urlFor('add') ?>" style="text-decoration: none"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;&nbsp;Ajouter un utilisateur</a></td>
    </tr>
</table>
