<?php

namespace App\Command\Tables;

use App\Models\Apartment;
use App\Core\Controller;


class ApartmentController extends Controller
{
    public function handle()
    {
        $listing = new Apartment();
        $rows = $listing->all();
        foreach ($rows as $row) {
            $print = implode(",", $row);
            $this->getPrinter()->display(sprintf($print));
        }
        $one = $listing->findById(1);

        $one = implode(",", $one);
        $this->getPrinter()->display(sprintf($one));

    }
}