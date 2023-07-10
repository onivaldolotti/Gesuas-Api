<?php

use App\Domain\Repositories\Interfaces\CitizenRepositoryInterface;
use App\Domain\UseCases\CreateCitizenUseCase;
use PHPUnit\Framework\TestCase;
use App\Domain\Entities\Citizen;

class CreateCitizenUseCaseTest extends TestCase
{
    private $citizenRepository;
    private $createCitizenUseCase;

    protected function setUp(): void
    {
        $this->citizenRepository = $this->createMock(CitizenRepositoryInterface::class);
        $this->createCitizenUseCase = new CreateCitizenUseCase($this->citizenRepository);
    }

    public function testExecuteCreatesCitizenWithUniqueNis()
    {
        $name = "João";

        $this->citizenRepository->expects($this->once())
            ->method('findByNis')
            ->willReturn(null);

        $this->citizenRepository->expects($this->once())
            ->method('createCitizen')
            ->willReturn(new Citizen( $name,  123456789));

        $citizen = $this->createCitizenUseCase->execute($name);

        $this->assertEquals($name, $citizen->getName());
        $this->assertEquals(123456789, $citizen->getNis());
    }

    public function testExecuteHandlesCreateCitizenFailure()
    {
        $name = "João";

        $this->citizenRepository->method('findByNis')
            ->willReturn(null);

        $this->citizenRepository->method('createCitizen')
            ->willReturn(null);

        $citizen = $this->createCitizenUseCase->execute($name);

        $this->assertNull($citizen);
    }

    public function testGenerateNis()
    {
        $useCase = new CreateCitizenUseCase($this->citizenRepository);
        $reflection = new ReflectionClass(CreateCitizenUseCase::class);
        $generateNisMethod = $reflection->getMethod('generateNis');
        $generateNisMethod->setAccessible(true);

        $nis = $generateNisMethod->invoke($useCase);

        $this->assertIsInt($nis);
        $this->assertGreaterThanOrEqual(10000000000, $nis);
        $this->assertLessThanOrEqual(99999999999, $nis);
    }

}
