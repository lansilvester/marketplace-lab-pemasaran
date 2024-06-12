<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=> 1,
            'image'=> 'default.jpg',
            'mobile'=>'',
            'facebook'=>'',
            'instagram'=>'',
            'city'=>'Manado',
            'province'=>'Sulawesi Utara',
            'country'=>'Indonesia',
            'zipcode'=>95115,
            'created_at'=>now(),
        ];
    }
}
