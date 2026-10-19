<?php

namespace App\Services;

use Illuminate\Support\Facades\Process;
use Illuminate\Filesystem\Filesystem;

class LaravelService
{
    private Filesystem $files;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function create(string $projectPath): void
    {
        if (!$this->isEmptyDirectory($projectPath)) {
            throw new \Exception('Directory must be empty');
        }

        $result = Process::path($projectPath)->run([
            'composer',
            'create-project',
            'laravel/laravel',
            '.',
        ], function ($type, $output) {
            echo $output;
        });

        if ($result->failed()) {
            throw new \Exception($result->errorOutput());
        }
        $this->setPermissions($projectPath);

    }

    private function isEmptyDirectory(string $path): bool
    {
        return count($this->files->files($path)) === 0 && count($this->files->directories($path)) === 0;
    }

    private function setPermissions(string $path): void
    {
        $directories = [
            $path . '/storage',
            $path . '/bootstrap/cache',
        ];

        foreach ($directories as $dir) {
            if ($this->files->isDirectory($dir)) {

                $this->files->chmod($dir, 0o777);

                foreach ($this->files->allFiles($dir) as $file) {
                    $this->files->chmod($file->getPathname(), 0o777);
                }
            }
        }

    }
}
