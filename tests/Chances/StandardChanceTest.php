<?php

namespace Scientist\Chances;

use PHPUnit\Framework\TestCase;

class StandardChanceTest extends TestCase
{
    /**
     * @var StandardChance
     */
    private $chance;

    protected function setUp(): void
    {
        $this->chance = new StandardChance();
    }

    public function testThatStandardChanceIsAnInstanceOfChance()
    {
        $chance = new StandardChance();
        $this->assertInstanceOf('\Scientist\Chances\Chance', $chance);
    }

    public function testThatTheDefaultPercentageIs100()
    {
        $this->assertEquals(100, $this->chance->getPercentage());
    }

    public function testThatSetPercentageSetsThePercentage()
    {
        $percentage = rand(1, 100);
        $this->chance
            ->setPercentage($percentage);
        $this->assertEquals($percentage, $this->chance->getPercentage());
    }

    public function testThatSetPercentageReturnsTheChanceObjectForChaining()
    {
        $percentage = rand(1, 100);
        $this->assertSame($this->chance, $this->chance->setPercentage($percentage));
    }
}
