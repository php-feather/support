<?php

use Feather\Support\Container\Container;
use PHPUnit\Framework\TestCase;

/**
 * Description of ContainerTest
 *
 * @author fcarbah
 */
class ContainerTest extends TestCase
{

    /** @var \Feather\Support\Container\Container * */
    protected static $container;

    public static function setUpBeforeClass(): void
    {
        static::$container = new Container();
    }

    public static function tearDownAfterClass(): void
    {
        static::$container = null;
    }

    /**
     * @test
     */
    public function addItemToContainer()
    {
        static::$container->add('name', 'Steve');
        $count = static::$container->bag()->count();
        $this->assertEquals(1, $count);
    }

    /**
     * @test
     */
    public function registerItemToContainer()
    {
        static::$container->register('numbers', function () {
            return [1, 2, 3, 4, 5];
        });

        $count = static::$container->bag()->count();

        $this->assertTrue($count == 2);
    }

    /**
     * @test
     */
    public function getExistingItem()
    {
        $numbers = static::$container->get('numbers');
        $this->assertTrue(is_array($numbers));
    }

    /**
     * @test
     */
    public function shouldNotHaveNonExistentKey()
    {
        $val = static::$container->hasKey('testkey');
        $this->assertFalse($val);
    }

    /**
     * @test
     */
    public function getItemWithDependencyFromContainer()
    {
        static::$container->register('numbers_sum', function($numbers) {
            return array_sum($numbers);
        });

        $sum = static::$container->get('numbers_sum');

        $this->assertEquals(15, $sum);
    }

}
