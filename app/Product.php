<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
class Product extends Model
{

    use \Dimsav\Translatable\Translatable;

    protected $guarded = [];
    public $translatedAttributes = ['name','description'];
    protected $appends = ['image_path' , 'profit_price'];

    public function getImagePathAttribute(){

        return asset('uploads/product_image/'.$this->image);


    }
       public function getProfitPriceAttribute()
       {
         $profit = $this->sale_price  - $this->purchase_price;
             $profit_price = ($profit * 100) / $this->purchase_price;

             return  number_format($profit_price,2) ;
       }
       public function Category()
       {
               return $this->belongsTo(Category::class);
       }
       public function orders()
       {
               return $this->belongsToMany(order::class , 'product_order');

       }
}
