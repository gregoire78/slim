<?php
//
// Created by Grégoire JONCOUR on 06/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//
use App\Vendor\String;
?>
<h1><?= $user->name ?>&nbsp;&nbsp;<a href="<?= $this->app->urlFor('edit', array('firstname' => String::urlFormat($user->firstname), 'lastname' => String::urlFormat($user->lastname), 'id' => $user->id)) ?>" class="btn btn-default" type="button" title="Editer <?= $user->name ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></h1>
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-primary" style="height: 540px;">
            <div class="panel-heading">
                <h1 class="panel-title">Fiche complète utilisateur <strong>#<?= $user->id ?></strong></h1>
            </div>
            <div class="panel-body">
                <p>Prénom : <strong><?= $user->firstname ?></strong></p>
                <p>Nom : <strong><?= $user->lastname ?></strong></p>
                <p>Email : <strong><?= $user->email ?></strong></p>
                <p>Adresse : <strong><?= $user->streetAddress ?></strong></p>
                <p>Ville : <strong><?= $user->city ?></strong></p>
                <p>Code postal : <strong><?= $user->postalcode ?></strong></p>
                <p>N° téléphone : <strong><?= $user->phonenumberformat ?></strong></p>
                <p>IP : <strong><?= $user->ip ?></strong></p>
                <p>Groupe : <strong><?= App\Vendor\String::my_mb_ucfirst($user->group) ?></strong></p>
                <p>Enregistré le : <strong><?= $user->completeDateRegister ?></strong></p>
                <p><a href="https://gravatar.com/" class="" target="_blank">Gravatar</a> : <img class="img-thumbnail" src="<?= $user->avatarUrl ?>" alt="avatar"></p>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h1 class="panel-title">Google Map</h1>
            </div>
            <div class="gMap">
                <div id="map"></div>
                <div id="pano"></div>
                <div class="iniFloat"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var address = "<?= addslashes(String::rm_accent($user->CompleteAddress)) ?>";
    var contentString =
        '<h1 style="font-size:18px;"><?= $user->name ?> <br><small><?= $user->group ?></small></h1>' +
        '<div>' +
        '<p><?= addslashes($user->streetAddress) ?><br/>' +
        '<?= $user->postalcode ?> - <?= addslashes($user->city) ?></p>' +
        '<p><?= $user->phonenumberformat ?></p>' +
        '</div>';
    var title = '<?= $user->name ?>';
    var markerUrl = '<?= ROOT ?>dist/img/Group1.png';

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQvNIyP2d-8QUabyIJEIHtf41iaNue_7c&v=3.21&callback=initMap&libraries=drawing&signed_in=true">//&signed_in=true
</script>