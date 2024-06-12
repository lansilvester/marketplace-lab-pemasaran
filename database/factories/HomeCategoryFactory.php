<?php

namespace Database\Factories;

use App\Models\HomeCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomeCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = HomeCategory::class;
    public function definition()
    {
        return [
            'sel_categories'=>'Minuman Lokal',
            'no_of_products'=>100,
            'created_at'=> now()
        ];
    }


}
