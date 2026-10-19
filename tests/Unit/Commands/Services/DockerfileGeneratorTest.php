<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\DockerfileGenerator;
use Illuminate\Filesystem\Filesystem;
use Mockery;
use Mockery\MockInterface;

class DockerfileGeneratorTest extends TestCase
{
    protected string $projectPath = '/fake/project/path';
    protected MockInterface&Filesystem $fsMock;
    protected DockerfileGenerator $generator;

    protected function setUp(): void
    {
        parent::setUp();

        
        $this->fsMock = Mockery::mock(Filesystem::class);
        
        
        $this->generator = new DockerfileGenerator($this->fsMock);
    }

    /**
     * Kontrollib, et docker kataloog luuakse, kui seda pole olemas.
     */
    public function test_it_creates_docker_directory_if_it_does_not_exist(): void
    {
        // arrange
        $dockerPath = $this->projectPath . '/docker';

        
        $this->fsMock->shouldReceive('exists')
            ->with($dockerPath)
            ->once()
            ->andReturn(false);

        $this->fsMock->shouldReceive('exists')->andReturn(false);
        
        // assert
        $this->fsMock->shouldReceive('makeDirectory')
            ->with($dockerPath, 0o755, true)
            ->once();

        $this->fsMock->shouldReceive('exists')->andReturn(false);
        
        //act
        $this->generator->generate($this->projectPath);
    }

    
    public function test_it_copies_stubs_correctly(): void
    {
        // arrange
        $dockerPath = $this->projectPath . '/docker';

        
        $this->fsMock->shouldReceive('exists')->with($dockerPath)->andReturn(true);
        $this->fsMock->shouldNotReceive('makeDirectory');

        $stubs = ['Dockerfile.stub', 'apache-vhost.conf.stub', 'xdebug.ini.stub'];
        
        foreach ($stubs as $stub) {
            $stubPath = base_path('stubs/' . $stub);
            $targetPath = $dockerPath . '/' . basename($stub, '.stub');

            $this->fsMock->shouldReceive('exists')
                ->with($stubPath)
                ->once()
                ->andReturn(true);

            // assert
            $this->fsMock->shouldReceive('copy')
                ->with($stubPath, $targetPath)
                ->once();
        }

        $this->fsMock->shouldReceive('exists')->with(base_path('stubs/docker-compose.yml.stub'))->andReturn(false);
        
        // act
        $this->generator->generate($this->projectPath);
    }

  
    public function test_it_copies_docker_compose_stub_to_project_root(): void
    {

        // arrange
        $this->fsMock->shouldReceive('exists')->with($this->projectPath . '/docker')->andReturn(true);

        $otherStubs = ['Dockerfile.stub', 'apache-vhost.conf.stub', 'xdebug.ini.stub'];
        foreach ($otherStubs as $stub) {
            $this->fsMock->shouldReceive('exists')
                ->with(base_path('stubs/' . $stub))
                ->andReturn(false);
        }

        $composeStub = base_path('stubs/docker-compose.yml.stub');
        $composeTarget = $this->projectPath . '/docker-compose.yml';

        $this->fsMock->shouldReceive('exists')
            ->with($composeStub)
            ->once()
            ->andReturn(true);

        // assert
        $this->fsMock->shouldReceive('copy')
            ->with($composeStub, $composeTarget)
            ->once();

        // act
        $this->generator->generate($this->projectPath);
    }
    
}