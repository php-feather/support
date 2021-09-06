<?php

namespace Feather\Support\Database\Connectors;

/**
 * Description of PostgresConnector
 *
 * @author fcarbah
 */
class PostgresConnector extends Connector
{

    /**
     * Connects to a postgres DB
     * @param array $config
     * @return \PDO
     * @throws \Exception
     */
    public function connect(array $config): \PDO
    {
        $dsn = $this->getDSN($config);
        $options = $this->getOptions($config);

        $this->createConnection($dsn, $config, $options);

        $this->configureConnection($config);

        return $this->pdo;
    }

    /**
     *
     * @param array $config
     */
    protected function configureConnection(array $config)
    {
        //application name
        if (isset($config['application_name'])) {
            $applicationName = $config['application_name'];

            $this->pdo->prepare("set application_name to '$applicationName'")
                    ->execute();
        }

        //set character encoding
        if (isset($config['charset'])) {
            $charset = $config['charset'];

            $this->pdo->prepare("set names '{$charset}'")
                    ->execute();
        }

        //set schema
        if (isset($config['schema'])) {

            $schema = is_array($config['schema']) ? '"' . implode('", "', $schema) . '"' : '"' . $schema . '"';

            $this->pdo->prepare("set search_path to $schema")
                    ->execute();
        }

        //set synchronous commit
        if (isset($config['synchronous_commit'])) {
            $this->pdo->prepare("set synchronous_commit to '{$config['synchronous_commit']}'")->execute();
        }

        //set timezone
        if (isset($config['timezone'])) {
            $timezone = $config['timezone'];
            $this->pdo->prepare("set time zone '$timezone'")
                    ->execute();
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
            $dsn = "mysql:host=$host;port=$port;dbname=$database";
        } else {
            $dsn = "mysql:host=$host;dbname=$database";
        }

        $sslOptions = ['sslmode', 'sslcert', 'sslkey', 'sslrootcert'];
        foreach ($sslOptions as $option) {
            if (isset($config[$option])) {
                $dsn .= ";{$option}={$config[$option]}";
            }
        }

        return $dsn;
    }

}
