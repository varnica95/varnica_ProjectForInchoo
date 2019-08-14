<?php

namespace Includes;

class Validation
{
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
        if(empty($this->firstname) || empty($this->lastname) || empty($this->email) ||
            empty($this->username) || empty($this->pwd) || empty($this->pwdRepeat))
        {
            $this->addError('Fields cannot be empty. Please fill out empty fields.');
        }
    }

    public function checkFirstLastName()
    {
        if (!preg_match("/^([a-zA-Z' ]+)$/", $this->firstname) ||
            !preg_match("/^([a-zA-Z' ]+)$/", $this->lastname))
        {
            $this->addError('Please enter a valid first name or last name.');
        }
    }

    public function checkUsername()
    {
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username))
        {
            $this->addError('Please enter a valid username.');
        }
    }

    public function checkEmail()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            $this->addError('Please enter a valid email.');
        }
    }

    public function checkPassword()
    {
        if ($this->pwd !== $this->pwdRepeat)
        {
            $this->addError('Passwords do not match.');
        }
    }

    public function isPassed()
    {
        if(empty($this->_errors))
        {
            $this->_passed = true;
        }
    }
    private function addError($error)
    {
        $this->_errors[] = $error;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function getPass()
    {
        return $this->_passed;
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