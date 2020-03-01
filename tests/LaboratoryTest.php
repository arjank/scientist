<?php

namespace Scientist;

use Exception;
use PHPUnit\Framework\TestCase;

class LaboratoryTest extends TestCase
{
    public function testLaboratoryCanBeCreated()
    {
        $l = new Laboratory();
        $this->assertInstanceOf(Laboratory::class, $l);
    }

    public function testLaboratoryCanRunExperimentWithNoJournals()
    {
        $v = (new Laboratory())
            ->experiment('test experiment')
            ->control(function () {
                return 'foo';
            })
            ->trial('trial name', function () {
                return 'foo';
            })
            ->run();

        $this->assertEquals('foo', $v);
    }

    public function testLaboratoryCanFetchReportForExperimentWithNoJournals()
    {
        $r = (new Laboratory())
            ->experiment('test experiment')
            ->control(function () {
                return 'foo';
            })
            ->trial('trial', function () {
                return 'bar';
            })
            ->report();

        $this->assertInstanceOf(Report::class, $r);
        $this->assertEquals('foo', $r->getControl()->getValue());
        $this->assertEquals('bar', $r->getTrial('trial')->getValue());
        $this->assertIsFloat($r->getControl()->getStartTime());
        $this->assertIsFloat($r->getControl()->getEndTime());
        $this->assertIsFloat($r->getControl()->getTime());
        $this->assertIsFloat($r->getTrial('trial')->getStartTime());
        $this->assertIsFloat($r->getTrial('trial')->getEndTime());
        $this->assertIsFloat($r->getTrial('trial')->getTime());
        $this->assertIsInt($r->getControl()->getStartMemory());
        $this->assertIsInt($r->getControl()->getEndMemory());
        $this->assertIsInt($r->getControl()->getMemory());
        $this->assertIsInt($r->getTrial('trial')->getStartMemory());
        $this->assertIsInt($r->getTrial('trial')->getEndMemory());
        $this->assertIsInt($r->getTrial('trial')->getMemory());
        $this->assertNull($r->getControl()->getException());
        $this->assertNull($r->getTrial('trial')->getException());
        $this->assertFalse($r->getTrial('trial')->isMatch());
    }

    public function testThatExceptionsAreThrownWithinControl()
    {
        $this->expectException(Exception::class);

        (new Laboratory())
            ->experiment('test experiment')
            ->control(function () {
                throw new Exception();
            })
            ->trial('trial', function () {
                return 'foo';
            })
            ->run();
    }

    public function testThatExceptionsAreSwallowedWithinTheTrial()
    {
        $r = (new Laboratory())
            ->experiment('test experiment')
            ->control(function () {
                return 'foo';
            })
            ->trial('trial', function () {
                throw new Exception();
            })
            ->report();

        $this->assertInstanceOf(Report::class, $r);
        $this->assertNull($r->getControl()->getException());
        $this->assertInstanceOf(Exception::class, $r->getTrial('trial')->getException());
    }

    public function testThatControlAndTrialsReceiveParameters()
    {
        $r = (new Laboratory())
            ->experiment('test experiment')
            ->control(function ($one, $two) {
                return $one;
            })
            ->trial('trial', function ($one, $two) {
                return $two;
            })
            ->report('Panda', 'Giraffe');

        $this->assertInstanceOf(Report::class, $r);
        $this->assertEquals('Panda', $r->getControl()->getValue());
        $this->assertEquals('Giraffe', $r->getTrial('trial')->getValue());
    }
}
