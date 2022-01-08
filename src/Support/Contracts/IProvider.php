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
     * Register object or data
     * @return mixed
     */
    public function register();
}
