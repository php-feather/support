<?php

namespace Feather\Support\Contracts;

use Feather\Support\Container\Singleton;

/**
 * Description of Provider
 *
 * @author fcarbah
 */
abstract class Provider
{

    protected $container;

    public function __construct()
    {
        $this->container = Singleton::getInstance();
    }

    /**
     * Return object/data to provide
     * @return mixed
     */
    public abstract function provide();

    /**
     * Register object or data
     * @return void
     */
    public abstract function register();
}
