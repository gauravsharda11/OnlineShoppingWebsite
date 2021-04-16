<?php
/**
 * class for database using PDO to connect to any
 *  type of SQL servers including MYSQL.
 */
class db_pdo
{
    public $db_host = '127.0.0.1';
    public $db_user_name = 'electric_scooter_web_site';
    public $db_user_pw = 'abc123456789';
    public $db_name = 'electric_scooter'; //name of database

    /** Server Connection details*/
    //public $db_host = 'sql103.epizy.com';
    //// public $db_user_name = 'epiz_26726918';
    // public $db_user_pw = '5EVNTCqEJR';
    //public $db_user_pw = 'abc123456';
    // public $db_name = 'epiz_26726918_electric_scooter'; //name of database
    public $connection;

    public function __construct()
    {
        // connection options
        //https://www.php.net/manual/en/pdo.setattribute.php
        $options = [
            // throw exception on SQL errors
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // return records with associative keys only, no numeric index
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            //Enables or disables emulation of prepared statements. Some drivers do not support native prepared statements or have .
            //(if FALSE) to try to use native prepared statements
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $this->connection = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name.';charset=utf8mb4', $this->db_user_name, $this->db_user_pw, $options);
        } catch (PDOException $e) {
            http_response_code(500);
            throw new  \PDOException($e->getMessage(), (int) $e->getCode());
            // echo 'Error!: '.$e->getMessage().'<br/>';
            die();
        }
        // echo 'Connected to DB!';
    }

    /**
     * query() for INSERT,UPDATE,DELETE that return no records.
     */
    public function query($sql_str1)
    {
        global $DB;
        try {
            $result = $this->connection->query($sql_str1);
            /* if (!$result) {
                 die('SQL Query Error');
             }*/
        } catch (\PDOException $e) {
            http_response_code(500);
            throw new \PDOException($e->getmessage(), (int) $e->getcode());
            die();
        }

        return $result;
    }

    public function querySelectParam($sql_str, $params)
    {
        $stmt = $this->connection->prepare($sql_str);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /**
     * query() for INSERT, UPDATE, DELETE that return no records.
     */
    public function queryParam($sql_str, $params)
    {
        $stmt = $this->connection->prepare($sql_str);
        $stmt->execute($params);

        return true;
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
