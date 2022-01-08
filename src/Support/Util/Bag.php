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
     * Add data to bag
     * If a key already exist, the original key will not be overwritten
     * To replace an existing item use the update() method instead
     * @param string|int $key
     * @param mixed $value
     */
    public function add($key, $value)
    {
        if (!isset($this->items[$key])) {
            $this->items[$key] = $value;
        }
    }

    /**
     * @deprecated will be removed in v1.0.1
     * use add()
     * @param string|int $key
     * @param mixed $value
     */
    public function addItem($key, $value)
    {
        $this->add($key, $value);
    }

    /**
     * Add multiple items to container
     * If a key already exist, the original key will not be overwritten
     * To replace an existing item use the update() method instead
     * @param array $items
     */
    public function addItems(array $items)
    {
        $itemsToAdd  = array_diff($items, $this->items);
        $this->items = array_merge($this->items, $itemsToAdd);
    }

    /**
     * Get all items in the container
     * @return array
     */
    public function all()
    {
        return $this->items;
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
    public function get($key)
    {
        return $this->items[$key] ?? null;
    }

    /**
     *
     * @param string $key
     * @return bool|null
     */
    public function getBoolean($key)
    {
        $val = $this->get($key);

        return filter_var($val, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     *
     * @param string $key
     * @return float
     */
    public function getFloat($key, float $default = 0.0)
    {
        $val = $this->get($key);

        if (is_numeric($val)) {
            return floatval($val);
        }

        return $default;
    }

    /**
     *
     * @param string $key
     * @return int
     */
    public function getInt($key, int $default = 0)
    {
        $val = $this->get($key);

        if (is_numeric($val)) {
            return intval($val);
        }

        return $default;
    }

    /**
     * @deprecated will be removed in v1.0.1
     * use get()
     * @param string|int $key
     * @return mixed
     */
    public function getItem($key)
    {
        return $this->get($key);
    }

    /**
     *
     * @deprecated will be removed in v1.0.1
     * use all()
     * Get all items in the container
     * @return array
     */
    public function getItems()
    {
        return $this->all();
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
     * @return array
     */
    public function keys()
    {
        return array_keys($this->items);
    }

    /**
     *
     * @param string $key
     * @return boolean
     */
    public function remove($key)
    {

        if (array_key_exists($key, $this->items)) {
            unset($this->items[$key]);
            return true;
        }

        return false;
    }

    /**
     * @deprecated will be removed in v1.0.1
     * use remove()
     * @param string $key
     * @return boolean
     */
    public function removeItem($key)
    {

        return $this->remove($key);
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
    public function offsetGet($offset): mixed
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
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return json_encode($this->items);
    }

    /**
     * Overwrite existing items if keys already exist or add them if it doesn't already exist
     * @param array $items
     */
    public function update(array $items)
    {
        $this->items = array_merge($this->items, $items);
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
