<?php

namespace App\Application\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\UseCases\Interfaces\CreateCitizenUseCaseInterface;
use Slim\Exception\HttpBadRequestException;

class CreateCitizenController
{
    private CreateCitizenUseCaseInterface $createCitizenUseCase;

    public function __construct(CreateCitizenUseCaseInterface $createCitizenUseCase)
    {
        $this->createCitizenUseCase = $createCitizenUseCase;
    }

    public function handle(Request $request, Response $response): Response
    {
        $json = $request->getBody()->getContents();
        $data = json_decode($json, true);

        if (!isset($data['name'])) {
            throw new HttpBadRequestException($request, 'Campo obrigatório name não fornecido');
        }

        $name = $data['name'];

        $citizen = $this->createCitizenUseCase->execute($name);

        $responseData = ['message' => 'Cidadão criado com sucesso', 'nis' => $citizen['nis']];
        $response = $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($responseData));

        return $response;
    }
}
