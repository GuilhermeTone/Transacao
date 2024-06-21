API Rest com Laravel

Rotas

Utilizei o metodo patch pois se trata de uma transferência, então seria uma atualização de dados
PATCH http://localhost:8989/api/transaction

Request Example
```
{  
  "payee": "1",
  "payer": "2",
  "value": "1"
}
```
Para iniciar o projeto, basta ter o docker, dar os comandos
```
composer install
```
Para subir os containers
```
docker compose up -d
```
Para executar comandos dentro dos containers
```
docker-compose exec app bash
```

ao entrar no terminal do container dar o comando

Para criar as tabelas no banco de dados
```
php artisan migrate
```

Para popular o banco de dados com dados fake para os costumers
```
php artisan db:seed --class=CustomersSeeder
```
