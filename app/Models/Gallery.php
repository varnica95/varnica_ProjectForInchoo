<?php

namespace Models;

use Core\Database;
use Core\Model;

class Gallery extends Model
{
    private $uploaderId;
    private $uploader;
    private $titleGallery;
    private $descGallery;
    private $imgFullNameGallery;

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
        }
        catch (\PDOException $e)
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
        }
        catch (\PDOException $e){
            $e->getMessage();
        }
    }

    public function getUserGallery($uploader)
    {
        return $this->load('gallery', 'uploader', $uploader);
    }

    public static function deleteImage($id)
    {
        self::sdelete('gallery', 'id', $id);
    }

    public static function getImageNames()
    {
        return self::sload('gallery', 'uploaderid', Session::get('id'));
    }

    public static function getNumberOfImages()
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'SELECT * FROM gallery';

            $stmt = $conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }
        catch(\PDOException $e){
            $e->getMessage();
        }
    }

    public static function updateRow($title = [], $desc = [], $id)
    {
        try{
            $conn = Database::getInstance()->getPDO();

            $sql = 'UPDATE gallery SET titleGallery = :titleGallery, descGallery = :descGallery WHERE id = :id';

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':titleGallery', $title);
            $stmt->bindValue(':descGallery', $desc);
            $stmt->bindValue(':id', $id);

            $stmt->execute();

        }
        catch(\PDOException $e){
            $e->getMessage();
        }
    }
}