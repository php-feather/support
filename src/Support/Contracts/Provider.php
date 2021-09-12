<?php

namespace Feather\Support\Contracts;

use Feather\Support\Container\Singleton;

/**
 * Description of Provider
 *
 * @author fcarbah
 */
interface IProvider
{

    /**
     * Return object/data to provide
     * @return mixed
     */
    public function provide();

    /**
     * Register object or data
     * @return void
     */
    public function register();
}
