<?php

namespace Feather\Support\Database;

/**
 *
 * @author fcarbah
 */
interface IConnection
{

    /**
     * Close Database connection
     * @return bool
     */
    public function close();

    /**
     * Connect to Database
     * @return bool
     */
    public function connect();

    /**
     * Get underlying PDO
     * @return \PDO
     */
    public function getPdo();
}
