<?php


namespace Includes;


class ImageValidation
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
        if(empty($this->filename) || empty($this->filetitle) || empty($this->filedesc))
        {
            $this->addError('emptyFields', 'Fields cannot be empty. Please fill out empty fields.');
        }
    }

    public function checkValidation()
    {
        $this->emptyFields();
        $this->isPassed();
    }
}