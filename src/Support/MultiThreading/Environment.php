<?php

namespace Feather\Support\MultiThreading;

use Feather\Support\Util\Bag;
use Amp\Parallel\Worker\Environment as IEnvironment;

/**
 * Description of Environment
 *
 * @author fcarbah
 */
class Environment extends Bag implements IEnvironment
{

    /**
     *
     * @param string $key
     * @return bool
     */
    public function delete(string $key)
    {
        return $this->remove($key);
    }

    /**
     *
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool
    {
        return $this->hasKey($key);
    }

    public function set(string $key, $value, int $ttl = null)
    {
        $this->add($key, $value);
    }

}
