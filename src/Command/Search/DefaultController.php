<?php

namespace App\Command\Search;

use App\Models\Listing;
use App\Core\Controller;


class DefaultController extends Controller
{
    public function handle()
    {
        $name = $this->hasParam('name') ? $this->getParam('name') : '';
        $name = substr($name, 0, 3);
        $listing = new Listing();
        $rows = ($name != '') ? $listing->findByName($name) :$listing->all();
        foreach ($rows as $row) {
            $line = $listing->getListingDetail($row['related_id'],$row['type']);
            $print = implode(",", $line);
            $this->getPrinter()->out($print);
            $this->getPrinter()->newline();
        }
    }
}