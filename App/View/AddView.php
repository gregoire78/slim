<?php
//
// Created by Grégoire JONCOUR on 10/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//
$firstname = isset($return['dataUser'])?$return['dataUser']->firstname:null;
$lastname = isset($return['dataUser'])?$return['dataUser']->lastname:null;
$email = isset($return['dataUser'])?$return['dataUser']->email:null;
$street = isset($return['dataUser'])?$return['dataUser']->streetAddress:null;
$city = isset($return['dataUser'])?$return['dataUser']->city:null;
$postalcode = isset($return['dataUser'])?$return['dataUser']->postalcode:null;
$phone = isset($return['dataUser'])?$return['dataUser']->phonenumber:null;
$groupId = isset($return['dataUser'])?$return['dataUser']->id_group:null;
?>
<h1><?= $return['h1'] ?></h1>

<div class="row">
    <div class="col-md-5 col-sm-5 ">
        <?php !(\Slim\Slim::getInstance()->request->isXhr()) && !empty($return['errors']) ? var_dump($return['errors']) : '' ?>
        <form action="#" method="post" id="add_user">
            <div class="form-group has-feedback" id="form-firstname">
                <label class="control-label" for="firstname">Prénom</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom" value="<?= $firstname ?>">
            </div>
            <div class="form-group has-feedback" id="form-lastname">
                <label class="control-label" for="lastname">Nom</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom" value="<?= $lastname ?>">
            </div>
            <div class="form-group has-feedback" id="form-email">
                <label class="control-label" for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="example@email.com" value="<?= $email ?>">
            </div>
            <div class="form-group has-feedback" id="form-postalcode">
                <label class="control-label" for="postalCode">Code postale</label>
                <input type="text" class="form-control" id="postalCode" name="postalCode" placeholder="Code postal" pattern="[0-9]{5}"  value="<?= $postalcode ?>">
            </div>
            <div class="form-group has-feedback" id="form-city">
                <label class="control-label" for="city">Ville</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Ville" value="<?= $city ?>">
            </div>
            <div class="form-group has-feedback" id="form-street">
                <label class="control-label" for="street">Rue</label>
                <input type="text" class="form-control" id="street" name="street" placeholder="Adresse" value="<?= $street ?>">
            </div>
            <div class="form-group has-feedback" id="form-phone">
                <label class="control-label" for="phone">Numéro de téléphone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="le numéro de téléphone" data-inputmask="'mask': '09 99 99 99 99'" value="<?= $phone ?>">
            </div>
            <div class="form-group has-feedback" id="form-group">
                <label class="control-label" for="group">Groupe</label>
                <select class="form-control" title="Groupe" id="group" name="group">
                    <option value="0"> - </option>
                    <?php foreach($groups as $group): ?>
                        <?php if(isset($groupId) && $groupId == $group->id): ?>
                        <option value="<?= $group->id ?>" selected><?= App\Vendor\Stringly::my_mb_ucfirst($group->name) ?></option>
                        <?php else: ?>
                        <option value="<?= $group->id ?>"><?= App\Vendor\Stringly::my_mb_ucfirst($group->name) ?></option>
                        <?php endif ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group" id="form-submit">
                <button type="submit" class="btn btn-primary btn-lg">Enregistrer</button>
                <button type="reset" class="btn btn-default btn-lg">Reset</button>
            </div>
        </form>
    </div>
</div>
<!--<div id="locationField">
    <input id="autocomplete" placeholder="Enter your address" onFocus="geolocate()" type="text"/>
</div>
<table id="address">
    <tr>
        <td class="label">Street address</td>
        <td class="slimField"><input class="field" id="street_number" disabled="true"/></td>
        <td class="wideField" colspan="2"><input class="field" id="route" disabled="true"/></td>
    </tr>
    <tr>
        <td class="label">City</td>
        <td class="wideField" colspan="3"><input class="field" id="locality" disabled="true"/></td>
    </tr>
    <tr>
        <td class="label">State</td>
        <td class="slimField"><input class="field" id="administrative_area_level_1" disabled="true"/></td>
        <td class="label">Zip code</td>
        <td class="wideField"><input class="field" id="postal_code" disabled="true"/></td>
    </tr>
    <tr>
        <td class="label">Country</td>
        <td class="wideField" colspan="3"><input class="field" id="country" disabled="true"/></td>
    </tr>
</table>-->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=&signed_in=true&libraries=places">
</script>
<!--&callback=initAutocomplete-->