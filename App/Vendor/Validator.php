<?php
/**
 * Created by PhpStorm.
 * User: gregoire
 * Date: 11/09/15
 * Time: 23:04
 */

namespace App\Vendor;


class Validator
{
    private $data;
    private $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    private function getField($field)
    {
        if(!isset($this->data[$field]))
        {
            return null;
        }
        return trim($this->data[$field]);
    }

    public function isAlpha($field, $errorMsg)
    {
        if(!empty($this->getField($field)))
        {
            $fieldstr = Stringly::rm_accent($this->getField($field));
            if (!preg_match('/^[A-Za-z0-9_\\- ]+$/', $fieldstr))
            {
                $this->errors[$field] = $errorMsg;
            }
        }else{
            $this->errors[$field] = $errorMsg;
        }
    }

    /*--------------------------------

    public function isUniq($field, $db, $table, $errorMsg)
    {
        $record = $db->query("SELECT id FROM $table WHERE $field = ?", [$this->getField($field)])->fetch();
        if($record)
        {
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isConfirmed($field, $errorMsg = '') // verif mdp
    {
        if(empty($this->getField($field)) || $this->getField($field) != $this->getField($field . '_confirm'))
        {
            $this->errors[$field] = $errorMsg;
        }
    }

    ------------------------------------------*/

    public function isEmail($field, $errorMsg)
    {
        if(!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL))
        {
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isStreet($field, $errorMsg = '')
    {
        if(!empty($this->getField($field)))
        {
            $fieldstr = Stringly::rm_accent($this->getField($field));
            if (!preg_match('/^[A-Za-z0-9_\\-\' ]+$/', $fieldstr))
            {
                $this->errors[$field] = $errorMsg;
            }
        }else{
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isCity($field, $errorMsg = '')
    {
        if(!empty($this->getField($field)))
        {
            $fieldstr = Stringly::rm_accent($this->getField($field));
            if (!preg_match('/^[A-Za-z_\\- ]+$/', $fieldstr))
            {
                $this->errors[$field] = $errorMsg;
            }
        }else{
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isPotalcode($field, $errorMsg = '')
    {
        if (!preg_match('/^[0-9]{5}$/', $this->getField($field)))
        {
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isPhone($field, $errorMsg){
        $string = str_replace(' ','',$this->getField($field));
        if(!preg_match('/^[0-9]{10}$/',  $string))
        {
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isGroup($field, $errorMsg = '')
    {
        if(empty($this->getField($field)) || $this->getField($field) == 0)
        {
            $this->errors[$field] = $errorMsg;
        }
    }

    public function isValid()
    {
        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}