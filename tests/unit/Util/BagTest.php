<?php

use Feather\Support\Util\Bag;
use PHPUnit\Framework\TestCase;

/**
 * Description of BagTest
 *
 * @author fcarbah
 */
class BagTest extends TestCase
{

    /** @var \Feather\Support\Util\Bag * */
    protected static $bag;

    public static function setUpBeforeClass(): void
    {
        static::$bag = new Bag();
    }

    public static function tearDownAfterClass(): void
    {
        static::$bag = null;
    }

    /**
     * @test
     */
    public function addItem()
    {
        static::$bag->add('apple', 'Apple');
        $this->assertTrue(static::$bag->count() === 1);
    }

    /**
     * @test
     */
    public function addItems()
    {
        static::$bag->addItems([
            'banana' => 'Banana',
            'orange' => 'Orange',
            'lemon' => 'Lemon',
        ]);

        $this->assertTrue(static::$bag->count() === 4);
    }

    /**
     * @test
     */
    public function removeItem()
    {
        static::$bag->removeItem('orange');
        $this->assertTrue(static::$bag->count() === 3);
    }

    /**
     * @test
     */
    public function getExistingItem()
    {
        $apple = static::$bag->get('apple');
        $this->assertTrue($apple === 'Apple');
    }

    /**
     * @test
     */
    public function nonExistingItemShouldBeNull()
    {
        $orange = static::$bag->get('orange');
        $this->assertTrue($orange === null);
    }

}
