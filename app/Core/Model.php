<?php


namespace Core;
use PDO;

class Model
{
    protected $data = [];
    protected $conn;
    protected static $sconn;

    public function __construct()
    {

    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function getData(){
        return $this->data;
    }

    public function load($tableName, $field, $value)
    {
        try {
            $this->conn = Database::getInstance()->getPDO();
            $sql = "SELECT * FROM {$tableName} WHERE {$field} = '{$value}'";

            $row = $this->conn->query($sql);

            $row->setFetchMode(PDO::FETCH_CLASS, __CLASS__);

            return $row->fetch();
        }
        catch (\PDOException $e)
        {
            $e->getMessage();
        }
    }

    public static function sload($tableName, $field, $value)
    {
        try {
            self::$sconn = Database::getInstance()->getPDO();
            $sql = "SELECT * FROM {$tableName} WHERE {$field} = '{$value}'";

            $row = self::$sconn->query($sql);

            $row->setFetchMode(PDO::FETCH_CLASS, __CLASS__);

            return $row->fetchAll();
        }
        catch (\PDOException $e)
        {
            $e->getMessage();
        }
    }

    public function loadLogin($tableName, $fields = [], $values = [])
    {
        try {
            $this->conn = Database::getInstance()->getPDO();
            $sql = "SELECT * FROM {$tableName} WHERE {$fields[0]} = '{$values[0]}' OR {$fields[1]} = '{$values[1]}'";

            $row = $this->conn->query($sql);

            $row->setFetchMode(PDO::FETCH_CLASS, __CLASS__);

            return $row->fetch();
        }
        catch (\PDOException $e)
        {
            $e->getMessage();
        }
    }

    public function update($tableName, $fields = [], $values = [])
    {
        try {
            $this->conn = Database::getInstance()->getPDO();

            $sql = "UPDATE {$tableName} SET {$fields[0]} = '{$values[0]}' WHERE {$fields[1]} = '{$values[1]}'";

            $row = $this->conn->query($sql);

            $row->setFetchMode(PDO::FETCH_CLASS, __CLASS__);

            return $row->fetch();
        }
        catch (\PDOException $e)
        {
            $e->getMessage();
        }
    }

    public function delete($tableName, $field, $value)
    {
        try {
            $this->conn = Database::getInstance()->getPDO();
            $sql = "DELETE FROM {$tableName} WHERE {$field} = '{$value}'";

            $row = $this->conn->query($sql);

            $row->setFetchMode(PDO::FETCH_CLASS, __CLASS__);

            return $row->fetch();
        }
        catch (\PDOException $e)
        {
            $e->getMessage();
        }
    }

    public static function sdelete($tableName, $field, $value)
    {
        try {
           self::$sconn = Database::getInstance()->getPDO();
            $sql = "DELETE FROM {$tableName} WHERE {$field} = '{$value}'";

            $row = self::$sconn->query($sql);

            $row->setFetchMode(PDO::FETCH_CLASS, __CLASS__);

            return $row->fetch();
        }
        catch (\PDOException $e)
        {
            $e->getMessage();
        }
    }

}