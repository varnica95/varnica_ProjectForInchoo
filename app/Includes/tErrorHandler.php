<?php


namespace Includes;


trait tErrorHandler
{
    public function isPassed()
    {
        if(empty($this->_errors))
        {
            $this->_passed = true;
        }
    }

    private function addError($key, $error)
    {
        $this->_errors[$key] = $error;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function getPass()
    {
        return $this->_passed;
    }
}