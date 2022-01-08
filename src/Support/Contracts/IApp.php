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
     * @param string|null $key
     * @return Feather\Support\Container\IContainer|mixed
     */
    public function container(string $key = null);
}
