<?php
//
// Created by Grégoire JONCOUR on 09/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//

namespace App\Vendor;


class String
{
    public static function my_mb_ucfirst($str) {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc.mb_substr($str, 1);
    }

    /**
     * Utilise iconv de PHP
     * @param $str
     * @return string
     */
    public static function rm_accent($str){
        return iconv(mb_detect_encoding($str), 'ASCII//TRANSLIT//IGNORE', $str);
    }

    public static function urlFormat($str){
        return String::rm_accent(mb_strtolower($str));
    }
}