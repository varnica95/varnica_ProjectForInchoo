CREATE DATABASE sharedgallery;

CREATE TABLE users(
    id int(11) AUTO_INCREMENT PRIMARY KEY,
    fname TINYTEXT,
    lname TINYTEXT,
    email TINYTEXT,
    username TINYTEXT,
    pwd LONGTEXT
);

CREATE TABLE gallery(
    id int(11) AUTO_INCREMENT PRIMARY KEY,
    uploaderid int(11),
    uploader TINYTEXT,
    titleGallery LONGTEXT,
    descGallery LONGTEXT,
    imgFullNameGallery LONGTEXT
);

CREATE TABLE remember(
    id int(11) AUTO_INCREMENT PRIMARY KEY,
    user_id int(11),
    hash LONGTEXT
);
