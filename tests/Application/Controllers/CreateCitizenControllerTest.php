<?php

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use App\Application\Controllers\CreateCitizenController;
use App\Domain\UseCases\Interfaces\CreateCitizenUseCaseInterface;
use Slim\Exception\HttpBadRequestException;

class CreateCitizenControllerTest extends TestCase
{
    private ServerRequestInterface $request;
    private ResponseInterface $response;
    private CreateCitizenUseCaseInterface $createCitizenUseCase;
    private CreateCitizenController $createCitizenController;

    protected function setUp(): void
    {
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->requestBody = $this->createMock(StreamInterface::class);
        $this->createCitizenUseCase = $this->createMock(CreateCitizenUseCaseInterface::class);
        $this->createCitizenController = new CreateCitizenController($this->createCitizenUseCase);
    }

    public function testHandleWithValidData(): void
    {
        $this->requestBody
            ->method('getContents')
            ->willReturn(json_encode(['name' => 'João']));

        $this->request
            ->method('getBody')
            ->willReturn($this->requestBody);
    
        $this->response
            ->expects($this->once())
            ->method('withStatus')
            ->with(201)
            ->willReturnSelf();

        $this->response
            ->expects($this->once())
            ->method('withHeader')
            ->with('Content-Type', 'application/json')
            ->willReturnSelf();
    
        $this->requestBody
            ->expects($this->once())
            ->method('write')
            ->with(json_encode(['message' => 'Cidadão criado com sucesso', 'nis' => '12345678901']));
    
        $this->response
            ->method('getBody')
            ->willReturn($this->requestBody);
    
        $this->createCitizenUseCase
            ->expects($this->once())
            ->method('execute')
            ->with('João')
            ->willReturn(['nis' => '12345678901']);
    
        $result = $this->createCitizenController->handle($this->request, $this->response);
    
        $this->assertInstanceOf(ResponseInterface::class, $result);
    }
    
    public function testHandleWithMissingName(): void
    {
        $this->requestBody
            ->method('getContents')
            ->willReturn(json_encode([]));
        $this->request
            ->method('getBody')
            ->willReturn($this->requestBody);

        $this->createCitizenUseCase
            ->expects($this->never())
            ->method('execute');

        $this->expectException(HttpBadRequestException::class);

        try {
            $this->createCitizenController->handle($this->request, $this->response);
        } catch (HttpBadRequestException $exception) {
            $this->assertSame('Campo obrigatório name não fornecido', $exception->getMessage());

            throw $exception;
        }
    }
}
