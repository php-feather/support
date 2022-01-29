<?php

namespace Feather\Support\MultiThreading;

use Amp\Parallel\Worker\Worker as IWorker;
use Amp\Parallel\Worker\Task as ITask;
use Amp\Parallel\Worker\Environment as IEnvironment;
use Amp\Promise;
use Amp\Parallel\Worker\DefaultWorkerFactory;

/**
 * Description of Parallel
 *
 * @author fcarbah
 */
final class Parallelize
{

    /** @var \Amp\Parallel\Worker\Worker * */
    protected $worker;

    /** @var \Amp\Parallel\Worker\Environment* */
    protected $environment;

    /** @var array * */
    protected $tasks = [];

    /** @var array * */
    protected $priority = [];

    /** @var bool * */
    protected $running = false;

    /**
     *
     * @param \Amp\Parallel\Worker\Environment|null $environment
     * @param \Amp\Parallel\Worker\Worker|null $worker
     */
    public function __construct(IEnvironment $environment = null, IWorker $worker = null)
    {
        $this->environment = $environment ?: new Environment();
        $this->worker      = $worker ?: (new DefaultWorkerFactory(get_class($this->environment)))->create();
    }

    /**
     *
     * @param \Amp\Parallel\Worker\Task $task
     * @return $this
     */
    public function addTask(ITask $task, string $key = null)
    {
        if (!$this->running) {
            if ($key) {
                $this->tasks[$key] = $task;
            } else {
                $this->tasks[] = $task;
            }
        } else {
            throw new \Warning('Tasks running. Cannot add task now');
        }
        return $this;
    }

    public function run()
    {
        if (!$this->running) {
            $this->running = true;
            $promises      = [];
            foreach ($this->priority as $key) {
                if (isset($this->tasks[$key])) {
                    $promises[$key] = $this->worker->enqueue($this->tasks[$key]);
                    unset($this->tasks[$key]);
                }
            }

            foreach ($this->tasks as $key => $task) {
                $promises[$key] = $this->worker->enqueue($task);
            }

            $results = Promise\wait(Promise\all($promises));

            $this->clear();

            return $results;
        }
        return [];
    }

    public function setTaskPriority(array $priority)
    {
        $this->priority = $priority;
    }

    protected function clear()
    {
        $this->tasks   = [];
        $this->running = false;
    }

}
