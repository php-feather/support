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
    public function willNotUpdateExistingItem()
    {
        static::$bag->add('banana', 'plantain');
        $val = static::$bag->get('banana');

        $this->assertFalse($val == 'plantain');
        $this->assertEquals('Banana', $val);
    }

    /**
     * @test
     */
    public function willUpdateExistingItem()
    {
        static::$bag->update(['banana' => 'plantain']);
        $val = static::$bag->get('banana');

        $this->assertFalse($val == 'Banana');
        $this->assertEquals('plantain', $val);
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

    /**
     * @test
     */
    public function willReturnIntForIntegerValue()
    {
        static::$bag->addItems([
            'int' => '12',
            'float' => '12.96',
            'bool' => 'true'
        ]);

        $int = static::$bag->getInt('int');

        $this->assertEquals(12, $int);
    }

    /**
     * @test
     */
    public function willReturnNUllForNonIntegerValue()
    {
        $int = static::$bag->getInt('bool');

        $this->assertNull($int);
    }

    /**
     * @test
     */
    public function willReturnFloatForFloatValue()
    {
        $float = static::$bag->getFloat('float');

        $this->assertEquals(12.96, $float);
    }

    /**
     * @test
     */
    public function willReturnNUllForNonFloatValue()
    {
        $float = static::$bag->getFloat('lemon');

        $this->assertNull($float);
    }

    /**
     * @test
     */
    public function willReturnBoolForBooleanValue()
    {
        $bool = static::$bag->getBoolean('bool');

        $this->assertEquals(true, $bool);
    }

    /**
     * @test
     */
    public function willReturnFalseForNonBooleanValue()
    {
        $bool = static::$bag->getBoolean('float');
        $this->assertEquals(false, $bool);
    }

    public function willReturnKeysOfItemsAdded()
    {
        $keys = static::$bag->keys();
        $this->assertTrue(is_array($keys) && count($keys) > 1);
        $this->assertTrue(in_array('banana', $keys));
    }

}
