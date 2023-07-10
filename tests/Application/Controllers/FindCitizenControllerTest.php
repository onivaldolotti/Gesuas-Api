<?php

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use App\Application\Controllers\FindCitizenController;
use App\Domain\UseCases\Interfaces\FindCitizenUseCaseInterface;

class FindCitizenControllerTest extends TestCase
{
    private ServerRequestInterface $request;
    private ResponseInterface $response;
    private FindCitizenUseCaseInterface $findCitizenUseCase;
    private FindCitizenController $findCitizenController;

    protected function setUp(): void
    {
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->findCitizenUseCase = $this->createMock(FindCitizenUseCaseInterface::class);

        $this->findCitizenController = new FindCitizenController($this->findCitizenUseCase);
    }

    public function testHandleWithValidNIS(): void
    {
        $args = ['nis' => '12345678901'];

        $expectedResult = [
            'name' => 'John Doe',
            'nis' => '12345678901',
        ];

        $this->findCitizenUseCase->expects($this->once())
            ->method('execute')
            ->with('12345678901')
            ->willReturn($expectedResult);

        $this->response
            ->method('getBody')
            ->willReturn($this->createMock(StreamInterface::class));

        $this->response->expects($this->once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json')
            ->willReturnSelf();

        $this->response->expects($this->once())
            ->method('withStatus')
            ->with(200)
            ->willReturnSelf();

        $this->response->getBody()->expects($this->once())
            ->method('write')
            ->with(json_encode($expectedResult));

        $result = $this->findCitizenController->handle($this->request, $this->response, $args);

        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testHandleWithInvalidNIS(): void
    {
        $args = ['nis' => '12345678901'];

        $this->findCitizenUseCase->expects($this->once())
            ->method('execute')
            ->with('12345678901')
            ->willReturn(['message' => 'Cidadão não encontrado']);

        $this->response
            ->method('getBody')
            ->willReturn($this->createMock(StreamInterface::class));

        $this->response->expects($this->once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json')
            ->willReturnSelf();

        $this->response->expects($this->once())
            ->method('withStatus')
            ->with(200)
            ->willReturnSelf();

        $this->response->getBody()->expects($this->once())
            ->method('write')
            ->with(json_encode(['message' => 'Cidadão não encontrado']));

        $result = $this->findCitizenController->handle($this->request, $this->response, $args);

        $this->assertInstanceOf(ResponseInterface::class, $result);
    }
}
