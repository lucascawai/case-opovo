# Case OPovo

Esse repositório é a solução de um case para o teste prático de Back-end Pleno do Grupo de Comunicação O Povo.

## Overview

De maneira geral, é um contato primário com a linguaguem PHP e Laravel, embora tenha suas semelhanças com Javascript, Node.js e suas frameworks Next.js, React e afins, que são linguagens que estou mais acostumado. Tentei containerizar toda aplicação, mas levou bastante tempo tanto para executar quanto para entender os novos serviços que eram necessários para rodar a aplicação então optei somente por containerizar o Banco de Dados.

Foi stack escolhida, essencialmente, foi:

 - PHP: 8.2
 - Laravel: 12.0
 - MySQL: 8.2
 - Docker/Docker Compose


## Instalação

Após clonar o repósitório, foi assumido de antemão que usuário tenha PHP, Composer já instalados localmente. Como vamos testar somente o Back-end da aplicação, não é necessário NPM e Node. E para criar o Banco de Dados, Docker.

Inicialmente, suba o Banco de Dados via docker:

```
cd docker/
docker compose up --build
```

Agora instale as dependências do projeto:

```
cd case-opovo/
composer install
```

O projeto irá automaticamente gerar .env e gerar tanto as chaves para o projeto quanto para utilizar o JWT. Mas caso seja necessário copie ``.env.example`` para ``.env`` dentro do folder ``case-opovo`` e gere as chaves manualmente:

```
php artisan key:generate
php artisan jwt:secret
```

Agora popule o Banco de Dados via migrate:

```
php artisan migrate
```

Caso ache necessário, existe um seeder para realizar testes, assim é possível popular o banco e realizar testes localmente:

```
php artisan migrate:fresh --seed --seeder=OPovoSeeder
```

Finalmente, basta rodar o projeto:

```
php artisan serve
```