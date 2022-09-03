<?php

namespace Feather\Support\MultiThreading;

use Amp\Parallel\Worker\Task;
use Closure;
use Opis\Closure\SerializableClosure;

/**
 * Description of ParallelTask
 *
 * @author fcarbah
 */
class ParallelTask implements Task
{

    public string $callable; // serialize string representation of clossure
    public array $args = []; // closure arguments

    public function __construct(Closure $closure, array $args)
    {
        $callable = new SerializableClosure($closure);

        $this->callable = \serialize($callable);

        $this->args = $args;
    }

    public function run(\Amp\Parallel\Worker\Environment $environment)
    {

        $callable = \unserialize($this->callable, ['allowed_classes' => true]);

        return $callable(...$this->args);
    }

}
