<?php

namespace repertoire\db;

abstract class AbstractConnection {

    protected $pdo;

    function __construct($host, $database, $username, $pw) {
        $this->pdo = new \PDO('mysql:host=' . $host . ';dbname=' . $database, $username, $pw);
        $this->firstInit();
    }

    abstract function createTables();

    abstract function init();

    function firstInit() {
        $this->createTables();
        $this->init();
    }

}
