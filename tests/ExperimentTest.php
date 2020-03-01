<?php

namespace Scientist;

use PHPUnit\Framework\TestCase;
use Scientist\Matchers\StandardMatcher;

class ExperimentTest extends TestCase
{
    public function testThatANewExperimentCanBeCreated()
    {
        $e = new Experiment('test experiment', new Laboratory());
        $this->assertInstanceOf(Experiment::class, $e);
    }

    public function testThatExperimentNameIsSet()
    {
        $e = new Experiment('test experiment', new Laboratory());
        $this->assertEquals('test experiment', $e->getName());
    }

    public function testThatAControlCallbackCanBeDefined()
    {
        $e = new Experiment('test experiment', new Laboratory());
        $control = function () {
            return true;
        };
        $e->control($control);
        $this->assertSame($control, $e->getControl());
    }

    public function testThatControlContextDefaultsToNull()
    {
        $e = new Experiment('test experiment', new Laboratory());
        $e->control(function () {
            return true;
        });
        $this->assertNull($e->getControlContext());
    }

    public function testThatControlContextCanBeDefined()
    {
        $context = ['foo' => 'bar'];
        $e = new Experiment('test experiment', new Laboratory());
        $e->control(function () {
            return true;
        }, $context);
        $this->assertSame($context, $e->getControlContext());
    }

    public function testThatATrialCallbackCanBeDefined()
    {
        $e = new Experiment('test experiment', new Laboratory());
        $trial = function () {
            return true;
        };
        $e->trial('trial', $trial);
        $this->assertSame($trial, $e->getTrial('trial'));
    }

    public function testThatMultipleTrialCallbacksCanBeDefined()
    {
        $e = new Experiment('test experiment', new Laboratory());
        $first = function () {
            return 'first';
        };
        $second = function () {
            return 'second';
        };
        $third = function () {
            return 'third';
        };
        $e->trial('first', $first);
        $e->trial('second', $second);
        $e->trial('third', $third);
        $expected = [
            'first',
            'second',
            'third',
        ];
        $trials = $e->getTrials();
        $this->assertSame($expected, array_keys($trials));
        $this->assertContainsOnlyInstancesOf(Trial::class, $trials);
    }

    public function testThatAChanceVariableCanBeSet()
    {
        $chance = $this->createMock('\Scientist\Chances\Chance');
        $e = new Experiment('test experiment', new Laboratory());
        $e->chance($chance);
        $this->assertEquals($chance, $e->getChance());
    }

    public function testThatAnExperimentMatcherCanBeSet()
    {
        $e = new Experiment('test experiment', new Laboratory());
        $e->matcher(new StandardMatcher());
        $this->assertInstanceOf(StandardMatcher::class, $e->getMatcher());
    }

    public function testThatAnExperimentLaboratoryCanBeSet()
    {
        $l = new Laboratory();
        $e = new Experiment('test experiment', $l);
        $this->assertInstanceOf(Laboratory::class, $e->getLaboratory());
        $this->assertSame($l, $e->getLaboratory());
    }

    public function testThatRunningExperimentWithNoLaboratoryExecutesControl()
    {
        $e = new Experiment('test experiment', new Laboratory());
        $e->control(function () {
            return 'foo';
        });
        $v = $e->run();
        $this->assertEquals('foo', $v);
    }

    public function testThatRunningExperimentWithZeroChanceExecutesControl()
    {
        $chance = $this->getMockChance();
        $chance->expects($this->once())
            ->method('shouldRun')
            ->willReturn(false);

        $l = new Laboratory();
        $v = $l->experiment('test experiment')
            ->control(function () {
                return 'foo';
            })
            ->chance($chance)
            ->run();

        $this->assertEquals('foo', $v);
    }

    public function getMockChance()
    {
        return $this->getMockBuilder('\Scientist\Chances\Chance')
            ->disableOriginalConstructor()
            ->disableProxyingToOriginalMethods()
            ->getMock();
    }
}
