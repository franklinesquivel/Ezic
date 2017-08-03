<?php

    /*
        Clase de conexión a la BDD
    */
    class Connection
    {
        private $host;
        private $user;
        private $pass;
        private $DB;
        public $connection;

        public function __construct()
        {
            $this->host = "localhost";
            $this->user  = "root";
            $this->pass = "";
            $this->DB = "ezic_t";
        }

        function Connect()
        {
            $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->DB);
            $this->connection->set_charset("utf8");
        }

        // function Error()
        // {
        //     echo $this->connection->connect_errno;
        // }

        // function Disconnect()
        // {
        //     $this->connection->close();
        // }
    }


?>
