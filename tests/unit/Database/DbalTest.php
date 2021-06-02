<?php

use Feather\Support\Database\Dbal;
use PHPUnit\Framework\TestCase;

/**
 * Description of DbalTest
 *
 * @author fcarbah
 */
class DbalTest extends TestCase
{

    /**
     * @test
     */
    public function connectToDB()
    {
        $db = new Dbal('mysql:host=localhost;dbname=test', 'my_user', null);

        $this->assertTrue($db->connect());
        $this->assertTrue($db->getPdo() instanceof PDO);
    }

    /**
     * @test
     */
    public function closeDBConnection()
    {
        $db = new Dbal('mysql:host=localhost;dbname=test', 'my_user', null);
        $db->connect();
        $this->assertTrue($db->close());
        $this->assertTrue($db->getPdo() === null);
    }

    /**
     * @expectedException \PDOException
     * @test
     */
    public function willThrowPDOExceptionForInvalidConnectionString()
    {
        $this->expectException(PDOException::class);
        $db = new Dbal('mysql:host=localhost;dbname=tests', 'my_user', null);
        $db->connect();
    }

}
