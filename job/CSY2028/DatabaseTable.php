<?php
//Class that handles all Querying.
namespace CSY2028;
use Exception;

class DatabaseTable {
    private $pdo;
    private $table;
    private $primaryKey;
    private $entityClass;
    private $entityConstructor;


    public function __construct($pdo, $table, $primaryKey, $entityClass = 'stdclass', $entityConstructor = []) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->entityClass = $entityClass;
        $this->entityConstructor = $entityConstructor;
    }

    public function find($field, $value) {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
        $criteria = [
            'value' => $value
        ];
        $stmt->execute($criteria);
        return $stmt->fetchAll();
    }

    public function andFind($field, $value, $field2, $value2) {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value AND '. $field2 . ' =:value2');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
        $criteria = [
            'value' => $value,
            'value2' => $value2
        ];
        $stmt->execute($criteria);
        return $stmt->fetchAll();
    }

    public function findObject($field, $value) {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
        $criteria = [
            'value' => $value
        ];
        $stmt->execute($criteria);
        return $stmt;
    }

    public function lessThanFind($field, $value, $field2, $date) {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value AND ' . $field2 .' > :date');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
        $criteria = [
            'value' => $value,
            'date' => $date,
        ];
        $stmt->execute($criteria);
        return $stmt->fetchAll();
    }

    public function lessthanAndFind($field, $value, $field2, $value2, $field3, $date) {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value AND '. $field2 . ' =:value2 AND '. $field3 .' > :date');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
        $criteria = [
            'value' => $value,
            'value2' => $value2,
            'date' => $date
        ];
        $stmt->execute($criteria);
        return $stmt->fetchAll();
    }

    public function findLessThanOrdered($field, $field2, $date) {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE '. $field . ' > :date ORDER BY ' . $field2 . ' ASC LIMIT 10');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
        $criteria = [
            'date' => $date
        ];
        $stmt->execute($criteria);
        return $stmt->fetchAll();
    }

    public function findAll() {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function count($id, $field) {
        $count = $this->pdo->prepare('SELECT count(*) as count FROM ' . $this->table . ' WHERE ' . $field . ' = :value');
        $count->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
        $count->execute(['value' => $id]);
        return $count->fetchColumn();
    }

    function insert($record) {
        $keys = array_keys($record);
        $values = implode(', ', $keys);
        $valuesWithColon = implode(', :', $keys);
        $query = 'INSERT INTO ' . $this->table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($record);
    }

    function update($record) {
        $query = 'UPDATE ' . $this->table . ' SET ';
        $parameters = [];
        foreach ($record as $key => $value) {
            $parameters[] = $key . ' = :' .$key;
        }
        $query .= implode(', ', $parameters);
        $query .= ' WHERE ' . $this->primaryKey . ' = :primaryKey';
        $record['primaryKey'] = $record[$this->primaryKey];
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($record);
    }

    function save($record) {
        try {
            $this->insert($record);
        } catch (Exception $e) {
            $this->update($record);
        }
    }

    function delete($field, $value) {
        $stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $field . ' = :value');
        $criteria = [
            'value' => $value
        ];
        $stmt->execute($criteria);
    }

    function fetchColumn($column) {
        $stmt = $this->pdo->prepare('SELECT DISTINCT ' .$column. ' FROM ' . $this->table);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}