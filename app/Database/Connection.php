<?php

namespace App\Database;

use PDO;

class Connection
{

    public $database;

    public function connect()
    {
        $user = 'root';
        $password = 'password';
        $host = 'mysql';
        $dbName = "scandiweb";

        $this->database = new PDO("mysql:host=$host;dbname=$dbName;", $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => true
        ]);

        return $this->database;
    }

    public function getInstance()
    {
        if ($this->database) {
            return $this->database;
        }
        return $this->connect();
    }
}
