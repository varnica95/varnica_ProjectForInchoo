<?php

namespace Includes;

use Models\User;

class ProfileValidation
{
    use tErrorHandler;
    private $_passed = false,
        $_errors = array();

    public function __construct($params = [])
    {
        foreach ($params as $key => $value)
        {
            $this->$key = $value;

        }
        $this->checkValidation();
    }

    public function emptyFields()
    {
        if(empty($this->pwd_curr) || empty($this->pwd_new) || empty($this->pwd_rep))
        {
            $this->addError('emptyFields', 'Fields cannot be empty. Please fill out empty fields.');
        }
    }

    public function checkPassword()
    {

        if (strlen($this->pwd_new) < 5)
        {
            $this->addError('pwdMin', 'Minimum password lenght is 5.');
        }
        else if(!preg_match("#[0-9]+#", $this->pwd_curr))
        {
            $this->addError('pwdNum','Password must contain a number.');
        }
        else if(!preg_match("#[A-Z]+#", $this->pwd_curr))
        {
            $this->addError('pwdCap', 'Password must contain a capital number.');
        }
        else if ($this->pwd_new !== $this->pwd_rep)
        {
            $this->addError('pwdMatch','Passwords do not match.');
        }
    }

    public function checkValidation()
    {
        $this->emptyFields();
        $this->checkPassword();

        $this->isPassed();
    }
}