<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HomeSliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>'Slider 1',
            'subtitle'=>'Slider 1',
            'link'=>'https://polimdo.ac.id',
            'image'=>'slider-1.jpg',
            'status'=>true,
        ];
    }
}
