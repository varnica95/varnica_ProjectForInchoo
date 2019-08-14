<?php

namespace Models;
use PDO;
class User extends Database
{

    public function __construct($params = [])
    {
        foreach ($params as $key => $value)
        {
            $this->$key = $value;
        }

    }

    public function newUser()
    {
        $conn = Database::getInstance()->getPDO();

        $sql = 'INSERT INTO users(fname, lname, email, username, pwd) VALUES (:firstname, :lastname, :email, :username, :pwd)';
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':firstname', $this->firstname);
        $stmt->bindValue(':lastname', $this->lastname);
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':username', $this->username);
        $stmt->bindValue(':pwd', $this->pwd);

        $stmt->execute();
    }
}