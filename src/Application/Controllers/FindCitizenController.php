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
       
        $result = $this->findCitizenUseCase->execute($nis->getValue());

        $response->getBody()->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
