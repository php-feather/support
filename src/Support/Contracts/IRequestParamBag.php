<?php

namespace Feather\Support\Contracts;

use Feather\Support\Util\Bag;

/**
 *
 * @author fcarbah
 */
interface IRequestParamBag
{

    /**
     *
     * @param array $items
     * @param bool $update
     */
    public function addItems(array $items, bool $update);

    /**
     *
     * @param string $key
     * @param mixed $default
     * @return \Feather\Support\Util\Bag|mixed
     */
    public function all($key, $default);

    /**
     *
     * @param string $key
     * @param mixed $default
     * @return \Feather\Support\Util\Bag|mixed
     */
    public function cookie($key, $default);

    /**
     *
     * @param string $key
     * @param mixed $default
     * @return \Feather\Support\Util\Bag|mixed
     */
    public function get($key, $default);

    /**
     *
     * @param string $key
     * @param mixed $default
     */
    public function header($key, $default);

    /**
     *
     * @param string $key
     * @param mixed $default
     * @return Feather\Support\Util\Bag|null
     */
    public function post($key, $default);

    /**
     *
     * @param string $key
     * @param mixed $default
     * @return Feather\Support\Util\Bag|null
     */
    public function server($key, $default);
}
