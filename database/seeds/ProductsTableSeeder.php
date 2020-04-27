<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Products = ['pro_one','pro_two','pro_three'];

        foreach($Products as $Product) {

            Product::create([
                'category_id' => 1,
                'ar' => ['name' => $Product , 'description' =>  $Product . 'desc'],
                'en' => ['name' => $Product , 'description' =>  $Product . 'desc'],
                'purchase_price' => 120,
                'sale_price' => 150,
                'stoke' => 100,
                ]);
        }
    }
}
