<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopkeeperFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "firstName" => $this->faker->firstName(), 
            "lastName" =>  $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail,
            'document' => $this->faker->numerify('###########'), 
            'email' => $this->faker->email() , 
            'password'=> $this->faker->password() , 
            'phoneNumber'=> $this->faker->numerify('###########') , 
            'type' => ('SHOPKEEPER'),
        ];
    }
}

