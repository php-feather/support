<?php

namespace Feather\Support\Util;

/**
 * Description of Bag
 *
 * @author fcarbah
 */
class Bag implements \ArrayAccess, \IteratorAggregate, \JsonSerializable
{

    /** @var array * */
    protected $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     *
     * @param string|int $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->items[$name] ?? null;
    }

    /**
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->items[$name] = $value;
    }

    /**
     * Add data to container
     * @param string|int $key
     * @param mixed $value
     */
    public function addItem($key, $value)
    {
        $this->items[$key] = $value;
    }

    /**
     * Add multiple items to container
     * @param array $items
     */
    public function addItems(array $items)
    {
        $this->items = array_merge($this->items, $items);
    }

    /**
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     *
     * @param string $key
     * @return mixed
     */
    public function getItem($key)
    {
        return $this->items[$key] ?? null;
    }

    /**
     * Get all items in the container
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     *
     * @param string|int $key
     * @return bool
     */
    public function hasKey($key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     *
     * @param string $key
     * @return boolean
     */
    public function removeItem($key)
    {

        if (array_key_exists($key, $this->items)) {
            unset($this->items[$key]);
            return true;
        }

        return false;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset] ?? null;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value): void
    {
        $this->items[$offset] = $value;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function offsetUnset($offset): void
    {
        if (array_key_exists($offset, $this->items)) {
            unset($this->items[$offset]);
        }
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    /**
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return json_encode($this->items);
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        $str = '';
        foreach ($this->items as $key => $val) {

            if (is_array($val) || is_object($val)) {
                $val = json_encode($val, JSON_INVALID_UTF8_IGNORE);
            }

            $str .= "$key=$val&";
        }

        return $str ? substr($str, 0, -1) : $str;
    }

}
