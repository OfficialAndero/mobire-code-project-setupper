<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem;

class DockerfileGenerator
{

    
    public function __construct(
        protected Filesystem $fs
    ) {}
    /**
     * Loeb stub-faile ja kopeerib need projekti docker kausta,
     * eemaldades .stub lõpu failinimest.
     *
     * @param string $projectPath Projekti kausta tee
     */
    public function generate(string $projectPath): void
    {

       $dockerPath = $projectPath . '/docker';


        if (!$this->fs->exists($dockerPath)) {
            $this->fs->makeDirectory($dockerPath, 0o755, true);
        }

        $stubs = ['Dockerfile.stub', 'apache-vhost.conf.stub', 'xdebug.ini.stub'];

        foreach ($stubs as $stub) {
            $stubPath = base_path('stubs/' . $stub);

            // Kui stub fail eksisteerib, kopeerime selle docker kausta ilma stub lõpputa
            if ($this->fs->exists($stubPath)) {
                $this->fs->copy($stubPath, $dockerPath . '/' . basename($stub, '.stub'));
            }
        }

        $dockerfail = base_path('stubs/docker-compose.yml.stub');

        $composeTarget = $projectPath . '/docker-compose.yml';

        if ($this->fs->exists($dockerfail)) {
            $this->fs->copy($dockerfail, $composeTarget);
        }
    }
}
       
