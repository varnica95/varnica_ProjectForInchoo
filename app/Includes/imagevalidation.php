<?php


namespace Includes;


class ImageValidation
{
    use terrorhandler;

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
        if(empty($this->filename) || empty($this->filetitle) || empty($this->filedesc))
        {
            $this->addError('emptyFields', 'Fields cannot be empty. Please fill out empty fields.');
        }
    }

    public function tooLong()
    {
        if(strlen($this->filename) >= 25 || strlen($this->filetitle) >= 25)
        {
            $this->addError('tooLong', 'Fields are too long. Maximum 25 characters.');
        }
    }

    public function checkValidation()
    {
        $this->emptyFields();
        $this->tooLong();
        $this->isPassed();
    }
}