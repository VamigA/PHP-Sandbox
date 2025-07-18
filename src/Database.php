<?php

namespace Chat;


/**
 * Describes behavior that each database connector of application must implement.
 */
interface Database
{
    /**
     * Returns PDO connection to the database.
     *
     * @return \PDO PDO connection.
     */
    public function getConnection(): \PDO;
}
