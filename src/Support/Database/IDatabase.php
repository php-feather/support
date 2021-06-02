<?php

namespace Feather\Support\Database;

/**
 *
 * @author fcarbah
 */
interface IDatabase
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
     * Get undderlying PDO
     * @return \PDO
     */
    public function getPdo();
}
