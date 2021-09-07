<?php

use Feather\Support\Util\ClassFinder;
use PHPUnit\Framework\TestCase;

/**
 * Description of ClassFinderTest
 *
 * @author fcarbah
 */
class ClassFinderTest extends TestCase
{

    /**
     * @test
     */
    public function getFindExistingClassWithNamespace()
    {
        $classFinder = new ClassFinder(dirname(__FILE__, 4) . '/src/Support/Util/Bag.php', true);
        $name = $classFinder->load();
        $this->assertEquals('\Feather\Support\Util\Bag', $name);
    }

    /**
     * @test
     */
    public function getFindExistingClassWithoutNamespace()
    {
        $classFinder = new ClassFinder(dirname(__FILE__, 4) . '/src/Support/Database/Connection.php', false);
        $name = $classFinder->load();
        $this->assertEquals('Connection', $name);
    }

    /**
     * @test
     */
    public function shouldReturnNullForNonExistent()
    {
        $classFinder = new ClassFinder(dirname(__FILE__, 4) . '/src/Support/Util/Param.php', true);
        $name = $classFinder->load();
        $this->assertEquals(null, $name);
    }

}
