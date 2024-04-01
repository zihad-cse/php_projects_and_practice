<?php

//This sets up a class that would create a database connection. Within the class SQL queries can be executed as well.

class DatabaseConnection
{
    private $dbHost;
    private $dbUser;
    private $dbPass;
    private $dbName;
    public $dbLink;

    public function __construct($host, $user, $pass, $database)
    {
        $this->dbHost = $host;
        $this->dbUser = $user;
        $this->dbPass = $pass;
        $this->dbName = $database;

        $this->dbLink = new mysqli($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);

        if ($this->dbLink->connect_error) {
            die('Connection Failed: ' . $this->dbLink->connect_error);
        }
    }
    public function query($sql)
    {
        return $this->dbLink->query($sql);
    }
    public function close()
    {
        return $this->dbLink->close();
    }
}
