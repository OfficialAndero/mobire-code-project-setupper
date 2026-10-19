<?php

namespace Tests\Unit\Services;

use App\Services\DockerCompose1;
use Illuminate\Support\Facades\Process;
use Tests\TestCase;

class DockerCompose1Test extends TestCase
{
    public function test_it_runs_docker_compose_up_in_project_path(): void
    {
        Process::fake();
        // arrange
        $service = new DockerCompose1();

        // act
        $service->run('/fake/path/to/project');

        // assert
        Process::assertRan(function ($process) {
            return $process->command === [
                'docker',
                'compose',
                'up',
                '--build',
                '-d',
            ];
        });
    }
}