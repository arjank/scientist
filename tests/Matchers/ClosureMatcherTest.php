<?php

namespace Scientist\Matchers;

use PHPUnit\Framework\TestCase;

class ClosureMatcherTest extends TestCase
{
    private function getClosure()
    {
        return function ($control, $trial) {
            return strtoupper($control) == strtoupper($trial);
        };
    }

    public function testThatClosureMatcherCanBeCreated()
    {
        $matcher = new ClosureMatcher($this->getClosure());
        $this->assertInstanceOf(ClosureMatcher::class, $matcher);
    }

    public function testThatClosureMatcherCanMatchValues()
    {
        $matcher = new ClosureMatcher($this->getClosure());
        $this->assertTrue($matcher->match('uppercase', 'UpperCase'));
    }

    public function testThatClosureMatcherCanFailToMatchValues()
    {
        $matcher = new ClosureMatcher($this->getClosure());
        $this->assertFalse($matcher->match('uppercase', 'LowerCase'));
    }
}
