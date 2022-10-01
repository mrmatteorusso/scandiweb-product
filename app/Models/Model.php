<?php

namespace App\Models;

use PDO;
use App\Database\Connection;

abstract class Model
{

    private $db;
    public $columns = [];

    public function __construct()
    {
        $this->db = (new Connection())->getInstance();
    }

    abstract public function validationRules();
    abstract public function getTable();

    public function getColumns()
    {
        return $this->columns;
    }

    public function __get($key)
    {
        return $this->columns[$key];
    }

    public function __set($key, $value)
    {
        $this->columns[$key] = $value;
    }

    public function readAll()
    {
        $query = 'SELECT * FROM ' . $this->getTable() . ' ORDER BY id ';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function readOne($productId)
    {
        $query = 'SELECT * FROM ' . $this->getTable() . ' WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $productId);
        $stmt->execute();
        $object = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->columns = $object;
        //return $this->getColumns();
        return $this;
    }

    public function readWhere($column, $value)
    {

        $query = 'SELECT * FROM ' . $this->getTable() . " WHERE $column = :$column";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":$column", $value);
        $stmt->execute();
        $object = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->columns = $object;
        // echo "\n";
        // echo "from readwhere function";
        // echo "\n";
        // echo "this is object";
        // echo "\n";
        // print_r($object);
        // echo "\n";
        // echo "this is columns";
        // echo "\n";
        // print_r($this->coloumns);
        // echo "\n";

        // print_r($this);
        // exit;



        //return $this->getColumns();
        return $this;
    }


    public function update()
    {
        $query = $this->buildUpdateQuery();
        $stmt = $this->db->prepare($query);
        return $stmt->execute($this->columns);
    }

    public function create()
    {
        $query = $this->buildInsertQuery();
        $stmt = $this->db->prepare($query);

        if ($stmt->execute($this->columns)) {
            $this->id = $this->db->lastInsertId();
            return $this;
        }
    }


    public function massDelete(array $ids)
    {
        $bidingParams = str_repeat("?,", count($ids));
        $bidingParams = rtrim($bidingParams, ",");
        $query = 'DELETE FROM ' . $this->getTable() . " WHERE id IN ($bidingParams)";
        $stmt = $this->db->prepare($query);

        if ($stmt->execute($ids)) {
            return true;
        }

        print_r($stmt->errorInfo());

        return false;
    }

    public function delete($id)
    {
        $query = 'DELETE FROM ' . $this->getTable() . ' WHERE id = :id'; //WHERE => WHERE  id IN ( ...multiple ids..)
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }

        print_r($stmt->errorInfo());
        return false;
    }

    private function buildUpdateQuery()
    {
        $columns = array_keys($this->columns);
        $accumulatorInit = [];

        $preparedCols = array_reduce($columns, function ($accumulator, $column) {
            if ($column === "id") {
                return $accumulator;
            }
            $accumulator[] = "$column=:$column";
            return $accumulator;
        }, $accumulatorInit);
        $columnsAndParamsString = implode(", ", $preparedCols);
        return "UPDATE " . $this->getTable() . " SET  $columnsAndParamsString WHERE id = :id";
    }

    private function buildInsertQuery()
    {
        $columns = array_keys($this->columns);
        $accumulatorInit = [
            "cols" => [],
            "params" => [],
        ];

        $preparedCols = array_reduce($columns, function ($accumulator, $column) {
            array_push($accumulator["cols"], $column);
            array_push($accumulator["params"], ":$column");
            return $accumulator;
        }, $accumulatorInit);

        $preparedColNames = implode(", ", $preparedCols["cols"]);
        $preparedBindParams = implode(", ", $preparedCols["params"]);

        return "INSERT INTO " . $this->getTable() . " ( $preparedColNames ) VALUES ( $preparedBindParams )";
    }
}
