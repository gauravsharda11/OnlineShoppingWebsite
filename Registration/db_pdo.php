<?php
/**
 * class for database using PDO to connect to any
 *  type of SQL servers including MYSQL.
 */
class db_pdo
{
    public $db_host = '127.0.0.1';
    public $db_user_name = 'root';
    public $db_user_pw = '';
    public $db_name = 'electric_scooter'; //name of database
    public $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name, $this->db_user_name, $this->db_user_pw);
        } catch (PDOException $e) {
            echo 'Error!: '.$e->getMessage().'<br/>';
            exit();
        }
        echo 'Connected to DB!';
    }

    /**
     * query() for INSERT,UPDATE,DELETE that return no records.
     */
    public function query($sql_str)
    {
        try {
            $result = $this->connection->query($sql_str);
            if (!$result) {
                exit('SQL Query Error');
            }
        } catch (\PDOException $e) {
            throw new \PDOException($e->getmessage(), (int) $e->getcode());
            exit();
        }

        return $result;
    }

    /**
     * quereySelect() for SELECT queries returning records converted in PHP array.
     */
    public function querySelect($sql_str)
    {
        $records = $this->query($sql_str)->fetchAll();

        return $records;
    }

    public function table($table_name)
    {
        return $this->querySelect('SELECT * from '.$table_name);
    }

    public function disconnect()
    {
        $this->connection = null;
    }
}
