<?php

namespace Scientist;

use Exception;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testResultCanBeCreated()
    {
        $r = new Result();

        $this->assertInstanceOf(Result::class, $r);
    }

    public function testResultCanHaveValue()
    {
        $r = new Result();
        $r->setValue('foo');
        $this->assertEquals('foo', $r->getValue());
    }

    public function testResultCanHaveStartTime()
    {
        $r = new Result();
        $r->setStartTime(123);
        $this->assertEquals(123, $r->getStartTime());
    }

    public function testResultCanHaveEndTime()
    {
        $r = new Result();
        $r->setEndTime(123);
        $this->assertEquals(123, $r->getEndTime());
    }

    public function testResultCanHaveStartMemory()
    {
        $r = new Result();
        $r->setStartMemory(123);
        $this->assertEquals(123, $r->getStartMemory());
    }

    public function testResultCanHaveEndMemory()
    {
        $r = new Result();
        $r->setEndMemory(123);
        $this->assertEquals(123, $r->getEndMemory());
    }

    public function testResultCanHaveException()
    {
        $r = new Result();
        $r->setException(new Exception());
        $this->assertInstanceOf(Exception::class, $r->getException());
    }

    public function testResultCanHaveMatchStatus()
    {
        $r = new Result();
        $r->setMatch(true);
        $this->assertTrue(true, $r->isMatch());
    }

    public function testCanHaveContext()
    {
        $context = ['foo' => 'bar'];

        $r = new Result($context);
        $this->assertSame($context, $r->getContext());
    }

    public function testResultCanHaveTotalExecutionTime()
    {
        $r = new Result();
        $r->setStartTime(2);
        $r->setEndTime(5);
        $this->assertEquals(3, $r->getTime());
    }

    public function testResultCanHaveTotalMemoryUsage()
    {
        $r = new Result();
        $r->setStartMemory(2);
        $r->setEndMemory(5);
        $this->assertEquals(3, $r->getMemory());
    }
}
