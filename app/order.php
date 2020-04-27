<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $guarded = [];

    public function client()
    {
            return $this->belongsTo(Client::class);
    }
    public function products()
    {
            return $this->belongsToMany(Product::class , 'product_order')->withPivot('quantity');

    }
}
