<?php

namespace Codeurx\Modular\Tests\Command;

use Codeurx\Modular\Tests\TestCase;

class ModuleMakeCommandTest extends TestCase
{
    private $modulePath;

    public function setUp()
    {
        parent::setUp();
        $this->modulePath = base_path('app/Modules/Users/');
    }

    public function testMakeModule()
    {
        $command = $this->artisan('modular:make', ['name' => 'Users']);
        $this->assertSame(0, $command);
    }
}
