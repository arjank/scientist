<?php

namespace Scientist\Journals;

use PHPUnit\Framework\TestCase;
use Scientist\Report;
use Scientist\Laboratory;
use Scientist\Experiment;

class JournalTest extends TestCase
{
    public function testThatJournalsCanBeCreated()
    {
        $s = new StandardJournal();
        $this->assertInstanceOf(StandardJournal::class, $s);
    }

    public function testThatAJournalCanBeAddedToALaboratory()
    {
        $lab = new Laboratory();
        $lab->addJournal(new StandardJournal());
        $this->assertEquals([new StandardJournal()], $lab->getJournals());
    }

    public function testThatMultipleJournalsCanBeAddedToALaboratory()
    {
        $lab = new Laboratory();
        $lab->addJournal(new StandardJournal());
        $lab->addJournal(new StandardJournal());
        $this->assertEquals([new StandardJournal(), new StandardJournal()], $lab->getJournals());
    }

    public function testThatASetOfJournalsCanBeAssignedToALaboratory()
    {
        $lab = new Laboratory();
        $lab->setJournals([new StandardJournal(), new StandardJournal()]);
        $this->assertEquals([new StandardJournal(), new StandardJournal()], $lab->getJournals());
    }

    public function testThatJournalReceivesExperimentInformation()
    {
        $lab = new Laboratory();
        $journal = new StandardJournal();
        $lab->addJournal($journal);

        $control = function () {
            return 'foo';
        };
        $trial = function () {
            return 'bar';
        };

        $value = $lab->experiment('foo')
            ->control($control)
            ->trial('bar', $trial)
            ->run();

        $this->assertEquals('foo', $value);
        $this->assertInstanceOf(Experiment::class, $journal->getExperiment());
        $this->assertEquals($control, $journal->getExperiment()->getControl());
        $this->assertArrayHasKey('bar', $journal->getExperiment()->getTrials());
        $this->assertEquals($trial, $journal->getExperiment()->getTrial('bar'));
    }

    public function testThatJournalReceivesResultInformation()
    {
        $lab = new Laboratory();
        $journal = new StandardJournal();
        $lab->addJournal($journal);

        $control = function () {
            return 'foo';
        };
        $trial = function () {
            return 'bar';
        };

        $value = $lab->experiment('foo')
            ->control($control)
            ->trial('bar', $trial)
            ->run();

        $this->assertEquals('foo', $value);
        $this->assertInstanceOf(Report::class, $journal->getReport());
        $this->assertEquals('foo', $journal->getReport()->getName());
        $this->assertEquals('foo', $journal->getReport()->getControl()->getValue());
        $this->assertEquals('bar', $journal->getReport()->getTrial('bar')->getValue());
        $this->assertEquals(false, $journal->getReport()->getTrial('bar')->isMatch());
    }
}
