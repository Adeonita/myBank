<?php

    class UserTest extends TestCase {

       private function mockUser(string $userType) {
            $faker = Faker\Factory::create();

            $type = "COMMON";
            $document = $faker->numerify('###########');
            
            if ($userType === "SHOPKEEPER") {
                $type = "SHOPKEEPER";
                $faker->numerify('##############');
            }

           return [
            "firstName" => $faker->firstName(), 
            "lastName" =>  $faker->lastName(),
            "document" => $document,
            "email" => $faker->email(),
            "password" => $faker->password(),
            "phoneNumber" => $faker->numerify('###########'),
            "type" => $type,
        ]; 

       }
        public function testShouldCreateUser()
        {
            $simpleUser = $this->mockUser("COMMON");
            $shopkeeper = $this->mockUser("SHOPKEEPER");
            
            $this->post('/users', $simpleUser, []);
            $this->post('/users', $shopkeeper, []);

            $this->seeStatusCode(201);
        }
    }
    