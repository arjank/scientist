<?php

namespace Scientist\Matchers;

use PHPUnit\Framework\TestCase;

class StandardMatcherTest extends TestCase
{
    public function testThatStandardMatcherCanBeCreated()
    {
        $s = new StandardMatcher();
        $this->assertInstanceOf(StandardMatcher::class, $s);
    }

    public function testThatStandardMatcherCanMatchValues()
    {
        $s = new StandardMatcher();
        $this->assertTrue($s->match(true, true));
    }

    public function testThatStandardMatcherCanFailToMatchValues()
    {
        $s = new StandardMatcher();
        $this->assertFalse($s->match(2, 5));
    }

    public function testThatMatcherIsStrictWithMatches()
    {
        $s = new StandardMatcher();
        $this->assertFalse($s->match(false, null));
    }
}
