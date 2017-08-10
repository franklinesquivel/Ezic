<?php
    /**
     *
     */
    require_once 'Router.php';
    class Constructor extends Router
    {
        private $user;
        private $idLog;
        private $root;
        private $direction;
        private $name;
        private $location;

        function __construct()
        {
            $this->name = explode('/', $_SERVER['PHP_SELF'])[1];
            $this->root = $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/' .  $this->name . '/';

            $this->location = "/$this->name";
            for ($i=2; $i < count(explode('/', $_SERVER['PHP_SELF'])); $i++) { 
                $this->location .= "/" . explode('/', $_SERVER['PHP_SELF'])[$i];
            } 

            // echo $this->getRoute();
            require_once($this->getRoute());
            $this->connection = new Connection();
            $this->connection->Connect();

        }

        function verify_Log($type)
        {
            parent::__construct($type);
            if (!isset($_SESSION)) {
                session_start();
            }

            if (isset($_SESSION['log'])) {
                if ($_SESSION['type'] == 'S') {
                    $this->user = 'student'; $this->idLog = 'idStudent';
                }else if ($_SESSION['type'] == 'T') {
                    $this->user = 'teacher'; $this->idLog = 'idTeacher';
                }else if($_SESSION['type'] == 'C'){
                    $this->user = 'coordinator'; $this->idLog = 'idCoor';
                }

                $this->direction = $this->root . 'app/users/' . $this->user . '/';

                $x = 0;
                $returnPath = "";
                $actualPath = explode("/", $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $this->location);
                $userPath = explode("/", $this->direction);

                array_pop($actualPath);

                $lenght = (count($actualPath) < count($userPath) ? count($actualPath) : count($userPath));

                for ($i=0; $i < $lenght; $i++) {
                    if ($userPath[$i] != $actualPath[$i]) {
                        $x++;
                    }
                }

                $x = count($actualPath) - $x - 1;

                for ($i=0; $i < $x; $i++) { 
                    $returnPath .= "../";
                }

                if ($_SESSION['type'] != $type) {
                    header("Location: " . ( $i > 1 ? $returnPath : '') . "app/users/" . $this->user ."/");
                }
            }else{
                $x = 0;
                $returnPath = "";
                $actualPath = explode("/", $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $this->location);
                $homePath = explode("/", $this->root . 'app/home/index.php');

                $lenght = count($homePath);

                for ($i=0; $i < $lenght; $i++) {
                    if ($homePath[$i] != $actualPath[$i]) {
                        $x++;
                    }
                }

                $x = count($actualPath) - $x - 1;

                for ($i=0; $i < $x; $i++) { 
                    $returnPath .= "../";
                }

                if (strtolower($_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $this->location) != strtolower($this->root . 'app/home/index.php')) {
                    header("Location: " . $returnPath . 'app/home/index.php');
                }
            }
        }

        function getData(){
            if (isset($_SESSION['log'])) {
                $query = "SELECT * FROM $this->user WHERE $this->idLog = '" . $_SESSION['id'] . "';";
                $res = $this->connection->connection->query($query);
                return $res->fetch_assoc();
            }
        }

        function getRoute()
        {
            $aux = '';
            $x = 0;
            $lenght = 0;
            $DB_Route = '/' . $this->name . '/General_Files/php/DB_Connection.php';
            $DB_Route = explode("/", $DB_Route);

            $File_Route = explode("/", $_SERVER['PHP_SELF']);

            $lenght = count($DB_Route);

            if (count($File_Route) > 3) {
                for ($i = 2; $i < $lenght; $i++) {
                    if ( $DB_Route[$i] != $File_Route[$i] ) {
                        $x++;
                    }
                }

                $x = count($File_Route) - $x;

                for ($i=0; $i < $x; $i++) {
                    $aux = $aux . "../";
                }

                // return $File_Route[count($File_Route) - 2];
                if ($File_Route[count($File_Route) - 2] == 'classes') {
                    return "../DB_Connection.php";
                }

                return $aux . 'General_Files/php/DB_Connection.php';
            }else{
                return 'General_Files/php/DB_Connection.php';
            }
        }

        function getSchedule(){
            // session_start();
            if (isset($_SESSION['log'])) {
                $r = false;
                ini_set("date.timezone", 'America/El_Salvador');
                $hour = date("G:i:s");
                $query = "SHOW TABLES FROM ezic WHERE TABLES_IN_ezic LIKE 'teacher_schedule_".$_SESSION['id']."'";
                $result = $this->connection->connection->query($query);
                if ($result->num_rows > 0) {
                   if ($_SESSION['type'] == 'T') {//Teacher
                        $query = "SELECT subject.acronym, section.sectionIdentifier, level.level FROM `teacher_schedule_".$_SESSION['id']."` INNER JOIN schedule_register ON schedule_register.idS_Register = teacher_schedule_".$_SESSION['id'].".idScheduleInfo INNER JOIN section ON section.idSection = schedule_register.idSection INNER JOIN level ON level.idLevel = section.idLevel INNER JOIN subject ON subject.idSubject = schedule_register.idSubject WHERE schedule_register.startTime BETWEEN schedule_register.startTime AND '$hour' AND schedule_register.endTime BETWEEN '$hour' AND schedule_register.endTime GROUP BY subject.acronym";
                        $result = $this->connection->connection->query($query);
                        
                        while ($fila = $result->fetch_assoc()) {
                            $sentence = "Impartiendo clase: ".strtoupper($fila['acronym'])." en ".$fila['level']."° '".$fila['sectionIdentifier']."'";
                            $r = true;
                        }
                    }else if($_SESSION['type'] == 'S'){//Student
                        $query = "SELECT subject.acronym, teacher.name, teacher.lastName FROM `schedule_register` INNER JOIN subject ON subject.idSubject = schedule_register.idSubject INNER JOIN teacher ON teacher.idTeacher = subject.idTeacher INNER JOIN student ON student.idSection = schedule_register.idSection WHERE schedule_register.startTime BETWEEN schedule_register.startTime AND '$hora' AND schedule_register.endTime BETWEEN '$hora' AND schedule_register.endTime AND student.idStudent = '".$_SESSION['id']."' GROUP BY subject.acronym"
                        ;
                        $result = $this->connection->connection->query($query);
                        while ($fila = $result->fetch_assoc()) {
                            $sentence = "Recibiendo clase de: ".strtoupper($fila['acronym'])." - ".$fila['lastName'].", '".$fila['name']."'";
                            $r = true;
                        }
                    }
                }
                
                if ($r) {
                    $div = "<div class='banda'>
                        <div>$sentence</div>
                    </div>";
                }else{
                    $div = "";
                }

                return $div;
            }
        }
    }
?>

