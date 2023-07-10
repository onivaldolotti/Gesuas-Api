<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Application\Controllers\FindCitizenController;
use App\Application\Controllers\CreateCitizenController;

use App\Domain\UseCases\Interfaces\FindCitizenUseCaseInterface;
use App\Domain\UseCases\FindCitizenUseCase;

use App\Domain\UseCases\Interfaces\CreateCitizenUseCaseInterface;
use App\Domain\UseCases\CreateCitizenUseCase;

use App\Domain\Repositories\Interfaces\CitizenRepositoryInterface;
use App\Domain\Repositories\IlluminateCitizenRepository;

use App\Infrastructure\Persistence\SQLiteConnection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

SQLiteConnection::connect();

$container = new DI\Container();

$container->set(CitizenRepositoryInterface::class, function () {
    return new IlluminateCitizenRepository();
});

$container->set(FindCitizenUseCaseInterface::class, function ($container) {
    $repository = $container->get(CitizenRepositoryInterface::class);
    return new FindCitizenUseCase($repository);
});

$container->set(CreateCitizenUseCaseInterface::class, function ($container) {
    $repository = $container->get(CitizenRepositoryInterface::class);
    return new CreateCitizenUseCase($repository);
});

$container->set(FindCitizenController::class, function ($container) {
    $useCase = $container->get(FindCitizenUseCaseInterface::class);
    return new FindCitizenController($useCase);
});

$container->set(CreateCitizenController::class, function ($container) {
    $useCase = $container->get(CreateCitizenUseCaseInterface::class);
    return new CreateCitizenController($useCase);
});

$app = AppFactory::createFromContainer($container);

$app->post('/citizens', CreateCitizenController::class . ':handle');
$app->get('/citizens/{nis}', FindCitizenController::class . ':handle');
$app->get('/', function (Request $request, Response $response) {
    $currentTime = date('d-m-Y H:i:s');
    $responseData = ['current_time' => $currentTime, 'teste' => 'Backend Gesuas'];

    $response->getBody()->write(json_encode($responseData));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});

$customErrorHandler = function (
    Request $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails,
) use ($app) {
    $payload = ['error' => $exception->getMessage()];

    $response = $app->getResponseFactory()->createResponse()->withStatus(400)->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(
        json_encode($payload, JSON_UNESCAPED_UNICODE)
    );

    return $response;
};

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

$app->run();
