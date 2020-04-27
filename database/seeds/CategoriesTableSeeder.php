<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Categories = ['cat_one','cat_two','cat_three'];

        foreach($Categories as $Category) {

            Category::create([

                'ar' => ['name' => $Category],
                'en' => ['name' => $Category],

                ]);
        }




    }
}
