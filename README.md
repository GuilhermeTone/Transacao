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

Comentando um pouco sobre o código utilizo então o Laravel, Mysql e Docker para ambiente de desenvolvimento, com pattern de Service, e Request utilizando injeção de dependência, poderia utilizar um repository para lidar com as funções do banco de dados entretanto perde um pouco de sentindo ao usar o ORM tendo em vista que a utilização de um ORM vem para abstrair o acesso ao banco de dados e deixar um código mais focado no negocio e não perder tempo com coisas que dificilmente irão mudar como ORM ou base de dados, entretanto em caso de projetos grandes é sempre bom a utilização de um repository para garantir uma boa longevidade do código, além disso utilizei a Transaction do Facade DB do Laravel que basicamente iniciar uma transação do banco de dados e caso ocorra algum erro durante volta ao estado de começo, garantindo um dos requisitos do teste, e faço vários try catch com tratativa de erros, e retorno com http codes referentes aos erros, além disso criei os mocks bem simples, pois os disponibilizados estavam foram do ar e eu não sabia como seriam o retorno deles então basicamente eles retornam mensagem como, transação liberada ou email enviado, também criei no banco de dados a data de envio de email e fail_code que é só um código que criei de cabeça mesmo para exemplificar os código catalogados de retorno de bancos. E por final acabou que não vou ter um bom histórico de git, este é um teste bem parecido com um que já fiz então tinha bastante coisas prontas, refatorei o código em varias e fiz melhorias, como distribuição de Logica em Services, Criação de Requests, e algumas outras coisas mais