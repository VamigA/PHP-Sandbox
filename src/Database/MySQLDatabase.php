<?php

namespace Chat\Database;

use \Chat\Database;


/**
 * Implements database connector that returns PDO MySQL connection.
 */
class MySQLDatabase implements Database
{
    /**
     * PDO MySQL connection instance.
     * 
     * @var \PDO
     */
    private $pdo = null;


    /**
     * Creates the connection to the database.
     * 
     * @param string $host  Database host.
     * @param string $database  Database name.
     * @param string $user  Database user.
     * @param string $password  Database user's password.
     */
    public function __construct(
        string $host, string $database, string $user, string $password
    ) {
        $dsn = 'mysql:host='.$host.';dbname='.$database;

        $this->pdo = new \PDO(
            $dsn, $user, $password,
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        );
    }

    /**
     * Returns the PDO MySQL connection instance.
     * 
     * @return \PDO
     */
    public function getConnection(): \PDO
    {
        return $this->pdo;
    }
}
