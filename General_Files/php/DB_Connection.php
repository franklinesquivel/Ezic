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
            if (!isset($_SESSION)) {
                session_start();
            }

            $this->host = "localhost";
            $this->user  = "root";
            $this->pass = "";
            $this->DB = (( isset($_SESSION['bdd']) ) ? "".$_SESSION['bdd']."" : 'ezic_basica');
        }

        function Connect()
        {
            $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->DB);
            $this->connection->set_charset("utf8");
        }
    }
?>
