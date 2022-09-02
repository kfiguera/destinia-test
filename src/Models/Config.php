<?php

namespace App\Models;

use \App\Core\Model;
use Exception;
use PDO;

class Config extends Model
{

    public $table = 'config';

    public function __construct()
    {
        parent::__construct();
    }

    public function create($sql) {
            $gsent = $this->pdo->prepare($sql);
            $gsent->execute();
            return true;
    }

}