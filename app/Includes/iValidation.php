<?php

namespace Includes;

interface iValidation
{
    public function emptyFields();
    public function checkFirstLastName();
    public function checkUsername();
    public function checkEmail();
    public function checkPassword();

}
