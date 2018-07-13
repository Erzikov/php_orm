<?php 
include "SqlBilderInterface.php";

class SqlBilder implements SqlBilderInterface
{
    protected $query;

    public function __construct()
    {
        $this->reset();
    }

    protected function reset()
    {
        $this->query = new stdClass();
    }

    public function select(string $table, array $fields):SqlBilderInterface
    {
        $this->reset();
        $this->query->type = "select";
        $this->query->base = "SELECT ". implode(', ', $fields) ." FROM $table";

        return $this;
    }

    public function update(string $table, array $fields):SqlBilderInterface
    {
        $this->reset();
        $this->query->type = "update";

        $expression = array();
        foreach ($fields as $field => $value) {
            $expression[] = "$field = '$value'";
        }

        $this->query->base = "UPDATE $table SET ". implode(", ", $expression);

        return $this;
    }

    public function insert(string $table, array $values):SqlBilderInterface
    {
        $this->reset();
        $this->query->type = "insert";

        foreach ($values as $field => $value) {
            $values[$field] = "'$value'";
        }

        $fields = implode(", ", array_keys($values));
        $values = implode(", ", array_values($values));


        $this->query->base =
            "INSERT INTO $table ($fields) VALUES ($values)";

        return $this;
    }

    public function delete(string $table):SqlBilderInterface
    {
        $this->reset();
        $this->query->type = "delete";
        $this->query->base = "DELETE FROM $table";

        return $this;
    }

    public function where(
        string $field,
        string $value,
        string $operator = "="
    ): SqlBilderInterface
    {
        if (in_array($this->query->type, ['select', 'update', 'delete'])){
            $this->query->where[] = "$field $operator '$value'";
        } else {
            echo "Ошибка!";
        }

        return $this;
    }

    public function limit(int $limit):SqlBilderInterface
    {
        if (in_array($this->query->type, ['select'])) {
            $this->query->limit = "LIMIT $limit";
        } else {
            echo "Ошибка!";
        }

        return $this;
    }

    public function offset(int $offset):SqlBilderInterface
    {
        if (in_array($this->query->type, ['select'])) {
            $this->query->offset = "OFFSET $offset";
        } else {
            echo "Ошибка!";
        }

        return $this;
    }

    public function getQuery():string
    {
        $sql = $this->query->base;

        if (isset($this->query->where)) {
            $where = "WHERE ".implode(' AND ', $this->query->where);
            $sql .= " ".$where;
        }

        if (isset($this->query->limit)) {
            $sql .= " ".$this->query->limit;
        }

        if (isset($this->query->offset)) {
            $sql .= " ".$this->query->offset;
        }

        $sql .= ";";

        return $sql;
    }
}