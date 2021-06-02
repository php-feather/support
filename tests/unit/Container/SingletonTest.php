<?php

use Feather\Support\Container\Singleton;
use PHPUnit\Framework\TestCase;

/**
 * Description of SingletonTest
 *
 * @author fcarbah
 */
class SingletonTest extends TestCase
{

    /** @var \Feather\Support\Container\Container * */
    protected static $container;

    /** @var \Feather\Support\Container\Container * */
    protected static $container2;

    public static function setUpBeforeClass(): void
    {
        static::$container = Singleton::getInstance();

        static::$container->add('key1', 'Key1');

        static::$container2 = Singleton::getInstance();
    }

    public static function tearDownAfterClass(): void
    {
        static::$container = null;
        static::$container2 = null;
    }

    /**
     * @test
     */
    public function container2HasItemAddedToContainer()
    {
        $val = static::$container2->get('key1');
        $this->assertEquals('Key1', $val);
    }

    /**
     * @test
     */
    public function containerHasItemAddedToContainer2()
    {
        static::$container2->add('key2', 'Key2');
        $val = static::$container->get('key2');
        $this->assertEquals('Key2', $val);
    }

    public function containersAreSameSize()
    {
        static::$container2->add('key3', 'Key3');
        $count = static::$container->bag()->count();
        $count2 = static::$container2->bag()->count();
        $this->assertEquals($count, $count2);
    }

}
