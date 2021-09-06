<?php

namespace Feather\Support\Database\Connectors;

/**
 * Description of MsSQLConnector
 *
 * @author fcarbah
 */
class MsSQLConnector extends Connector
{

    /**
     *
     * @param array $config
     * @return \PDO
     * @throws \Exception
     */
    public function connect(array $config): \PDO
    {
        $dsn = $this->getDSN($config);
        $options = $this->getOptions($config);
        $this->createConnection($dsn, $config, $options);

        return $this->pdo;
    }

    /**
     *
     * @param array $config
     * @return string
     */
    protected function buildDBlibDSN(array $config)
    {
        $port = $config['port'] ?? null;
        $params = [
            'host' => $port ? "{$config['host']}:$port" : $config['host'],
            'dbname' => $config['database'],
        ];

        if (isset($config['appname'])) {
            $params['appname'] = $config['appname'];
        }

        if (isset($config['charset'])) {
            $params['charset'] = $config['charset'];
        }

        if (isset($config['version'])) {
            $params['version'] = $config['version'];
        }

        return $this->buildConnectionString('dblib', $params);
    }

    /**
     *
     * @param array $config
     * @return string
     */
    protected function buildSqlDSN(array $config)
    {
        $params = [];
        $port = $config['port'] ?? null;

        $params['Server'] = $port ? $config['host'] . ',' . $port : $config['host'];

        if (isset($config['database'])) {
            $params['Database'] = $config['database'];
        }

        if (isset($config['readonly'])) {
            $params['ApplicationIntent'] = 'ReadOnly';
        }

        if (isset($config['pooling']) && $config['pooling'] === false) {
            $params['ConnectionPooling'] = '0';
        }

        if (isset($config['transaction_isolation'])) {
            $params['TransactionIsolation'] = $config['transaction_isolation'];
        }

        if (isset($config['login_timeout'])) {
            $params['LoginTimeout'] = $config['login_timeout'];
        }

        if (isset($config['appname'])) {
            $arguments['APP'] = $config['appname'];
        }

        if (isset($config['encrypt'])) {
            $arguments['Encrypt'] = $config['encrypt'];
        }

        if (isset($config['trust_server_certificate'])) {
            $arguments['TrustServerCertificate'] = $config['trust_server_certificate'];
        }

        if (isset($config['multiple_active_result_sets']) && $config['multiple_active_result_sets'] === false) {
            $arguments['MultipleActiveResultSets'] = 'false';
        }

        if (isset($config['transaction_isolation'])) {
            $arguments['TransactionIsolation'] = $config['transaction_isolation'];
        }

        if (isset($config['multi_subnet_failover'])) {
            $arguments['MultiSubnetFailover'] = $config['multi_subnet_failover'];
        }

        if (isset($config['column_encryption'])) {
            $arguments['ColumnEncryption'] = $config['column_encryption'];
        }

        if (isset($config['key_store_authentication'])) {
            $arguments['KeyStoreAuthentication'] = $config['key_store_authentication'];
        }

        if (isset($config['key_store_principal_id'])) {
            $arguments['KeyStorePrincipalId'] = $config['key_store_principal_id'];
        }

        if (isset($config['key_store_secret'])) {
            $arguments['KeyStoreSecret'] = $config['key_store_secret'];
        }

        return $this->buildConnectionString('sqlsrv', $params);
    }

    /**
     * Creates PDO connection to SQl Server DB
     * @param string $dsn
     * @param array $config
     * @param array $options
     */
    protected function createConnection(string $dsn, array $config, array $options)
    {
        $username = $config['username'] ?? null;
        $password = $config['password'] ?? null;

        $this->pdo = new \PDO($dsn, $username, $password, $options);
    }

    /**
     *
     * @param array $config
     * @return string
     */
    protected function getDSN(array $config)
    {
        $drivers = $this->getDrivers();

        if (isset($config['odbc']) && in_array('odbc', $drivers)) {
            return isset($config['odbc_datasource_name']) ? "odbc:{$config['odbc_datasource_name']}" : '';
        } elseif (in_array('sqlsrv', $drivers)) {
            return $this->buildSqlDSN($config);
        } else {
            return $this->buildDBlibDSN($config);
        }
    }

}
