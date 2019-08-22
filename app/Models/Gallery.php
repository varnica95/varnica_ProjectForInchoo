<?php

namespace Models;

class Gallery extends Database
{
    private $uploaderId, $uploader,
        $titleGallery, $descGallery,
        $imgFullNameGallery;

    public function __construct($id, $uploader, $title, $desc, $imageFullname)
    {
        $this->uploaderId = $id;
        $this->uploader = $uploader;
        $this->titleGallery = $title;
        $this->descGallery = $desc;
        $this->imgFullNameGallery = $imageFullname;
    }

    public function uploadImage()
    {

        try {
            $conn = Database::getInstance()->getPDO();

            $sql = 'INSERT INTO gallery (uploaderid, uploader, titleGallery, descGallery, imgFullNameGallery)
                VALUES(:uploaderid, :uploader, :titleGallery, :descGallery, :imgFullNameGallery )';

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':uploaderid', $this->uploaderId);
            $stmt->bindValue(':uploader', $this->uploader);
            $stmt->bindValue(':titleGallery', $this->titleGallery);
            $stmt->bindValue(':descGallery', $this->descGallery);
            $stmt->bindValue(':imgFullNameGallery', $this->imgFullNameGallery);

            $stmt->execute();
        }catch (\PDOException $e)
        {
            $e->getMessage();
        }
    }

    public static function getGallery()
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'SELECT * FROM gallery ORDER BY id DESC';

            $stmt = $conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }catch (\PDOException $e){
            $e->getMessage();
        }
    }

    public static function getUserGallery($uploader)
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'SELECT * FROM gallery WHERE uploader = :uploader ORDER BY id DESC';

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':uploader', $uploader);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }catch (\PDOException $e){
            $e->getMessage();
        }
    }

    public static function deleteImage($id)
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'DELETE FROM gallery WHERE id = :id';

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':id', $id);
            $stmt->execute();

        }catch (\PDOException $e){
            $e->getMessage();
        }
    }

    public static function getImageNames()
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'SELECT * FROM gallery WHERE uploaderid = :uploaderid';

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':uploaderid', Session::get('id'));
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }catch (\PDOException $e)
        {
            $e->getMessage();
        }
    }

    public static function getNumberOfImages()
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'SELECT * FROM gallery';

            $stmt = $conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }catch(\PDOException $e){
            $e->getMessage();
        }
    }

    public static function updateRow($title, $desc, $id)
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'UPDATE gallery SET titleGallery = :titleGallery AND descGallery = :descGallery WHERE id = :id';

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':titleGallery', $title);
            $stmt->bindValue(':descGallery', $desc);
            $stmt->bindValue(':id', $id);

            $stmt->execute();

        }catch(\PDOException $e){
            $e->getMessage();
        }
    }
}