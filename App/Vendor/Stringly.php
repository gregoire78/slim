<?php
//
// Created by Grégoire JONCOUR on 09/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//

namespace App\Vendor;


class Stringly
{
    /**
     * première lettre en majuscule
     * @param $str
     * @return string
     */
    public static function my_mb_ucfirst($str) {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc.mb_substr($str, 1);
    }

    /**
     * Utilise iconv de PHP
     * @param $str
     * @return string
     */
    //public static function rm_accent($str){
    //    return iconv(mb_detect_encoding($str), 'ASCII//TRANSLIT//IGNORE', $str);
    //}

    /**
     * @param $str
     * @param string $charset
     * @return mixed|string
     */
    public static function rm_accent($str, $charset='utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
        $str = str_replace(' ', '-', $str);
        return $str;
    }

    /**
     * @param $str
     * @return mixed|string
     */
    public static function urlFormat($str){
        return mb_strtolower(Stringly::rm_accent($str));
    }
}