<?php
class Info_Gnrl{
    private $connection;
    private $aux;

    public $num_hour;
    public $duration_hour;
    public $num_breaks;
    public $duration_breaks;
    public $max_student;
    public $expulsion_state;
    public $days_expulsion;
    public $cant_days;
    public $start_day;
    public $end_day;
    public $approved_grade;

    function __construct(){
        require_once('Page_Constructor.php');
        $const = new Constructor();
        $this->aux = $const->getRoute();
        require_once($this->aux);
        $this->connection = new Connection();
        $this->connection->Connect();
    }

    function setQuery(){
        $query = "SELECT * FROM gnrl_info";
        $result = $this->connection->connection->query($query);
        $fila = $result->fetch_assoc();
        
        $this->num_hour = $fila['num_hour'];
        $this->duration_hour = $fila['duration_hour'];
        $this->num_breaks = $fila['num_breaks'];
        $this->duration_breaks = $fila['duration_breaks'];
        $this->max_student = $fila['max_student'];
        $this->expulsion_state = $fila['expulsion_state'];
        $this->days_expulsion = $fila['days_expulsion'];
        $this->cant_days = $fila['cant_days'];
        $this->start_day = $fila['start_day'];
        $this->end_day = $fila['end_day'];
        $this->approved_grade = $fila['approved_grade'];
    }
}

?>