<?php
//
// Created by Grégoire JONCOUR on 09/04/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//
namespace App\Entity;

use App\App;
use App\Vendor\Avatar;
use Core\Entity\Entity;

class UserEntity extends Entity
{
    public function getName(){
        return $this->firstname.' '.$this->lastname;
    }

    public function getPhonenumberFormat(){
        return wordwrap($this->phonenumber,2," ",true);
    }

    public function getCompleteAddress(){
        $adresse = $this->streetAddress;
        $adresse .= ', '.$this->postalcode;
        $adresse .= ', '.$this->city;
        return $adresse;
    }

    public function getGps(){
        // Google Maps Geocoder
        $geocoder = "http://maps.googleapis.com/maps/api/geocode/json?address=%s&sensor=false";

        // Requête envoyée à l'API Geocoding
        $query = sprintf($geocoder, urlencode(utf8_encode($this->getCompleteAddress())));

        $result = json_decode(file_get_contents($query));
        $json = $result->results[0];

        $Lat = (string) $json->geometry->location->lat;
        $Lng = (string) $json->geometry->location->lng;
        return array('lat' => $Lat, 'lng' => $Lng) ;
    }

    public function getCompleteDateRegister()
    {
        setlocale (LC_TIME, 'fr_FR.UTF-8','fra');
        $date=ucfirst(utf8_encode(strftime("%A %d %B %Y &agrave; %Hh%M", strtotime($this->date_register))));
        return $date;
    }

    public function getDateRegister(){
        return date("d/m/Y - H:i", strtotime($this->date_register));
    }

    public function getGroup(){
        $group = App::getInstance()->getTable('group')->find($this->id_group);
        return $group->name;
    }

    public function getAvatarUrl(){
        $avatarUrl = Avatar::getGravatar($this->email, 'identicon');
        return Avatar::renderAvatar($avatarUrl, $this->id);
    }
}