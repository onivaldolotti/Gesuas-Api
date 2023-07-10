<?php

use App\Domain\Repositories\Interfaces\CitizenRepositoryInterface;
use App\Domain\Entities\Citizen;
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
        
        $expectedCitizen = new Citizen('João', 123456789);
        $this->citizenRepository->method('findByNIS')->willReturn($expectedCitizen);
        
        $result = $this->findCitizenUseCase->execute(123456789);
        
        $this->assertEquals(new Citizen('João', 123456789), $result);
    }

    public function testExecuteWithNonExistingCitizen()
    {        
        $this->citizenRepository->method('findByNIS')->willReturn(null);
        
        $result = $this->findCitizenUseCase->execute(123456789);
        
        $this->assertEquals(null, $result);
    }

    public function testExecuteWithInvalidNIS()
    {
        $result = $this->findCitizenUseCase->execute(-123456789);
        
        $this->assertEquals(null, $result);
    }
}
