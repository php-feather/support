<?php

namespace Feather\Support\MultiThreading;

use Amp\Parallel\Worker\Task as AmpTask;
use Amp\Http\Client\HttpClient;
use Amp\Parallel\Worker\Environment;
use Opis\Closure\SerializableClosure;

/**
 * Description of Task
 *
 * @author fcarbah
 */
class Task implements AmpTask
{

    /** @var string|array|\Closure * */
    protected $callback;

    /** @var array * */
    protected $args;

    /** @var bool * */
    protected $isClosure = false;

    /**
     *
     * @param string|array|\Closure $callback
     * @param array $args
     */
    public function __construct($callback, array $args = [])
    {

        if ($callback instanceof \Closure) {
            $callback        = new SerializeClosure($callback);
            $this->isClosure = true;
        }
        $this->callback = $callback;

        $this->args = $args;
    }

    public function run(Environment $environment)
    {
        if ($this->isClosure) {
            $this->callback = $this->callback->getClosureFromCode($this->args);
        }

        if ($this->callback instanceof \__PHP_Incomplete_Class) {
            throw new MultiThreadException('When using a class instance as a callable, the class must be autoloadable', 100);
        }

        if (\is_array($this->callback) && ($this->callback[0] ?? null) instanceof \__PHP_Incomplete_Class) {
            throw new MultiThreadException('When using a class instance method as a callable, the class must be autoloadable', 101);
        }

        if (!is_callable($this->callback) && !$this->callback instanceof \Closure) {
            $message = 'User-defined functions must be autoloadable (that is, defined in a file autoloaded by composer)';
            if (\is_string($this->callback)) {
                $message .= 'Unable to load function ' . $this->callback;
            }
            throw new MultiThreadException($message);
        }

        return call_user_func_array($this->callback, $this->args);
    }

}
