<?php

namespace App\Commands;

use App\Services\PhpCsFixerService;
use App\Services\PhpStanService;
use App\Services\LaravelService;
use App\Services\DockerCompose1;
use App\Services\FileSystemService;
use App\Services\DockerfileGenerator;
use LaravelZero\Framework\Commands\Command;
use App\Services\ProjectPermissionService;

class Create extends Command
{
    protected $signature = 'app:create {name? : Projekti nimi}';
    protected $description = 'Loo uus projekt';


 

  public function handle (
        ProjectPermissionService $projectPermissionService,
        PhpStanService $PhpStanService,
        FileSystemService $FileSystemService,
        PhpCsFixerService $PhpCsFixerService,
        LaravelService $LaravelService,
        DockerfileGenerator $DockerfileGenerator,
        DockerCompose1 $DockerCompose1
    ): void {

        $name = $this->argument('name');
    if (!$name) {
        $name = $this->ask('Projekti nimi on kohustuslik. Palun sisesta nimi');
        
        // Kui kasutaja vajutab lihtsalt Enter ilma nime panemata
        if (!$name) {
            $this->error('Nime ei sisestatud. Tegevus katkestatud.');
            return;
        }
    }


       
        //tulemust näitatakse terminalis
        $projectPath = $FileSystemService->createProjectDirectory($name);
        $this->info("Projekti kaust loodud: {$projectPath}");

        $LaravelService->create($projectPath);
        $this->info("Laravel loodud.");

        $PhpStanService->create($projectPath);
        $this->info("PhpStan/Larastan seadistatud projekti juurkausta.");

        $PhpCsFixerService->create($projectPath);
        $this->info("PhpCsFixer seadistatud projekti juurkausta.");

        $DockerfileGenerator->generate($projectPath);
        $this->info("Docker kaust ja stub failid loodud.");
        $this->info('Käivitan Docker Compose');

        $DockerCompose1->run($projectPath);
        $this->info('Docker Compose käivitatud.');

        
        $this->info("Parandan õigused konteineri sees");

        $projectPermissionService->fix($projectPath);

        $this->info(" KÕIK VALMIS! Ava: http://localhost:8000");
    }
}
