<?php

    class UserTest extends TestCase {

        private function mockUser(string $userType) 
        {
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

            $response = $this->call('POST', '/users', $simpleUser);
            $json = $this->response->json();

            $this->assertEquals(201, $response->status());
            $this->assertArrayHasKey('userId', $json);
        }

        public function testShoudReturnUserList()
        {
            $user = $this->mockUser("COMMON");
            $this->post('/users', $user);

            $this->json(
                'GET', 
                '/users',
                [
                    "firstName" => $user["firstName"],
                    "lastName" => $user["lastName"],
                    "document" => $user["document"],
                    "email" => $user["email"],
                    "phoneNumber" => $user["phoneNumber"],
                    "type" => $user["type"]
                ] 
            )->seeJson(
                [
                    "firstName" => $user["firstName"],
                    "lastName" => $user["lastName"],
                    "document" => $user["document"],
                    "email" => $user["email"],
                    "phoneNumber" => $user["phoneNumber"],
                    "type" => $user["type"]
                ]
            )->seeStatusCode(200);
        }
    }
    