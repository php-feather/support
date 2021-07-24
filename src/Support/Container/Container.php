<?php

namespace Feather\Support\Container;

use Feather\Support\Util\Bag;

/**
 * Description of Container
 *
 * @author fcarbah
 */
class Container implements IContainer
{

    /** @var \Feather\Ignite\Bag * */
    protected $bag;

    public function __construct()
    {
        $this->bag = new Bag();
    }

    /**
     *
     * @param string $key
     * @param mixed $data
     */
    public function add(string $key, $data)
    {
        $this->bag->add($key, $data);
    }

    /**
     *
     * @return Feather\Support\Util\Bag
     */
    public function bag()
    {
        return $this->bag;
    }

    /**
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->resolve($key);
    }

    /**
     *
     * @param string $key
     * @return bool
     */
    public function hasKey(string $key)
    {
        return $this->bag->hasKey($key);
    }

    /**
     *
     * @param string $key
     * @param \Closure $closure
     */
    public function register(string $key, \Closure $closure)
    {
        $this->bag->add($key, $closure);
    }

    /**
     *
     * @param string $key
     * @return mixed
     */
    protected function resolve($key)
    {

        $val = $this->bag->{$key};

        if ($val instanceof \Closure) {

            $reflectionFunc = new \ReflectionFunction($val);

            $parameters = $reflectionFunc->getParameters();

            if (empty($parameters)) {
                return call_user_func($val);
            }

            $params = $this->resolveParameters($parameters);

            $res = call_user_func_array($val, $params);

            $this->updateBag($key, $res);

            return $res;
        }

        return $val;
    }

    /**
     *
     * @param array $parameters
     * @return array
     */
    protected function resolveParameters(array $parameters)
    {
        $params = [];

        foreach ($parameters as $param) {
            $key = $param->getName();
            $val = $this->resolve($key);
            if ($val === null && $param->isOptional() && $param->isDefaultValueAvailable()) {
                $params[] = $param->getDefaultValue();
            } else {
                $this->updateBag($key, $val);
                $params[] = $val;
            }
        }

        return $params;
    }

    /**
     *
     * @param string $key
     * @param mixed $value
     */
    protected function updateBag($key, $value)
    {
        $this->bag->add($key, $value);
    }

}
