<?php

namespace Models;
use PDO;

class Database
{
    private static $_instance = NULL;
    private $_pdo,
        $_error = false,
        $_query,
        $_results;

    private function __construct()
    {
        try{
            $this->_pdo = new \PDO(
                'mysql:host='. Config::getInstance()->getConfig("mysql/host").
                ';dbname=' . Config::getInstance()->getConfig("mysql/db") . ';',
                Config::getInstance()->getConfig("mysql/username"),
                Config::getInstance()->getConfig("mysql/password")
            );
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }
    public static function getInstance()
    {
        if(!isset(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function query($sql, $params = array())
    {
        $this->_error = false;
        $this->_query = $this->_pdo->prepare($sql);
        if ($this->_query) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
                if($this->_query->execute())
                {
                    $this->_results = $this->_query->fetch(PDO::FETCH_OBJ);
                    $this->_count = $this->_query->rowCount();
                }
                else{
                    $this->_error = true;
                }
            }
        }
        return $this;
    }

    public function result()
    {
        return $this->_results;
    }
}