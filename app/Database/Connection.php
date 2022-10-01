<?php

namespace App\Database;

use PDO;

class Connection
{

    public $database;

    public function connect()
    {
        // $user = 'root';
        // $password = 'password';
        // $host = 'mysql';
        // $dbName = "scandiweb";
        $user = 'gssdvq1oz8bvlpvy';
        $password = 'y6r57fswz6owh5op';
        $host = 'ltnya0pnki2ck9w8.chr7pe7iynqr.eu-west-1.rds.amazonaws.com';
        $dbName = 'p5t3d4ceejfhd8q6';

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
