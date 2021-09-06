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
        $dbConfig = [
            'driver' => 'mysql',
            'username' => 'root',
            'host' => '127.0.0.1',
            'database' => 'feather'
        ];
        $db = new Dbal($dbConfig);

        $this->assertTrue($db->connect());
        $this->assertTrue($db->getPdo() instanceof PDO);
    }

    /**
     * @test
     */
    public function closeDBConnection()
    {
        $dbConfig = [
            'driver' => 'mysql',
            'username' => 'root',
            'host' => '127.0.0.1',
            'database' => 'feather'
        ];
        $db = new Dbal($dbConfig);

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
        $dbConfig = [
            'driver' => 'mysql',
            'username' => 'root',
            'host' => '127.0.0.1',
            'database' => 'tests'
        ];
        $db = new Dbal($dbConfig);
        $db->connect();
    }

}
