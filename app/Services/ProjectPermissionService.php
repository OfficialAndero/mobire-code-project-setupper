<?php

namespace App\Services;

use Illuminate\Support\Facades\Process;

class ProjectPermissionService
{
    public function fix(string $projectPath): void
    {
        $process = Process::path($projectPath);

        $process->run(
            'docker compose exec -T app_php chown -R www-data:www-data storage bootstrap/cache'
        );

        $process->run(
            'docker compose exec -T app_php chmod -R 777 storage bootstrap/cache'
        );

        $process->run(
            'docker compose exec -T app_php chown -R www-data:www-data database'
        );

        $process->run(
            'docker compose exec -T app_php chmod -R 777 database'
        );

        $process->run(
            'docker compose exec -T app_php chmod 666 database/database.sqlite'
        );
    }
}