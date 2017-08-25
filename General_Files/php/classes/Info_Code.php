<?php
    class Info_Code{
        private $connection;
        private $aux;

        public $c_reference;
        public $c_code;
        public $c_result;
        public $c_type;

		function __construct(){
			require_once('Page_Constructor.php');
			$const = new Constructor();
			$this->aux = $const->getRoute();
			require_once($this->aux);
			$this->connection = new Connection();
            $this->connection->Connect();

            $this->c_reference = array();
            $this->c_code = array();
            $this->c_result = array();
            $this->c_type = array();
        }

        function setQuery(){
            $query = "SELECT * FROM gnrl_code";
            $result = $this->connection->connection->query($query);
            $i = 0;
            while($fila = $result->fetch_assoc()){
                $this->c_reference[$i] = $fila['code_reference'];
                $this->c_code[$i] = $fila['cant_code'];
                $this->c_result[$i] = $fila['code_result'];
                $this->c_type[$i] = $fila['type_result'];
                $i++;
            }      
        }
    }
?>