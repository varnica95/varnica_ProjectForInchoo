<?php

namespace Models;
use PDO;

session_start();

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

                $hashedPassword = password_hash($this->pwd, PASSWORD_DEFAULT);

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

    public function userLogin()
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'SELECT * FROM users WHERE username = :username OR email = :email';
            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':username', $this->userOrEmail);
            $stmt->bindValue(':email', $this->userOrEmail);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_OBJ);
            if ($stmt->rowCount() > 0)
            {
                $passwordCheck = password_verify($this->pwd, $row->pwd);
                if (!$passwordCheck)
                {
                    $this->addError('Wrong password');
                }
                else
                {
                    Session::start();
                    Session::set($row);
                }
            }
            else
            {
                $this->addError('Wrong username');
            }

        }catch (\PDOException $e){
            $e->getMessage();
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

    public function updateProfile()
    {
        if( password_verify($this->pwd, Session::get('pwd'))){
            $this->addError('Passwords do not match.');
        }else {
            echo "tu sam";
            $conn = Database::getInstance()->getPDO();

            $sql = 'UPDATE users SET pwd = :pwd WHERE id = :id';

            $stmt = $conn->prepare($sql);

            $hashedPassword = password_hash($this->pwd, PASSWORD_DEFAULT);

            $stmt->bindValue(':pwd', $hashedPassword);
            $stmt->bindValue(':id', Session::get('id'));
            $stmt->execute();
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