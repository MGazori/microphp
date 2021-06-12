<?php

namespace App\Models\Contracts;

use Medoo\Medoo;

class MysqlBaseModel extends BaseModel
{
    public function __construct(int|string $id = null)
    {
        try {
            $this->connection = new Medoo([
                // [required]
                'type' => 'mysql',
                'host' => $_ENV['DB_HOST'],
                'database' => $_ENV['DB_NAME'],
                'username' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASS'],

                // [optional]
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'port' => 3306,

                // [optional] Enable logging, it is disabled by default for better performance.
                'logging' => false,

                // [optional]
                // Error mode
                // Error handling strategies when error is occurred.
                // PDO::ERRMODE_SILENT (default) | PDO::ERRMODE_WARNING | PDO::ERRMODE_EXCEPTION
                // Read more from https://www.php.net/manual/en/pdo.error-handling.php.
                'error' => \PDO::ERRMODE_EXCEPTION,

                // [optional] Medoo will execute those commands after connected to the database.
                'command' => [
                    'SET SQL_MODE=ANSI_QUOTES'
                ]
            ]);
        } catch (\PDOException $e) {
            echo 'Connection Failed: ' . $e->getMessage();
        }
        if (!is_null($id))
            return $this->find($id);
    }

    //remove
    public function remove(): int
    {
        $record_id = $this->{$this->primaryKey};
        return $this->delete([$this->primaryKey => $record_id]);
    }

    //save
    public function save(): object
    {
        if (empty($this->attributes))
            return $this;
        $record_id = $this->{$this->primaryKey};
        $this->update($this->attributes, [$this->primaryKey => $record_id]);
        return $this->find($record_id);
    }

    // Create (interface)
    public function create(array $data): int
    {
        $this->connection->insert($this->table, $data);
        return $this->connection->id();
    }

    // Read (Select) Single
    public function find(int $id): object|null
    {
        $result = $this->connection->get($this->table, '*', [$this->primaryKey => $id]);
        if (is_null($result))
            return null;
        foreach ($result as $column => $value)
            $this->attributes[$column] = $value;
        return $this;
    }

    // Read (Select) Multiple
    public function get(array $columns, array $where): array
    {
        return $this->connection->select($this->table, $columns, $where);
    }

    // Read (Select) Multiple All
    public function getAll(): array
    {
        return $this->connection->select($this->table, '*');
    }

    // Update records
    public function update(array $data, array $where): int
    {
        $result = $this->connection->update($this->table, $data, $where);
        return $result->rowCount();
    }

    //Delete
    public function delete(array $where): int
    {
        $result = $this->connection->delete($this->table, $where);
        return $result->rowCount();
    }

    //count
    public function count(array $where): int
    {
        return $this->connection->count($this->table, $where);
    }

    //sum
    public function sum(string $columns, array $where): int
    {
        return $this->connection->sum($this->table, $columns, $where);
    }
}
