<?php

namespace Chat\Inject;

use \Chat\Database;
use \Chat\Injector;


/**
 * Provides class field that contains instance of PDO MySQL
 * connector and can retrieve it from IoC-container.
 */
trait MySQL
{
    /**
     * Injected instance of PDO MySQL connector.
     *
     * @var Database
     */
    protected $MySQL;


    /**
     * Retrieves instance of PDO MySQL connector from
     * IoC-container if it is not set yet.
     *
     * @return Database Initialized instance of PDO MySQL connector.
     */
    protected function initMySQL(): Database
    {
        if (!isset($this->MySQL)) {
            $this->MySQL = Injector::make('MySQL');
        }

        return $this->MySQL;
    }
}
