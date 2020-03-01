<?php

namespace Scientist;

use Error;
use Exception;
use PHPUnit\Framework\TestCase;

class MachineTest extends TestCase
{
    public function testThatMachineCanBeCreated()
    {
        $m = new Machine(function () {
        });

        $this->assertInstanceOf(Machine::class, $m);
    }

    public function testThatMachineCanReceiveParameters()
    {
        $m = new Machine(function () {
        }, [1, 2, 3]);

        $this->assertInstanceOf(Machine::class, $m);
    }

    public function testThatMachineCanReceiveMutableState()
    {
        $m = new Machine(function () {
        }, [1, 2, 3], true);

        $this->assertInstanceOf(Machine::class, $m);
    }

    public function testThatMachineCanProduceAResult()
    {
        $m = new Machine(function () {
        });

        $this->assertInstanceOf(Result::class, $m->execute());
    }

    public function testThatMachineDeterminesCallbackResultValue()
    {
        $m = new Machine(function () {
            return 'foo';
        });

        $this->assertEquals('foo', $m->execute()->getValue());
    }

    public function testThatMachineSetsContextResult()
    {
        $context = ['foo' => 'bar'];

        $m = new Machine(function () {
            return 'foo';
        }, [], true, $context);

        $this->assertSame($context, $m->execute()->getContext());
    }

    public function testThatMachineExecutesCallbackWithParameters()
    {
        $m = new Machine(function ($one, $two, $three) {
            return $one + $two + $three;
        }, [1, 2, 3], true);

        $this->assertEquals(6, $m->execute()->getValue());
    }

    public function testThatExceptionsCanBeThrownByMachineCallbackExecution()
    {
        $m = new Machine(function () {
            throw new Exception('foo');
        });

        $this->expectException(Exception::class);

        $m->execute();
    }

    public static function getErrorData()
    {
        return [
            [new Exception('This exception should be caught')],
            [new Error('This error should be caught')],
        ];
    }

    /**
     * @dataProvider getErrorData
     */
    public function testThatMachineCanMuteExceptionsFromCallback($exception)
    {
        $m = new Machine(function () use ($exception) {
            throw $exception;
        }, [], true);

        $this->assertNull($m->execute()->getValue());
    }

    public function testThatMachineCanDetermineStartAndEndTimesForCallbacks()
    {
        $m = new Machine(function () {
        });

        $s = microtime(true) - 60;
        $r = $m->execute();
        $e = microtime(true) + 60;

        $this->assertIsFloat($r->getStartTime());
        $this->assertIsFloat($r->getEndTime());
        $this->assertGreaterThan($s, $r->getStartTime());
        $this->assertGreaterThan($s, $r->getEndTime());
        $this->assertLessThan($e, $r->getStartTime());
        $this->assertLessThan($e, $r->getEndTime());
    }

    public function testThatMachineCanDetermineMemoryUsageChanges()
    {
        $m = new Machine(function () {
        });

        $r = $m->execute();

        $this->assertIsInt($r->getStartMemory());
        $this->assertIsInt($r->getEndMemory());
    }
}
