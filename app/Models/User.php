<?php

namespace Models;

class User extends Database
{

    public function __construct($params = [])
    {
        foreach ($params as $key => $value)
        {
            $this->key = $value;
        }
    }

    public function newUser()
    {
        $conn = DB::getInstance();

        $sql = 'INSERT INTO users(fname, lname, email, username, pwd) VALUES (?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($sql);

        $stmt->execute([]);
    }
}