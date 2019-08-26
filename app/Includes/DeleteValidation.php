<?php


namespace Includes;


class DeleteValidation
{
    use tErrorHandler;

    private $_passed = false;
    private $_errors = array();

    public function __construct($params = [])
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;

        }
        $this->checkValidation();
    }

    public function emptyFields()
    {
        if (empty($this->pwd)) {
            $this->addError('emptyFields', 'Fields cannot be empty. Please fill out empty fields.');
        }
    }

    public function checkValidation()
    {
        $this->emptyFields();
        $this->isPassed();
    }
}