<?php

namespace App\Core;

use PDO;

/**
 * Database class
 */
abstract class Model
{

    public $table;
    public $pdo;
    /**
     * __construct function
     */
    public function __construct()
    {

        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo = $pdo;
    }

    public function all(){
        $sql = "SELECT * FROM " . $this->table;
        $data = $this->pdo->query($sql)->fetchAll();
        return $data;
    }

    public function findById($value){
        $sql = "SELECT * FROM ".$this->table." WHERE id = ?";

        $gsent = $this->pdo->prepare($sql);
        $gsent->bindParam(1, $value, PDO::PARAM_INT);
        $gsent->execute();
        $data = $gsent->fetch();
        return $data;
    }
}
