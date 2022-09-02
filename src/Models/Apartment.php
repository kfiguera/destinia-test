<?php

namespace App\Models;
use \App\Core\Model;
use PDO;

class Apartment extends Model {

    public $table = 'apartments';

    public function __construct(){
        parent::__construct();
    }
    public function all(){
        $sql = "SELECT * FROM " . $this->table;
        $data = $this->pdo->query($sql)->fetchAll();
        return $data;
    }

    public function getApartmentData($value){
        $sql = "SELECT ".$this->table.".name, quantity, capacity, cities.name as city, states.name as state
                FROM ".$this->table." 
                JOIN cities ON (".$this->table.".city_id = cities.id)
                JOIN states ON (".$this->table.".state_id = states.id) 
                WHERE ".$this->table.".id = ?";
        $gsent = $this->pdo->prepare($sql);
        $gsent->bindParam(1, $value, PDO::PARAM_INT);
        $gsent->execute();
        $data = $gsent->fetch();
        return $data;
    }

}