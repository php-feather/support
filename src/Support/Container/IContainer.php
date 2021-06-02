<?php

namespace Feather\Support\Container;

/**
 *
 * @author fcarbah
 */
interface IContainer
{

    /**
     * Add Item/Data to container
     * @param string $key
     * @param type $data
     */
    public function add(string $key, $data);

    /**
     * Get item data from container
     * @param string $key
     */
    public function get(string $key);

    /**
     *
     * @param string $key
     * @return bool
     */
    public function hasKey(string $key);

    /**
     *
     * @param string $key
     * @param \Closure $closure
     */
    public function register(string $key, \Closure $closure);
}
