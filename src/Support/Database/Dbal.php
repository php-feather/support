<?php

namespace Feather\Support\Database;

use PDO;

/**
 * Description of Dbal
 *
 * @author fcarbah
 */
class Dbal implements IDatabase
{

    /** @var \PDO * */
    protected $pdo;

    /** @var string * */
    protected $dsn;

    /** @var string * */
    protected $user;

    /** @var string * */
    protected $password;

    /** @var array * */
    protected $options = [];

    /**
     *
     * @param string $dsn
     * @param string $user
     * @param string $password
     * @param array $pdoOptions
     */
    public function __construct($dsn, $user, $password, array $pdoOptions = [])
    {
        $this->dsn = $dsn;
        $this->user = $user;
        $this->password = $password;
        $this->options = $pdoOptions;
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
        $this->pdo = new \PDO($this->dsn, $this->user, $this->password, $this->options);
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
