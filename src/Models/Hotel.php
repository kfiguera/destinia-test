<?php

namespace App\Models;

use \App\Core\Model;
use Exception;
use PDO;

class Hotel extends Model
{

    public $table = 'hotels';

    public function __construct()
    {
        parent::__construct();
    }

    public function getHotelData($value)
    {
        $sql = "SELECT " . $this->table . ".name, stars, room_types.name as room_type, cities.name as city, states.name as state
                FROM " . $this->table . " 
                JOIN room_types ON (" . $this->table . ".room_type_id = room_types.id)
                JOIN cities ON (" . $this->table . ".city_id = cities.id)
                JOIN states ON (" . $this->table . ".state_id = states.id) 
                WHERE " . $this->table . " .id = ?";


        $gsent = $this->pdo->prepare($sql);
        $gsent->bindParam(1, $value, PDO::PARAM_INT);
        $gsent->execute();
        $data = $gsent->fetch();
        return $data;
    }

    public function create($data)
    {
        list($name, $stars, $room_type, $city, $state) = $data;
        try {
            $this->pdo->beginTransaction();
            $sql = "INSERT INTO " . $this->table . " 
                    (name, stars, room_type_id, city_id, state_id) 
                    VALUES (:name, :stars, :room_type, :city, :state)";

            $gsent = $this->pdo->prepare($sql);
            $gsent->bindParam(':name', $name, PDO::PARAM_STR);
            $gsent->bindParam(':stars', $stars, PDO::PARAM_INT);
            $gsent->bindParam(':room_type', $room_type, PDO::PARAM_INT);
            $gsent->bindParam(':city', $city, PDO::PARAM_INT);
            $gsent->bindParam(':state', $state, PDO::PARAM_INT);
            $gsent->execute();

            $id = $this->pdo->lastInsertId();

            $this->pdo->commit();
            $return = $this->findById($id);
            return $return;

        } catch (Exception $e) {
            $this->pdo->rollback();
            throw $e;
        }

    }

}