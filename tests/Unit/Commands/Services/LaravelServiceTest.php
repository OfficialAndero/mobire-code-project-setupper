<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\LaravelService;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Process;
use Mockery;
use Mockery\MockInterface;
use Symfony\Component\Finder\SplFileInfo;

class LaravelServiceTest extends TestCase
{
    protected string $projectPath = '/fake/project/path';
    protected MockInterface&Filesystem $fsMock;
    protected LaravelService $service;

    protected function setUp(): void
    {
        parent::setUp();

        // arrange 
        $this->fsMock = Mockery::mock(Filesystem::class);
        $this->service = new LaravelService($this->fsMock);
    }

    public function test_it_creates_laravel_project_and_sets_permissions(): void
    {
        // arrange
        Process::fake();

        $this->fsMock->shouldReceive('files')
        ->with($this->projectPath)
        ->andReturn([]);

        $this->fsMock->shouldReceive('directories')
        ->with($this->projectPath)
        ->andReturn([]);

        
        $storageDir = $this->projectPath . '/storage';
        $cacheDir = $this->projectPath . '/bootstrap/cache';

        $this->fsMock->shouldReceive('isDirectory')
        ->with($storageDir)
        ->andReturn(true);

        $this->fsMock->shouldReceive('isDirectory')
        ->with($cacheDir)
        ->andReturn(true);


        $mockFile = Mockery::mock(SplFileInfo::class);
        $mockFile->shouldReceive('getPathname')
        ->andReturn($storageDir . '/logs/laravel.log');

        $this->fsMock->shouldReceive('allFiles')
        ->with($storageDir)
        ->andReturnUsing(fn () => [$mockFile]);

        $this->fsMock->shouldReceive('allFiles')
        ->with($cacheDir)
        ->andReturn([]);


        $this->fsMock->shouldReceive('chmod')
        ->with($storageDir, 0o777)
        ->once();

        $this->fsMock->shouldReceive('chmod')
        ->with($cacheDir, 0o777)
        ->once();

        $this->fsMock->shouldReceive('chmod')
        ->with($storageDir . '/logs/laravel.log', 0o777)
        ->once();

        // act
        $this->service->create($this->projectPath);

        // assert 
        Process::assertRan(function ($process) {
            return in_array('composer', $process->command) &&
                   in_array('laravel/laravel', $process->command) &&
                   $process->path === $this->projectPath;
        });
    }


    public function test_it_throws_exception_if_directory_is_not_empty(): void
    {
        // arrange
        $this->fsMock->shouldReceive('files')
    ->with($this->projectPath)
    ->andReturnUsing(fn () => [Mockery::mock(SplFileInfo::class)]);
        
        // assert
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Directory must be empty');

        // act
        $this->service->create($this->projectPath);
    }
}