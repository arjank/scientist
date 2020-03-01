<?php

namespace Scientist;

use PHPUnit\Framework\TestCase;

class InternTest extends TestCase
{
    public function testThatInternCanBeCreated()
    {
        $i = new Intern();
        $this->assertInstanceOf(Intern::class, $i);
    }

    public function testThatInternCanRunAnExperiment()
    {
        $i = new Intern();
        $e = new Experiment('test experiment', new Laboratory());
        $e->control(function () {
            return 'foo';
        });
        $v = $i->run($e);
        $this->assertInstanceOf(Report::class, $v);
        $this->assertEquals('foo', $v->getControl()->getValue());
    }

    public function testThatInternCanMatchControlAndTrial()
    {
        $i = new Intern();
        $e = new Experiment('test experiment', new Laboratory());
        $e->control(function () {
            return 'foo';
        });
        $e->trial('bar', function () {
            return 'foo';
        });
        $v = $i->run($e);
        $this->assertInstanceOf(Report::class, $v);
        $this->assertTrue($v->getTrial('bar')->isMatch());
    }

    public function testThatInternCanMismatchControlAndTrial()
    {
        $i = new Intern();
        $e = new Experiment('test experiment', new Laboratory());
        $e->control(function () {
            return 'foo';
        });
        $e->trial('bar', function () {
            return 'bar';
        });
        $v = $i->run($e);
        $this->assertInstanceOf(Report::class, $v);
        $this->assertFalse($v->getTrial('bar')->isMatch());
    }

    public function testThatInternCanMatchAndMismatchControlAndTrial()
    {
        $i = new Intern();
        $e = new Experiment('test experiment', new Laboratory());
        $e->control(function () {
            return 'foo';
        });
        $e->trial('bar', function () {
            return 'foo';
        });
        $e->trial('baz', function () {
            return 'baz';
        });
        $v = $i->run($e);
        $this->assertInstanceOf(Report::class, $v);
        $this->assertTrue($v->getTrial('bar')->isMatch());
        $this->assertFalse($v->getTrial('baz')->isMatch());
    }
}
