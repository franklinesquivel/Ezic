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

        function getInfo($type_result, $code){ #Para la eliminación de código
            $query = "SELECT * FROM gnrl_code WHERE type_result = '$type_result' AND code_result = '$code'";
            $result = $this->connection->connection->query($query);

            if($result->num_rows > 0){
                $fila = $result->fetch_assoc();
                return (array("c_code" => $fila['cant_code'], "c_ref" => $fila['code_reference'], "t_result"=>$fila['type_result'], "c_result"=>$fila['code_result']));
            }
            return false;
        }

        function getRow(){
            $query = "SELECT * FROM gnrl_code";
            $result = $this->connection->connection->query($query);
            return ($result->num_rows);
        }

        function getForReference($reference){
            $query = "SELECT * FROM gnrl_code WHERE code_reference = '$reference'";
            $result = $this->connection->connection->query($query);

            if($result->num_rows > 0){
                $fila = $result->fetch_assoc();
                return (array("c_code" => $fila['cant_code'], "c_ref" => $fila['code_reference'], "t_result"=>$fila['type_result'], "c_result"=>$fila['code_result']));
            }
            return false;
        }

        function getForResult($result){
            $query = "SELECT * FROM gnrl_code WHERE type_result = '$result'";
            $result = $this->connection->connection->query($query);

            if($result->num_rows > 0){
                $fila = $result->fetch_assoc();
                return (array("c_code" => $fila['cant_code'], "c_ref" => $fila['code_reference'], "t_result"=>$fila['type_result'], "c_result"=>$fila['code_result']));
            }
            return false;
        }
    }
?>