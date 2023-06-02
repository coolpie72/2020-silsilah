<?php
namespace silsilahApp;

class DBManager {

    private $host = "localhost"; 
    private $port = 3316;
    private $user = "root";
    private $password = "";
    private $database = "db-silsilah-v1";
    private $conn = null; //conn is mysqli object


    function __construct() {
    }


    public function connect() {
        $this->conn = new \mysqli($this->host, $this->user, $this->password, $this->database);
    }

    public function close() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }

    public function execute($sql) {
        $res = $this->conn->query($sql);
        return $res;
    }

    

}
