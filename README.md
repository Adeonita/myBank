# My Bank

Api RESTFULL em lumen que simula uma transação bancária entre dois usuários.

- Regras
    - Um usuário do tipo COMMON poderá realizar transações para outro usuário do tipo COMMON ou para um SHOPKEEPER
    - Um SHOPKEEPER não pode realizar transações, apenas receber

## Requisitos 
- php 7.*
- mysql 
- insomnia ou postman


## Como rodar

 - Realize clone do projeto na sua máquina
 - Crie o banco de dados com o nome my_bank 
 - Na raiz do projeto: 
    - Insira o arquivo .env enviado
    - Execute o comando `composer install` para realizar a instalação das dependencias
    - Execute o comando php artisan migrate, para instalar as migrações
    - Execute o comando php artisan db:seed, para povoar o banco de dados 
 - Execute o comando php queue:work para monitorar os envios de notificações que serão enviados para a fila

## Rotas

- POST - /transaction 
   - `  { 
            payer: int
            payee: int
            value: float
        }    
    `
    - Cria uma transação 

- GET - /user/{userId}/wallet
    - Retorna userId com a sua carteira
