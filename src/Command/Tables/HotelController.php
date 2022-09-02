<?php

namespace App\Command\Tables;

use App\Models\Hotel;
use App\Core\Controller;


class HotelController extends Controller
{
    public function handle()
    {
        $listing = new Hotel();
        $rows = $listing->all();
        foreach ($rows as $row) {
            $print = implode(",", $row);
            $this->getPrinter()->display(sprintf($print));
        }

    }
}