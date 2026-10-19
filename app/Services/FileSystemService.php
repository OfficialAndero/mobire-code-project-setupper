<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem;

class FileSystemService
{
    public function __construct(
        protected Filesystem $filesystem
    ) {}
    
    public function createProjectDirectory(string $name): string
    {

        $projectPath = dirname(base_path()) . '/' . $name;

        if (!$this->filesystem->exists($projectPath)) {
            // makeDirectory tööline ehitab kausta antud teega
           !$this->filesystem->makeDirectory($projectPath, 0o755, true);
        }

        return $projectPath;
    }
}
