<?php

namespace App\Models;

use \App\Core\Model;
use Exception;
use PDO;

class Listing extends Model
{

    public $table = 'listings';

    public function __construct()
    {
        parent::__construct();
    }

    public function findByName($name)
    {
        $value = "%$name%";
        $sql = "SELECT listings.id, name, type, related_id
                FROM listings
                JOIN hotels ON (listings.related_id = hotels.id AND listings.type ='hotels')
                WHERE LCASE(name) like :value
                UNION
                SELECT listings.id, name, type, related_id
                FROM listings
                JOIN apartments ON (listings.related_id = apartments.id AND listings.type ='apartments')
                WHERE LCASE(name) like :value";
        $gsent = $this->pdo->prepare($sql);
        $gsent->bindParam(':value', $value);
        $gsent->execute();
        $data = $gsent->fetchAll();
        return $data;
}

    public function getListingDetail($id, $type)
    {
        if ($type == 'hotels') {
            $model = new Hotel();
            $data = $model->getHotelData($id);
            return [
                'name' => $data['name'],
                'stars' => $data['stars'],
                'room_type' => $data['room_type'],
                'city' => $data['city'],
                'state' => $data['state'],
            ];
        } else {


            $model = new Apartment();
            $data = $model->getApartmentData($id);

            return [
                'name' => $data['name'],
                'quantity' => $data['quantity'],
                'capacity' => $data['capacity'],
                'city' => $data['city'],
                'state' => $data['state'],
            ];
        }

    }

    public function create($data)
    {
        list($type, $related_id) = $data;
        try {
            $this->pdo->beginTransaction();
            $sql = "INSERT INTO " . $this->table . " (type, related_id) 
                    VALUES (:type, :related_id)";

            $gsent = $this->pdo->prepare($sql);
            $gsent->bindParam(':type', $type, PDO::PARAM_STR);
            $gsent->bindParam(':related_id', $related_id, PDO::PARAM_INT);
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