<?php

namespace Scientist;

use PHPUnit\Framework\TestCase;

class ReportTest extends TestCase
{
    public function testThatReportCanBeCreated()
    {
        $r = new Result();
        $rep = new Report('foo', $r, []);

        $this->assertInstanceOf(Report::class, $rep);
    }

    public function testThatReportCanHoldExperimentName()
    {
        $r = new Result();
        $rp = new Report('foo', $r, []);
        $this->assertEquals('foo', $rp->getName());
    }

    public function testThatReportCanHoldControlResult()
    {
        $r = new Result();
        $rp = new Report('foo', $r, []);
        $this->assertInstanceOf(Result::class, $rp->getControl());
        $this->assertSame($r, $rp->getControl());
    }

    public function testThatReportCanHoldTrialResult()
    {
        $r = new Result();
        $rp = new Report('foo', $r, ['bar' => $r]);
        $this->assertInstanceOf(Result::class, $rp->getTrial('bar'));
        $this->assertSame($r, $rp->getTrial('bar'));
    }

    public function testThatReportCanHoldMultipleTrialResults()
    {
        $r = new Result();
        $rp = new Report('foo', $r, ['bar' => $r, 'baz' => $r]);
        $this->assertInstanceOf(Result::class, $rp->getTrial('bar'));
        $this->assertInstanceOf(Result::class, $rp->getTrial('baz'));
        $this->assertSame($r, $rp->getTrial('bar'));
        $this->assertSame($r, $rp->getTrial('baz'));
        $this->assertCount(2, $rp->getTrials());
        $this->assertEquals([
            'bar' => $r, 'baz' => $r
        ], $rp->getTrials());
    }
}
