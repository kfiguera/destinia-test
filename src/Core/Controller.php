<?php
namespace App\Core;
use SimpleCli\Command\Controller as CommandController;
abstract class Controller extends CommandController {
    abstract public function handle();
}
