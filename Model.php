<?php

/**
 * Created by PhpStorm.
 * Filename: Model.php
 * User: Nguyễn Văn Ước
 * Date: 28/09/2022
 * Time: 09:35
 */
abstract class Model
{
    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes of table
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * List where parameter
     *
     * @var array
     */
    protected $whereClause = [];

    /**
     * List order parameter
     *
     * @var array
     */
    protected $orderClause = [];

    /**
     * List group parameter
     *
     * @var array
     */
    protected $groupClause = [];

    /**
     * List field will select
     *
     * @var array
     */
    protected $select = [];

    /**
     * Limit
     *
     * @var
     */
    private $limit = 0;

    /**
     * Get attribute
     *
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        if (isset($this->origin[$name])) {
            return $this->origin[$name];
        }
        return null;
    }

    /**
     * Set table
     *
     * @param $table
     * @return void
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * Get table
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Connect with database
     *
     * @return void
     */
    private function connect()
    {
        $servername = "localhost";
        $username   = "root";
        $password   = "uocnv1998";
        $database   = "test_oop";

        $this->connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        // set the PDO error mode to exception
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Close connection
     *
     * @return void
     */
    private function disconnect()
    {
        $this->connection = null;
    }

    /**
     * Init new instance
     *
     * @return static
     */
    public static function query(): Model
    {
        return (new static)->newQuery();
    }

    private function newQuery(): Model
    {
        $this->setTable($this->getTable());
        return $this;
    }

    /**
     * Check field in list attribute declared
     *
     * @param string $field
     * @return bool
     */
    private function checkField(string $field): bool
    {
        return in_array($field, $this->attributes);
    }

    /**
     * Basic select clause
     *
     * @param ...$fields
     * @return $this
     */
    public function select(...$fields): Model
    {
        foreach ($fields as $field) {
            if ($this->checkField($field)) {
                $this->select[] = $field;
            }
        }
        return $this;
    }

    /**
     * Basic where clause
     *
     * @param string $field
     * @param string $operation
     * @param $value
     * @return $this
     */
    public function where(string $field, string $operation = '=', $value = null): Model
    {
        if ($this->checkField($field)) {
            $this->whereClause[$field] = [$operation, $value];
        }
        return $this;
    }

    /**
     * Basic group clause
     *
     * @param string $field
     * @return $this
     */
    public function groupBy(string $field): Model
    {
        if ($this->checkField($field) && in_array($field, $this->groupClause) === false) {
            $this->groupClause[] = $field;
        }
        return $this;
    }

    /**
     * Basic order clause
     *
     * @param string $field
     * @param string $method
     * @return $this
     */
    public function orderBy(string $field, string $method = 'ASC'): Model
    {
        if ($this->checkField($field)) {
            if (strtoupper($method) == 'DESC') {
                return $this->orderByDesc($field);
            } else {
                $this->orderClause[$field] = "$field ASC";
            }
        }
        return $this;
    }

    /**
     * Basic order desc clause
     *
     * @param string $field
     * @return $this
     */
    public function orderByDesc(string $field): Model
    {
        if ($this->checkField($field)) {
            $this->orderClause[$field] = "$field DESC";
        }
        return $this;
    }

    /**
     * Basic limit clause
     *
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit): Model
    {
        if ($limit > 0) {
            $this->limit = $limit;
        }
        return $this;
    }

    /**
     * Get result query
     *
     * @return array
     * @throws Exception
     */
    public function get(): array
    {
        // Start query
        $query = 'SELECT';

        // Add select
        if (count($this->select)) {
            $query .= ' ' . implode(', ', $this->select);
        } else {
            $query .= ' *';
        }

        // Add table
        if (!$this->getTable()) {
            throw new Exception('Undefined table.');
        }
        $query .= " FROM {$this->getTable()}";

        // Add where clause
        if (count($this->whereClause)) {
            $query .= ' WHERE 1';
            foreach ($this->whereClause as $field => $clause) {
                if (is_numeric($clause[1])) {
                    $query .= " AND {$field} {$clause[0]} {$clause[1]}";
                } else {
                    $query .= " AND {$field} {$clause[0]} '{$clause[1]}'";
                }
            }
        }

        // Add group by clause
        if (count($this->groupClause)) {
            $query .= ' GROUP BY ' . implode(', ', $this->groupClause);
        }

        // Add order by clause
        if (count($this->orderClause)) {
            $query .= ' ORDER BY ' . implode('. ', $this->orderClause);
        }

        // Add limit
        if ($this->limit) {
            $query .= " LIMIT {$this->limit}";
        }

        // End query
        $query .= ';';

        // Connect DB
        $this->connect();

        // Get result query
        $resultQuery = $this->connection->query($query)->fetchAll(PDO::FETCH_ASSOC);

        // Close connection
        $this->disconnect();

        // Create object data
        $result = [];
        foreach ($resultQuery as $res) {
            $object         = new static;
            $object->origin = $res;
            $result[]       = $object;
        }

        return $result;
    }

    /**
     * Get first of result
     *
     * @return Model
     * @throws Exception
     */
    public function getFirst(): Model
    {
        $this->limit(1);
        return $this->get()[0];
    }

    /**
     * Get all
     *
     * @return array
     * @throws Exception
     */
    public function getAll(): array
    {
        $clone = new static;
        return $clone->get();
    }
}
