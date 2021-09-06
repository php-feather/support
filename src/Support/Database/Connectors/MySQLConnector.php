<?php

namespace Feather\Support\Database\Connectors;

use PDO;

/**
 * Description of MySQLConnector
 *
 * @author fcarbah
 */
class MySQLConnector extends Connector
{

    /**
     * Connects to a MySql DB
     * @param array $config
     * @return \PDO
     * @throws \Exception
     */
    public function connect(array $config): \PDO
    {
        $dsn = $this->getDSN($config);
        $pdoOptions = $this->getOptions($config);

        $this->createConnection($dsn, $config, $pdoOptions);

        $this->configureConnection($config);

        $this->configureConnectionMode($config);

        return $this->pdo;
    }

    /**
     *
     * @param array $config
     */
    protected function configureConnection(array $config)
    {
        //set character encoding
        if (isset($config['charset'])) {
            $charset = $config['charset'];
            $collation = $config['collate'] ? 'collate ' . $config['collate'] : '';

            $this->pdo->prepare("set names '{$charset}' $collation")
                    ->execute();
        }

        //set isolation level
        if (isset($config['isolation_level'])) {
            $this->pdo->prepare("SET SESSION TRANSACTION ISOLATION LEVEL {$config['isolation_level']}")
                    ->execute();
        }

        //set timezone
        if (isset($config['timezone'])) {
            $timezone = $config['timezone'];
            $this->pdo->prepare("set time_zone='$timezone'")
                    ->execute();
        }
    }

    /**
     *
     * @param array $config
     */
    protected function configureConnectionMode(array $config)
    {

        if (isset($config['modes'])) {
            $modes = implode(',', $config['modes']);
            $this->pdo->prepare("set sql_mode='$modes'")
                    ->execute();
        }

        if (isset($config['strict'])) {

            if ($config['strict']) {
                $this->setStrictMode();
            } else {
                $this->pdo->prepare("set session sql_mode='NO_ENGINE_SUBSTITUTION'")
                        ->execute();
            }
        }
    }

    /**
     * Creates a PDO connection to a MYSQL server
     * @param string $dsn
     * @param array $config
     * @param array $options
     */
    protected function createConnection(string $dsn, array $config, array $options)
    {
        $username = $config['username'] ?? null;
        $password = $config['password'] ?? null;

        $this->pdo = new PDO($dsn, $username, $password, $options);

        if (isset($config['database']) && !empty($config['database'])) {
            $this->pdo->exec("use {$config['database']};");
        }
    }

    /**
     *
     * @param array $config
     * @return string
     */
    protected function getDSN(array $config)
    {
        $database = $config['database'] ?? '';
        $host = $config['host'] ?? '';
        $port = $config['port'] ?? '';

        if (isset($port)) {
            return "mysql:host=$host;port=$port;dbname=$database";
        }

        return "mysql:host=$host;dbname=$database";
    }

    /**
     *
     */
    protected function setStrictMode()
    {
        if (version_compare($this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION), '8.0.11') >= 0) {
            $sql = "set session sql_mode='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'";
        } else {
            $sql = "set session sql_mode='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'";
        }

        $this->pdo->prepare($sql)
                ->execute();
    }

}
