<?php

namespace Tests\Unit\Commands;

use Tests\TestCase;

class CreateTest extends TestCase
{
    public function testItRunsWithoutErrors(): void
    {
        // arrange
        $cmd = 'app:create';
        // act
        $result = $this->artisan($cmd);
        // assert
        $result->expectsOutput('Hello World!')
               ->assertSuccessful();
    }
}
