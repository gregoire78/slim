<?php
//
// Created by Grégoire JONCOUR on 04/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//
namespace App\Controller;

use App\App;
use Slim\Slim;

class Controller
{
    protected $app;
    protected $data;

    public function __construct()
    {
        $this->app = Slim::getInstance();
        $this->data = array();

        $this->data['title'] = '';
        $this->data['breadcrumb'] = array();

        $this->data['css'] = array(
            'internal'  => array(),
            'external'  => array()
        );

        $this->data['js'] = array(
            'internal'  => array(),
            'external'  => array()
        );

        $this->loadBaseCss();
        $this->loadBaseJs();
    }

    public function render($page, $data=null)
    {
        $this->data['app'] = $this->app;
        if($data){extract($data);};
        ob_start();
        include "App/View/{$page}View.php";
        $this->data['content'] = ob_get_clean();
        $this->app->render('layout.php', $this->data);
    }

    protected function loadCss($css, $options=array())
    {
        $location = (isset($options['location'])) ? $options['location']:'internal';
        //after:file, before:file, first, last
        $position = (isset($options['position'])) ? $options['position']:'last';
        if(!in_array($css,$this->data['css'][$location])){
            if($position=='first' || $position=='last'){
                $key = $position;
                $file='';
            }else{
                list($key,$file) =  explode(':',$position);
            }
            switch($key){
                case 'first':
                    array_unshift($this->data['css'][$location],$css);
                    break;
                case 'last':
                    $this->data['css'][$location][]=$css;
                    break;
                case 'before':
                case 'after':
                    $varkey = array_keys($this->data['css'][$location],$file);
                    if($varkey){
                        $nextkey = ($key=='after') ? $varkey[0]+1 : $varkey[0];
                        array_splice($this->data['css'][$location],$nextkey,0,$css);
                    }else{
                        $this->data['css'][$location][]=$css;
                    }
                    break;
            }
        }
    }

    protected function loadJs($js, $options=array())
    {
        $location = (isset($options['location'])) ? $options['location']:'internal';
        //after:file, before:file, first, last
        $position = (isset($options['position'])) ? $options['position']:'last';
        if(!in_array($js,$this->data['js'][$location])){
            if($position=='first' || $position=='last'){
                $key = $position;
                $file='';
            }else{
                list($key,$file) =  explode(':',$position);
            }
            switch($key){
                case 'first':
                    array_unshift($this->data['js'][$location],$js);
                    break;
                case 'last':
                    $this->data['js'][$location][]=$js;
                    break;
                case 'before':
                case 'after':
                    $varkey = array_keys($this->data['js'][$location],$file);
                    if($varkey){
                        $nextkey = ($key=='after') ? $varkey[0]+1 : $varkey[0];
                        array_splice($this->data['js'][$location],$nextkey,0,$js);
                    }else{
                        $this->data['js'][$location][]=$js;
                    }
                    break;
            }
        }
    }

    protected function resetCss()
    {
        $this->data['css']         = array(
            'internal'  => array(),
            'external'  => array()
        );
    }

    protected function resetJs()
    {
        $this->data['js']         = array(
            'internal'  => array(),
            'external'  => array()
        );
    }

    protected function removeCss($css)
    {
        $key=array_keys($this->data['css']['internal'],$css);
        if($key){
            array_splice($this->data['css']['internal'],$key[0],1);
        }
        $key=array_keys($this->data['css']['external'],$css);
        if($key){
            array_splice($this->data['css']['external'],$key[0],1);
        }
    }

    protected function removeJs($js)
    {
        $key=array_keys($this->data['js']['internal'],$js);
        if($key){
            array_splice($this->data['js']['internal'],$key[0],1);
        }
        $key=array_keys($this->data['js']['external'],$js);
        if($key){
            array_splice($this->data['js']['external'],$key[0],1);
        }
    }

    protected function loadBaseCss()
    {
        $this->loadCss(ROOT."dist/css/bootstrap.min.css",['location' => 'external', 'position'=>'first']);
        $this->loadCss("style.css",['position'=>'after:dist/css/bootstrap.min.css']);
        //$this->loadCss("jquery.mCustomScrollbar.css",['position'=>'after:dist/css/style.css']);
    }

    protected function loadBaseJs()
    {
        $this->loadJs("jquery-2.1.4.min.js",['position'=>'first']);
        $this->loadJs(ROOT."bootstrap-3.3.5-dist/js/bootstrap.min.js",['location' => 'external', 'position'=>'after:jquery-2.1.4.min.js']);
        //$this->loadJs("jquery.mCustomScrollbar.concat.min.js",['position'=>'after:'.ROOT.'bootstrap-3.3.5-dist/js/bootstrap.min.js']);
    }

    public function loadModel($model_name)
    {
        $this->$model_name = App::getInstance()->getTable($model_name);
    }
}