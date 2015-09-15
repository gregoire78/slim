<?php
//
// Created by Grégoire JONCOUR on 09/04/2015.
// Copyright (c) 2015 Grégoire JONCOUR. All rights reserved.
//
namespace Core\Entity;

class Entity
{
    public function __get($key)
    {
        $method = 'get'.ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }
}