<?php

namespace Models;
use Includes\hash;
use Includes\terrorhandler;
use PDO;


class User extends Database
{
    use tErrorHandler;

    private $_passed = false;
    private $_errors = array();
    private $_cookieName;

    public $_userRow;

    public function __construct($params = [])
    {
        foreach ($params as $key => $value)
        {
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

    public function userLogin($remember = false)
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
                    $this->addError('wrongpassword', 'Wrong password.');
                    return false;
                }
                else
                {
                    Session::start();
                    Session::set('id', $row->id);

                    if($remember)
                    {
                        $hash = Hash::unique();
                        $hashCheck = $this->CheckRememberme();

                        if(empty($hashCheck)) {
                            $this->rememberMe($hash);
                        }else{
                            $hash = $hashCheck->hash;
                        }

                    Cookie::put($this->_cookieName, $hash, Config::getInstance()->getConfig("remember/cookie_expiry"));

                    }
                    return true;
                }
            }
            else
            {
                $this->addError('wrongusername', 'Wrong username.');
                return false;
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
            $this->addError('userExists', 'Username ' . $this->username . ' is already in database.' );
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
            $this->addError('emailExists','Email ' . $this->email . ' is already in database.' );
        }
    }

    public function showProfile()
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'SELECT fname, lname, email, username  FROM users WHERE id = :id';

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', Session::get('id'));
            $stmt->execute();

            $this->_userRow = $stmt->fetch(PDO::FETCH_OBJ);
        }catch (\PDOException $e){
            $e->getMessage();
        }
    }

    public function getUsername()
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'SELECT username  FROM users WHERE id = :id';

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', Session::get('id'));
            $stmt->execute();

            return $this->_userRow = $stmt->fetch(PDO::FETCH_OBJ);
        }catch (\PDOException $e){
            $e->getMessage();
        }
    }

    public function getPassword()
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'SELECT pwd FROM users WHERE id = :id';

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', Session::get('id'));
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ)->pwd;
        }catch (\PDOException $e){
            $e->getMessage();
        }
    }

    public function updatePassword()
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'UPDATE users SET pwd = :pwd WHERE id = :id';

            $stmt = $conn->prepare($sql);
            $passwordCheck = password_verify($this->pwd_curr, $this->getPassword());
            if (!$passwordCheck)
            {
                $this->addError('pwd', 'Wrong password.');
            }else {
                $hashedPassword = password_hash($this->pwd_new, PASSWORD_DEFAULT);
                $stmt->bindValue(':pwd', $hashedPassword);
                $stmt->bindValue(':id', $_SESSION['id']);
                $stmt->execute();
            }
        }catch (\PDOException $e){
            $e->getMessage();
        }
    }

    public static function deleteAccount()
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'DELETE a.*, b.* FROM users a
                    LEFT JOIN gallery b
                    ON b.uploaderid = a.id
                    WHERE a.id = :id
                    ';

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':id', Session::get('id'));
            $stmt->execute();

        }catch (\PDOException $e){
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
        $conn = Database::getInstance()->getPDO();

        $sql = 'SELECT * FROM remember WHERE user_id = :id';
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":id", Session::get('id'));

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function CheckHashRememberme($hash)
    {
        $conn = Database::getInstance()->getPDO();

        $sql = 'SELECT * FROM remember WHERE hash = :hash';
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":hash", $hash);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public static function DeleteCookie($id)
    {
        $conn = Database::getInstance()->getPDO();

        $sql = 'DELETE FROM remember WHERE user_id = :id';
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":id", $id);

        $stmt->execute();

    }


}