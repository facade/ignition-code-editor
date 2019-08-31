<?php

namespace Facade\IgnitionTinkerTab\Tests;

use PHPUnit\Framework\TestCase;
use Facade\CodeEditor\StackTraceTab;

class StackTraceTabTest extends TestCase
{
    /** @test */
    public function it_can_return_the_tab_name()
    {
        $tab = new StackTraceTab();

        $this->assertEquals('Stack trace', $tab->name());
    }
}
