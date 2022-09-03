<?php

namespace Feather\Support\MultiThreading;

use Amp\Parallel\Worker;
use Amp\Promise;
use Opis\Closure\SerializableClosure;
use function Amp\ParallelFunctions\parallel;
use Amp\ParallelFunctions\Internal\SerializedCallableTask;

#use function Amp\Promise\wait;

/**
 * Description of Parallel
 *
 * @author fcarbah
 */
class Parallel
{

    protected $closures = [];
    protected $order    = [];
    protected $promises = [];

    /**
     * @param string $key Unique identifier of closure or callable to execute
     * in parallel
     * @param \Closure|string|array $callable closure function or callable to
     * execute in parallel
     * @param array $args List of arguments to pass to callable
     */
    public function add(string $key, $callable, array $args)
    {
        $this->order[]        = $key;
        $this->promises[$key] = parallel($callable);
        if ($callable instanceof \Closure) {
            $this->promises[$key] = Worker\enqueue(new ParallelTask($callable, $args));
        } else {
            $this->promises[$key] = Worker\enqueueCallable($callable, $args);
        }
    }

    public function run()
    {
        $responses = Promise\wait(Promise\all($this->promises));
        return $responses;
    }

}
