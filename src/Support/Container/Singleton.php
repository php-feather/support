<?php

namespace Feather\Support\Container;

/**
 * Description of Singleton
 *
 * @author fcarbah
 */
class Singleton extends Container
{

    /** @var \Feather\Support\Container\Singleton * */
    protected static $self;

    private function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @return \Feather\Support\Container\Singleton
     */
    public static function getInstance()
    {
        if (static::$self == null) {
            static::$self = new Singleton();
        }
        return static::$self;
    }

}
