<?php

namespace Facade\IgnitionTinkerTab\Tests;

use Facade\CodeEditor\StackTraceTab;
use Facade\IgnitionTinkerTab\TinkerTab;
use PHPUnit\Framework\TestCase;

class StackTraceTabTest extends TestCase
{
    /** @test */
    public function it_can_return_the_tab_name()
    {
        $tab = new StackTraceTab();

        $this->assertEquals('Stack trace', $tab->name());
    }
}
