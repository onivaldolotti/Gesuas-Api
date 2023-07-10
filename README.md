# Teste Gesuas

Este é um projeto em PHP 8.1 utilizando o Composer como gerenciador de dependências e seguindo os princípios da arquitetura Clean Architecture.

## Requisitos

- PHP 8.1 ou superior
- Composer

## Instalação

1. Clone este repositório para o seu ambiente local.
2. Execute o comando `composer install` para instalar as dependências.

## Configuração do Banco de Dados

1. Certifique-se de ter o SQLite instalado no seu ambiente.
2. Crie um arquivo de banco de dados vazio no diretório raiz `database.sqlite.sqlite3`.

## Migração do Banco de Dados

Para criar a estrutura do banco de dados, execute as migrações usando o Phinx:

```
vendor/bin/phinx migrate -c src/Infrastructure/Database/phinx.php
```

## Executando a Aplicação

Você pode iniciar o servidor PHP embutido usando o seguinte comando a partir da raiz da aplicação:

```
cd src/Presentation/API

php -S localhost:8000
```

## Endpoints da API

- **POST /citizens**: Cria um novo cidadão. Deve receber um JSON no corpo da requisição contendo o nome do cidadão. O número NIS será gerado automaticamente e retornado na resposta.

```
{
    "name": "joao",
}
```

- **GET /citizens/{nis}**: Busca um cidadão pelo número NIS. Retorna um JSON com as informações do cidadão ou a mensagem "Cidadão não encontrado".

- **GET /**: Retorna o horário atual para verificação de status da api.

## Executando os Testes

Para executar os testes, utilize o comando:

```
vendor/bin/phpunit
```

## Considerações Finais

Este projeto segue os princípios da Clean Architecture para promover a separação de responsabilidades e a modularidade. Ele foi desenvolvido utilizando boas práticas de programação e pode ser utilizado como base para a construção de aplicações PHP mais robustas.
