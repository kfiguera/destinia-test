<?php

namespace App\Command\Config;

use App\Core\Model;
use App\Models\Config;
use App\Models\Listing;
use App\Core\Controller;


class InstallController extends Controller
{
    public function handle()
    {
        $path = __DIR__ . '/../../../bd/config_install.sql';
        $sql = file_get_contents($path);
        $model = new Config();
        $validate = $model->create($sql);
        $message = '';
        ($validate) ? $message = 'Tablas creadas correctamente' : $message = 'Error al crear las tablas';
        $this->getPrinter()->display($message);
    }
}