<?php

namespace Bow\Tests\Filesystem;

use Bow\Storage\Temporary;

class TemporaryTest extends \PHPUnit\Framework\TestCase
{
    public function testOpenAndClose()
    {
        $temp = new Temporary();

        $this->assertTrue($temp->isOpen());

        $temp->close();
        $this->assertFalse($temp->isOpen());
    }

    public function test_write()
    {
        $temp = new Temporary(sys_get_temp_dir() . '/temp');

        $temp->write('hello bow');

        $this->assertEquals('hello bow', $temp->read());
    }
}
