<?php

namespace App\Services;

use Illuminate\Support\Facades\Process;

class PhpCsFixerService
{

    public function create(string $projectPath): void
    {
        $this->install($projectPath);
        $this->init($projectPath);
    }

    private function install(string $projectPath): void
    {
        Process::path($projectPath)->run([
            'composer',
            'require',
            'friendsofphp/php-cs-fixer',
            '--dev',
        ], function ($type, $output) {
            echo $output;
        })
            ->throw();
    }

    private function init(string $projectPath): void
    {
        Process::path($projectPath)->run([
            './vendor/bin/php-cs-fixer',
            'init',
        ], function ($type, $output) {
            echo $output;
        })
            ->throw();
    }
}
