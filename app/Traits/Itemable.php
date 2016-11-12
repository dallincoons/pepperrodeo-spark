<?php
namespace App\Traits;

use App\Item;
use Illuminate\Database\Eloquent\Collection;

Trait Itemable
{
    public function addItem($item)
    {
        if(is_array($item)){
            $item = new Item($item);
        }

        $this->items()->save($item);
    }

    public function addItems($items)
    {
        foreach($items as $item){
            $this->addItem($item);
        }
    }
}