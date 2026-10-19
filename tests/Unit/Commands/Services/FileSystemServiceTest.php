<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\FileSystemService;
use Illuminate\Filesystem\Filesystem;
use Mockery;
use Mockery\MockInterface;

class FileSystemServiceTest extends TestCase
{
    protected MockInterface&Filesystem $fsMock;
    protected FileSystemService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fsMock = Mockery::mock(Filesystem::class);
        $this->service = new FileSystemService($this->fsMock);
    }

    public function test_it_creates_directory_and_returns_path(): void
    {
        // arrange
        $projectName = 'test-projekt';
        $expectedPath = dirname(base_path()) . '/' . $projectName;

        $this->fsMock->shouldReceive('exists')
            ->with($expectedPath)
            ->once()
            ->andReturn(false);

        
        $this->fsMock->shouldReceive('makeDirectory')
            ->with($expectedPath, 0o755, true)
            ->once();

        // act
        $result = $this->service->createProjectDirectory($projectName);
     
        // assert
        $this->assertEquals($expectedPath, $result);
    }
}