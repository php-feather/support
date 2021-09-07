<?php

use Feather\Support\Database\Connection;
use PHPUnit\Framework\TestCase;

/**
 * Description of ConnectionTest
 *
 * @author fcarbah
 */
class ConnectionTest extends TestCase
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
        $db = new Connection($dbConfig);

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
        $db = new Connection($dbConfig);

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
        $db = new Connection($dbConfig);
        $db->connect();
    }

}
