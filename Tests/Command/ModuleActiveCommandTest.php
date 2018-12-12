<?php

namespace Codeurx\Modular\Tests\Command;

use Codeurx\Modular\Tests\TestCase;

class ModuleActiveCommandTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testEnableModule()
    {
        $this->artisan('modular:make', ['name' => 'Users']);
        $command = $this->artisan('modular:active', ['module' => 'Users','option'=>'true']);
        $this->assertSame(0, $command);
    }

    public function testDisableModule()
    {
        $this->artisan('modular:make', ['name' => 'Users']);
        $command = $this->artisan('modular:active', ['module' => 'Users','option'=>'false']);
        $this->assertSame(0, $command);
    }
}