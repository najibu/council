<?php

namespace Tests\Console;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class InstallCommandTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        File::move('.env', '.env.backup');

        config(['app.key' => '']);
    }

    public function tearDown()
    {
    }
}
