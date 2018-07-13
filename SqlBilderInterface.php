<?php
interface SqlBilderInterface
{
    public function select(string $table, array $fields): SqlBilderInterface;
    public function update(string $table, array $fileds): SqlBilderInterface;
    public function insert(string $table, array $values): SqlBilderInterface;
    public function delete(string $table):SqlBilderInterface;
    public function where(
        string $field,
        string $value,
        string $operator = "="
    ): SqlBilderInterface;
    public function limit(int $limnit):SqlBilderInterface;
    public function offset(int $offset):SqlBilderInterface;
    public function getQuery(): string;
}