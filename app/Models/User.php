<?php

namespace Models;

use Core\Database;
use Core\Model;
use Includes\Hash;
use Includes\tErrorHandler;
use PDO;


class User extends Model
{
    use tErrorHandler;

    private $_passed = false;
    private $_errors = array();
    private $_cookieName;


    public $_userRow;

    public function __construct($params = [])
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
        $this->_cookieName = Config::getInstance()->getConfig('remember/cookie_name');
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

                $hashedPassword = password_hash($this->data['pwd'], PASSWORD_DEFAULT);

                $stmt->bindValue(':firstname', $this->data['firstname']);
                $stmt->bindValue(':lastname', $this->data['lastname']);
                $stmt->bindValue(':email', $this->data['email']);
                $stmt->bindValue(':username', $this->data['username']);
                $stmt->bindValue(':pwd', $hashedPassword);

                $stmt->execute();

            } catch (\PDOException $e) {
                $e->getMessage();
            }
        }
    }

    public function userLogin($remember = false)
    {
        try {

            $row = $this->loadLogin('users', ['username', 'email'], [$this->data['userOrEmail'], $this->data['userOrEmail']]);
            if (!empty($row)) {
                $passwordCheck = password_verify($this->data['pwd'], $row->data['pwd']);
                if (!$passwordCheck) {
                    $this->addError('wrongpassword', 'Wrong password.');
                    return false;
                } else {
                    Session::start();
                    Session::set('id', $row->data['id']);

                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->CheckRememberme();

                        if (empty($hashCheck)) {
                            $this->rememberMe($hash);
                        } else {
                            $hash = $hashCheck->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::getInstance()->getConfig("remember/cookie_expiry"));

                    }
                    return true;
                }
            } else {
                $this->addError('wrongusername', 'Wrong username.');
                return false;
            }

        } catch (\PDOException $e) {
            $e->getMessage();
        }
    }

    private function UserAlreadyExists()
    {

        $stmt = $this->load('users', 'username', $this->data['username']);

        if (!empty($stmt)) {
            $this->addError('userExists', 'Username ' . $this->data['username'] . ' is already in the database.');
        }
    }

    private function EmailAlreadyExists()
    {

        $stmt = $this->load('users', 'email', $this->data['email']);

        if (!empty($stmt)) {
            $this->addError('emailExists', 'Email ' . $this->data['email'] . ' is already in the database.');
        }
    }

    public function showProfile()
    {
        $this->_userRow = $this->load('users', 'id', Session::get('id'));
    }

    public function getUsername()
    {
        $this->_userRow = $this->load('users', 'id', Session::get('id'));
        return $this->_userRow->data['username'];
    }

    public function getPassword()
    {
        $this->_userRow = $this->load('users', 'id', Session::get('id'));
        return $this->_userRow->data['pwd'];
    }

    public function updatePassword()
    {
        $passwordCheck = password_verify($this->data['pwd_curr'], $this->getPassword());
        if (!$passwordCheck) {
            $this->addError('pwd', 'Wrong password.');
        }
        else {
            $hashedPassword = password_hash($this->data['pwd_new'], PASSWORD_DEFAULT);
            $this->update('users', ['pwd', 'id'], [$hashedPassword, Session::get('id')]);
        }
    }


    public static function deleteAccount()
    {
        try {
            $conn = Database::getInstance()->getPDO();

            $sql = 'DELETE a.*, b.* FROM users a
                    LEFT JOIN gallery b
                    ON b.uploaderid = a.id
                    WHERE a.id = :id
                    ';

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':id', Session::get('id'));
            $stmt->execute();

        } catch (\PDOException $e) {
            $e->getMessage();
        }
    }

    public function rememberMe($hash)
    {
        $conn = Database::getInstance()->getPDO();

        $sql = 'INSERT INTO remember(user_id, hash) VALUES (:id, :hash)';
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":id", Session::get('id'));
        $stmt->bindValue(":hash", $hash);

        $stmt->execute();
    }

    private function CheckRememberme()
    {
        return $this->load('remember', 'user_id', Session::get('id'));
    }

    public static function CheckHashRememberme($hash)
    {
        return self::sload('remember', 'hash', $hash);
    }

    public static function DeleteCookie($id)
    {
        self::sdelete('remember', 'user_id', $id);
    }
}