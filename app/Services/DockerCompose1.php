<?php

namespace App\Services;

use Illuminate\Support\Facades\Process;

class DockerCompose1
{
        /**
        Käivitab docker-compose konteinerid antud projektikaustas.
         */
 public function run(string $projectPath): void
    {
        Process::path($projectPath)
    ->forever()
    ->run(
        [
            'docker',
            'compose',
            'up',
            '--build',
            '-d',
        ],
        function ($type, $output) {
            echo $output;
        }
    );
    }
}