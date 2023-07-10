<?php

use App\Domain\Repositories\Interfaces\CitizenRepositoryInterface;
use App\Domain\Models\Citizen;
use App\Domain\UseCases\FindCitizenUseCase;
use PHPUnit\Framework\TestCase;

class FindCitizenUseCaseTest extends TestCase
{
    private $citizenRepository;
    private $findCitizenUseCase;

    protected function setUp(): void
    {
        $this->citizenRepository = $this->createMock(CitizenRepositoryInterface::class);
        $this->findCitizenUseCase = new FindCitizenUseCase($this->citizenRepository);
    }

    public function testExecuteWithExistingCitizen()
    {
        
        $expectedCitizen = new Citizen();
        $expectedCitizen->name = 'João';
        $expectedCitizen->nis = 123456789;
        $this->citizenRepository->method('findByNIS')->willReturn($expectedCitizen);
        
        $result = $this->findCitizenUseCase->execute(123456789);
        
        $this->assertEquals([
            'name' => 'João',
            'nis' => 123456789
        ], $result);
    }

    public function testExecuteWithNonExistingCitizen()
    {        
        $this->citizenRepository->method('findByNIS')->willReturn(null);
        
        $result = $this->findCitizenUseCase->execute(123456789);
        
        $this->assertEquals([
            'message' => 'Cidadão não encontrado'
        ], $result);
    }

    public function testExecuteWithInvalidNIS()
    {
        $result = $this->findCitizenUseCase->execute(-123456789);
        
        $this->assertEquals([
            'message' => 'Cidadão não encontrado'
        ], $result);
    }
}
