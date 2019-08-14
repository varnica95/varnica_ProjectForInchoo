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
        var_dump($this->username);
        $conn = Database::getInstance()->getPDO();
        $sql = 'INSERT INTO users(fname, lname, email, username, pwd) VALUES (?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);

        $stmt->execute([$this->firstname, $this->lastname, $this->email, $this->username, $this->pwd]);
    }
}