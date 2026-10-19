<?php

namespace App\Services;

use Illuminate\Support\Facades\Process;
use Illuminate\Filesystem\Filesystem;

class PhpStanService
{
    /**
     * Install Larastan ja kopeeri phpstan config projekti
     */
    public function create(string $projectPath): void
    {
        $fs = new Filesystem();

        $result = Process::path($projectPath)->run([
            'composer',
            'require',
            'larastan/larastan',
            '--dev',
        ], function ($type, $output) {
            echo $output;
        });

        if ($result->successful()) {
            echo "Larastan installitud edukalt projekti juurkausta.\n";
        } else {
            echo "Larastan installimisel tekkis viga:\n";
            echo $result->errorOutput();
        }

        $stub = 'phpstan.neon.stub';

        $stubPath = base_path('stubs/' . $stub);

        $targetPath = $projectPath . '/' . basename($stub, '.stub');

        if ($fs->exists($stubPath)) {
            $fs->copy($stubPath, $targetPath);
        }
    }
}
