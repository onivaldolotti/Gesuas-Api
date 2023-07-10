<?php

namespace App\Application\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\UseCases\Interfaces\FindCitizenUseCaseInterface;
use Slim\Exception\HttpBadRequestException;
use App\Domain\ValueObjects\NIS;

class FindCitizenController
{
    private FindCitizenUseCaseInterface $findCitizenUseCase;

    public function __construct(FindCitizenUseCaseInterface $findCitizenUseCase)
    {
        $this->findCitizenUseCase = $findCitizenUseCase;
    }

    public function handle(Request $request, Response $response, $args): Response
    {
        $nis = new NIS($args['nis']);

        $citizen = $this->findCitizenUseCase->execute($nis->getValue());

        $response = $response->withHeader('Content-Type', 'application/json');

        if ($citizen) {
            $response->getBody()->write(json_encode($citizen->toArray()));
            return $response->withStatus(200);
        }

        $response->getBody()->write(json_encode(['message' => 'Cidadão não encontrado']));
        return $response ->withStatus(200);
    }
}
