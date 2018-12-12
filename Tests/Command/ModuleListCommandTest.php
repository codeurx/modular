<?php

namespace Codeurx\Modular\Tests\Command;

use Codeurx\Modular\Tests\TestCase;

class ModuleListCommandTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testListModule()
    {
        $command = $this->artisan('modular:list');
        $this->assertSame(0, $command);
    }
}