<?php
//
// Created by Grégoire JONCOUR on 05/09/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//

namespace App;

use Core\Database\MysqlDatabase;
class App
{
    private static $_instance;
    private $db_instance;

    public static function getInstance()
    {
        if(is_null(self::$_instance))
        {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    public function getData($name)
    {
        $class_name = '\\App\\Model\\'.ucfirst($name).'Model';
        return new $class_name();
    }

    public function getTable($name)
    {
        $class_name = '\\App\\Table\\'.ucfirst($name).'Table';
        return new $class_name($this->getDb());
    }

    public function getDb()
    {
        if(is_null($this->db_instance))
        {
            //$this->db_instance = new MysqlDatabase('b5nuwo12','b5nuwo12','slim','sql2.olympe.in');
            $this->db_instance = new MysqlDatabase('slim');
        }
        return $this->db_instance;
    }
}