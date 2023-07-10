# Teste Gesuas

Este é um projeto em PHP 8.1 utilizando o Composer como gerenciador de dependências e seguindo os princípios da arquitetura Clean Architecture.

## Requisitos

- Docker
- Docker Compose
- Composer  

## Instalação e Execução

Clone este repositório para o seu ambiente local.

## Executando a Aplicação

1. Execute o comando `composer install` para baixar as dependencias necessarias.
2. Execute o comando `docker compose up` para iniciar a aplicação.

## Banco de Dados

Foi usado o sqlite como arquivo de banco.

## Endpoints da API

- **POST localhost:8080/citizens**: Cria um novo cidadão. Deve receber um JSON no corpo da requisição contendo o nome do cidadão. O número NIS será gerado automaticamente e retornado na resposta.

```
{
    "name": "joao",
}
```

- **GET localhost:8080/citizens/{nis}**: Busca um cidadão pelo número NIS. Retorna um JSON com as informações do cidadão ou a mensagem "Cidadão não encontrado".

- **GET localhost:8080/**: Retorna o horário atual para verificação de status da api.

## Executando os Testes

Para executar os testes, utilize o comando:

```
docker exec <id_container> vendor/bin/phpunit
```

## Considerações Finais

Este projeto segue os princípios da Clean Architecture para promover a separação de responsabilidades e a modularidade. Ele foi desenvolvido utilizando boas práticas de programação e pode ser utilizado como base para a construção de aplicações PHP mais robustas.
