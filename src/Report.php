<?php

declare(strict_types=1);

namespace Scientist;

/**
 * Class Result
 *
 * Here we have the results of our experiment. My fingers are crossed for
 * you! - Dayle.
 *
 * @package \Scientist
 */
class Report
{
    /**
     * The experiment name.
     *
     * @var string
     */
    protected $name;

    /**
     * The control result.
     *
     * @var Result
     */
    protected $control;

    /**
     * The trial results.
     *
     * @var Result[]
     */
    protected $trials = [];

    /**
     * Create a new result instance.
     *
     * @param string $name
     * @param Result $control
     * @param Result[] $trials
     */
    public function __construct($name, Result $control, array $trials = [])
    {
        $this->name = $name;
        $this->control = $control;
        $this->trials = $trials;
    }

    /**
     * Get the experiment name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the control result instance.
     *
     * @return Result
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * Get a trial result instance by name.
     *
     * @param string $name
     *
     * @return Result
     */
    public function getTrial($name)
    {
        return $this->trials[$name];
    }

    /**
     * Get the trial result instances.
     *
     * @return Result[]
     */
    public function getTrials()
    {
        return $this->trials;
    }
}
