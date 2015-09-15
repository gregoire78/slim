<?php
//
// Created by Grégoire JONCOUR on 09/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//

namespace App\Vendor;
use Intervention\Image\ImageManagerStatic as Image;

class Avatar
{
    /**
     * @param $email
     * @param int $s
     * @param string $d
     * 404: do not load any image if none is associated with the email hash, instead return an HTTP 404 (File Not Found) response
     * mm: (mystery-man) a simple, cartoon-style silhouetted outline of a person (does not vary by email hash)
     * identicon: a geometric pattern based on an email hash
     * monsterid: a generated 'monster' with different colors, faces, etc
     * wavatar: generated faces with differing features and backgrounds
     * retro: awesome generated, 8-bit arcade-style pixelated faces
     * blank: a transparent PNG image (border added to HTML below for demonstration purposes
     * @param string $r
     * @param bool|false $img
     * @param array $atts
     * @return string
     */
    public static function getGravatar( $email, $d = 'mm', $s = 80, $r = 'g', $img = false, $atts = array() ){
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }

    public static function renderAvatar($avatarUrl, $nameFile){
        Image::configure(array('driver' => 'imagick'));

        $image = Image::make($avatarUrl);
        $image->save("dist/img/avatars/{$nameFile}.png");
        return $image->encode('data-url');
    }
}