<?php

declare(strict_types=1);

namespace Scientist\Chances;

interface Chance
{
    /**
     * Determine whether or not the experiment should run
     */
    public function shouldRun(): bool;
}
