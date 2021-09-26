<?php

namespace Feather\Support\Contracts;

/**
 *
 * @author fcarbah
 */
interface IApp
{

    /**
     *
     * @param string $key
     * @return Feather\Support\Container\IContainer|mixed
     */
    public function container($key);
}
