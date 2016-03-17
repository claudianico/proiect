<?php

/**
 * Class database
 */
class database
{
    /**
     * @var
     */
    private $connection;

    /**
     * database constructor.
     */
    function __construct()
    {
        global $db_details;

        $this->initialize($db_details->server, $db_details->username, $db_details->password, $db_details->database);
        $this->charset('utf8');
    }

    /**
     * @param $server
     * @param $username
     * @param $password
     * @param $database
     */
    private function initialize($server, $username, $password, $database)
    {
        $this->connection = new mysqli($server, $username, $password, $database);
        if ($this->connection->connect_errno) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
    }

    /**
     * @param $charset
     */
    function charset($charset)
    {
        $this->connection->set_charset($charset);
    }

    /**
     * @param $sql
     * @return mixed
     */
    public function execute($sql)
    {
        $result = $this->connection->query($sql);
        if ($this->connection->errno) {
            die("Query failed: " . $this->connection->error);
        }
        return $result;
    }

    /**
     * @param $var
     * @return mixed
     */
    public function escape($var)
    {
        return $this->connection->real_escape_string($var);
    }

    /**
     * @return mixed
     */
    public function get_affected_rows()
    {
        return $this->connection->affected_rows;
    }

    /**
     * @return mixed
     */
    public function get_insert_id()
    {
        return $this->connection->insert_id;
    }

    /**
     *
     */
    function __destruct()
    {
        if (!$this->connection->connect_errno) {
            $this->connection->close();
        }
    }
}

$database = new database();