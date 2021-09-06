<?php

namespace Feather\Support\Database\Connectors;

use PDO;

/**
 * Description of Connector
 *
 * @author fcarbah
 */
abstract class Connector implements IConnector
{

    /** @var \PDO * */
    protected $pdo;

    /** @var array * */
    protected $defaultOptions = [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
    ];

    /**
     *
     * @param string $driver
     * @return \Feather\Support\Database\Connectors\IConnector
     */
    public static function getConnector(string $driver)
    {
        switch ($driver) {
            case 'mysql':
                return new MySQLConnector();
            case 'pgsql':
                return new PostgresConnector();
            case 'sqlsrv':
                return new MsSQLConnector();
            default:
                throw new ConnectorException("Connection driver: $driver not supported");
        }
    }

    protected function getDrivers()
    {
        return PDO::getAvailableDrivers();
    }

    protected function getOptions(array $config)
    {
        $pdoOptions = $config['options'] ?? [];
        return array_diff_key($this->defaultOptions, $pdoOptions) + $config;
    }

    protected function buildConnectionString($driver, array $params)
    {
        $paramStr = '';

        foreach ($params as $key => $val) {
            $paramStr .= "$key=$val;";
        }

        return $driver . ':' . substr($paramStr, 0, -1);
    }

}
