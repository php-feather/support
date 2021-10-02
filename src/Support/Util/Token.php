<?php

namespace Feather\Support\Util;

/**
 * Description of Token
 *
 * @author fcarbah
 */
class Token
{

    /** @var string * */
    protected $id;

    /** @var string * */
    protected $value;

    /** @var int * */
    protected $expire = 0;

    /** @var int * */
    protected $expireTime;

    /**
     *
     * @param string $id
     * @param string $value
     * @param int expireAfter expiration time in minutes. 0 means until session expires
     */
    public function __construct(string $id, string $value, int $expireAfter = 0)
    {
        $this->id = $id;
        $this->value = $value;
        $this->setExpireTime($expireAfter);
    }

    /**
     *
     * @return int
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     *
     * @return boolean
     */
    public function isExpired()
    {
        if ($this->expire <= 0) {
            return false;
        }
        $time = time();

        return $time > $this->expireTime;
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     *
     * @param int $time
     */
    protected function setExpireTime(int $time)
    {
        if ($time > 0) {
            $this->expireTime = time() + ($time * 60);
            $this->expire = $time;
        }
    }

}
