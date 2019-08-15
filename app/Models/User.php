<?php

namespace Models;
use PDO;
class User extends Database
{

    private $_passed = false,
            $_errors = array();

    public function __construct($params = [])
    {
        foreach ($params as $key => $value)
        {
            $this->$key = $value;
        }

    }

    public function newUser()
    {
        $this->UserAlreadyExists();
        $this->EmailAlreadyExists();

        $this->isPassed();

        if ($this->getPass()) {
            try {
                $conn = Database::getInstance()->getPDO();

                $sql = 'INSERT INTO users(fname, lname, email, username, pwd) 
                VALUES (:firstname, :lastname, :email, :username, :pwd)';
                $stmt = $conn->prepare($sql);

                $hashedPassword = password_hash($this->pwd, PASSWORD_DEFAULT);;

                $stmt->bindValue(':firstname', $this->firstname);
                $stmt->bindValue(':lastname', $this->lastname);
                $stmt->bindValue(':email', $this->email);
                $stmt->bindValue(':username', $this->username);
                $stmt->bindValue(':pwd', $hashedPassword);

                $stmt->execute();
            } catch (\PDOException $e) {
                $e->getMessage();
            }
        }else{
            var_dump($this->getErrors());
        }
    }

    private function UserAlreadyExists()
    {
        $conn = Database::getInstance()->getPDO();

        $sql = 'SELECT * FROM users WHERE username = :username';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $this->username);
        $stmt->execute();

        if ($stmt->rowCount() > 0)
        {
            $this->addError('Username ' . $this->username . ' is already in database.' );
        }
    }

    private function EmailAlreadyExists()
    {
        $conn = Database::getInstance()->getPDO();

        $sql = 'SELECT * FROM users WHERE email = :email';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0)
        {
            $this->addError('Email ' . $this->email . ' is already in database.' );
        }
    }

    private function isPassed()
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
}