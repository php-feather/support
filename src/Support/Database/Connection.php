<?php

namespace Feather\Support\Database;

use Feather\Support\Database\Connectors\Connector;
use Feather\Support\Database\Connectors\IConnector;
use PDO;

/**
 * Description of Dbal
 *
 * @author fcarbah
 */
class Connection implements IConnection
{

    /** @var \PDO * */
    protected $pdo;

    /** @var array * */
    protected $config = [];

    /**
     *
     * @param string $dsn
     * @param string $user
     * @param string $password
     * @param array $pdoOptions
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        if (!$this->pdo) {
            throw new Exception("Method $name does not exist");
        }

        return call_user_func_array([$this->pdo, $name], $arguments);
    }

    /**
     * Close Database connection
     * @return bool
     */
    public function close()
    {
        $this->pdo = null;
        return true;
    }

    /**
     * Connect to Database
     * @return bool
     */
    public function connect()
    {

        if ($this->pdo) {
            return true;
        }

        if (isset($this->config['connector'])) {

            $connector = $this->config['connector'];

            if ($connector instanceof IConnector) {
                $this->pdo = $connector->connect($this->config);
                return true;
            }

            if (is_string($connector) && class_exists($connector) && ($connector = new $connector()) instanceof IConnector) {
                $this->pdo = $connector->connect($this->config);
                return true;
            }
        }

        $driver = $this->config['driver'] ?? '';
        $connector = Connector::getConnector(strtolower($driver));
        $this->pdo = $connector->connect($this->config);

        return true;
    }

    /**
     * Get underlying PDO object
     * @return \PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

}
