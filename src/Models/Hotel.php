<?php

namespace App\Models;
use \App\Core\Model;
use PDO;

class Hotel extends Model {

    public $table = 'hotels';

    public function __construct(){
        parent::__construct();
    }

    public function getHotelData($value){
        $sql = "SELECT ".$this->table.".name, stars, room_types.name as room_type, cities.name as city, states.name as state
                FROM ".$this->table." 
                JOIN room_types ON (".$this->table.".room_type_id = room_types.id)
                JOIN cities ON (".$this->table.".city_id = cities.id)
                JOIN states ON (".$this->table.".state_id = states.id) 
                WHERE ".$this->table." .id = ?";


        $gsent = $this->pdo->prepare($sql);
        $gsent->bindParam(1, $value, PDO::PARAM_INT);
        $gsent->execute();
        $data = $gsent->fetch();
        return $data;
    }

}