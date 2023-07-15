<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected  $appends = ['price'];

    public function getPriceAttribute(){
        if($this->price_sale)
            return $this->price_sale;
        return $this->price_regular;
    }
}
