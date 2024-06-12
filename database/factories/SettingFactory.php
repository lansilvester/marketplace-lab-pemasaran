<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email'=>'admin@admin',
            'phone'=>'123',
            'phone2'=>'1234',
            'address'=>'Buha, Kota Manado',
            'map'=>'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.417764198283!2d124.88182792734094!3d1.5181826953515603!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3287a06a89181dc1%3A0x2457fc5201e05955!2sPoliteknik%20Negeri%20Manado!5e0!3m2!1sid!2sid!4v1656796069617!5m2!1sid!2sid',
            'twitter'=>'#',
            'facebook'=>'#',
            'pinterest'=>'#',
            'instagram'=>'#',
            'youtube'=>'#',
        ];
    }
}
