<?php

namespace Feather\Support\Database\Connectors;

/**
 *
 * @author fcarbah
 */
interface IConnector
{

    /**
     *
     * @param array $config
     * @return \PDO
     * @throws \Exception
     */
    public function connect(array $config): \PDO;
}
