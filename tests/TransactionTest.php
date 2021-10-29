<?php

use App\Services\WalletService;
use App\Repositories\WalletRepository;

class TransactionTest extends TestCase
{
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

    public function testShouldReturnStatusCode400()
    {
        $simpleUser = $this->mockUser("COMMON");
        $shopkeeperUser = $this->mockUser("SHOPKEEPER");

        $payerId = ($this->post('/users', $simpleUser))->response->json()['userId'];
        $payeeId = ($this->post('/users', $shopkeeperUser))->response->json()['userId'];

        $response = $this->call(
            'POST',
            '/transactions',
            [
                'payer' => $payerId,
                'payee' => $payeeId,
                'value' => 1.00,
            ] 
        );

        $this->assertEquals(400, $response->status());
    }

    public function testShouldReturnStatusCode201()
    {
        $simpleUser = $this->mockUser("COMMON");
        $shopkeeperUser = $this->mockUser("SHOPKEEPER");

        $payerId = ($this->post('/users', $simpleUser))->response->json()['userId'];
        $payeeId = ($this->post('/users', $shopkeeperUser))->response->json()['userId'];

        $walletRepository = new WalletRepository();

        $walletRepository->updateBalance($payerId, 100.00);

        $response = $this->call(
            'POST',
            '/transactions',
            [
                'payer' => $payerId,
                'payee' => $payeeId,
                'value' => 1.00,
            ] 
        );

        $this->assertEquals(201, $response->status());
    }
}