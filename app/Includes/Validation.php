<?php

namespace Includes;

class Validation implements iValidation
{
    use tErrorHandler;

    private $_passed = false;
    private $_errors = array();

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
        if(empty($this->firstname) || empty($this->lastname) || empty($this->email) ||
            empty($this->username) || empty($this->pwd) || empty($this->pwdRepeat))
        {
            $this->addError('emptyFields', 'Fields cannot be empty. Please fill out empty fields.');
        }
    }

    public function checkFirstLastName()
    {
        if (!preg_match("/^([a-zA-Z' ]+)$/", $this->firstname) ||
            !preg_match("/^([a-zA-Z' ]+)$/", $this->lastname))
        {
            $this->addError('flName', 'Please enter a valid first name or last name.');
        }
    }

    public function checkUsername()
    {
        if (strlen($this->username) < 5)
        {
            $this->addError('username', 'Minimum username lenght is 5.');
        }
        else if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username))
        {
            $this->addError('username', 'Please enter a valid username.');
        }
    }

    public function checkEmail()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            $this->addError('email', 'Please enter a valid email.');
        }
    }

    public function checkPassword()
    {
        if (strlen($this->pwd) < 5)
        {
            $this->addError('pwd', 'Minimum password lenght is 5.');
        }
        else if(!preg_match("#[0-9]+#", $this->pwd))
        {
            $this->addError('pwd','Password must contain a number.');
        }
        else if(!preg_match("#[A-Z]+#", $this->pwd))
        {
            $this->addError('pwd', 'Password must contain a capital number.');
        }
        else if ($this->pwd !== $this->pwdRepeat)
        {
            $this->addError('pwd','Passwords do not match.');
        }
    }

    public function checkValidation()
    {
        $this->emptyFields();
        $this->checkFirstLastName();
        $this->checkEmail();
        $this->checkUsername();
        $this->checkPassword();

        $this->isPassed();
    }

}