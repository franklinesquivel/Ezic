<?php

    /*
        Clase para el loggeo
     */
    class Users
    {
        public $connection;
        private $query;
        public $aux;
        //Propiedades - Arrays, para la encriptación de contraseñas
        private $numbers;
        private $letters;
        private $space;

        function __construct()
        {
            require_once('Page_Constructor.php');
			$const = new Constructor();

			$this->aux = $const->getRoute();

			require_once($this->aux);
			$this->connection = new Connection();
			$this->connection->Connect();

            //Declaración de arrays
            $this->numbers = array("e", "l", "a", "y", "A", "L", "F", "R","o", "p");#9
            $this->letters = array("a", "b", "c", "d","e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "ñ", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z","A", "B", "C", "D","E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "Ñ", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"); #53
            $this->space = array("-", "*", "/", "!", "?" );#5
        }

        function Log($code, $pass, $type)
        {
            if( $type == 'S' ){
                $idLog = 'idStudent';
                $query = "SELECT * FROM student WHERE $idLog = '$code' AND state = 1;";
            }else if( $type == 'T' ){
                $idLog = 'idTeacher';
                $query = "SELECT * FROM teacher WHERE $idLog = '$code' AND state = 1;";
            }else{
                $idLog = 'idCoor';
                $query = "SELECT * FROM coordinator WHERE $idLog = '$code' AND state = 1;";
            }

            $res = $this->connection->connection->query($query);
            if($res->num_rows > 0){
                $rowLog = $res->fetch_assoc();
                if ( $pass == $this->DisarmedEncryption($rowLog['password']) ) {
                    session_start();
                    $_SESSION['id'] = $rowLog[$idLog];
                    $_SESSION['type'] = $type;
                    $_SESSION['log'] = true;
                    return 1;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }

        protected function ArmedEncryption($password){
            $encrypted = "";

            for ($i=0; $i < strlen($password); $i++) {

                $AscciCaracter = ord($password[$i]);
                $lengthCaracter = strlen(ord($password[$i]));
                $verifyNumber = $this->VerifyNumber($password[$i]);
                $verifyLetter = $this->VerifyLetter($password[$i]);
                $randSpace = rand(0,4);

                if ($verifyNumber != -1) {
                    $encrypted .= $AscciCaracter.$verifyNumber.$lengthCaracter.$this->space[$randSpace];
                }else if($verifyLetter != -1){
                    $encrypted .= $AscciCaracter.$verifyLetter.$lengthCaracter.$this->space[$randSpace];
                }else{
                    $encrypted .= $AscciCaracter.$lengthCaracter.$this->space[$randSpace];
                }
            }

            return $encrypted;
        }

        protected function DisarmedEncryption($password){
            $decrypted = "";
            $word = "";

            for ($i=0; $i < strlen($password) ; $i++) {

                if ($this->VerifySpace($password[$i])) {
                    $lengthWord = substr($word, -1);
                    $AscciCaracter = substr($word, 0, $lengthWord);
                    $decrypted .= chr($AscciCaracter);
                    $word = "";
                }else{
                    $word .= $password[$i];
                }
            }

            return $decrypted;
        }

        public function VerifyNumber($character){
            for ($i=0; $i < count($this->numbers); $i++) {
                if ($character == "$i") {
                    return $this->numbers[$i];
                }
            }
            return -1;
        }

        function VerifyLetter($character){
            for ($i=0; $i < count($this->letters); $i++) {
                if ($character == $this->letters[$i]) {
                    return $i;
                }
            }
            return -1;
        }

        function VerifySpace($character){
            for ($i=0; $i < count($this->space) ; $i++) {
                if ($character == $this->space[$i]) {
                    return true;
                }
            }
            return false;
        }

        function getUsers(){
            if (!isset($_SESSION)) {
                session_start();
            }
            $users_array = [];
            $user = [];
            $i = 1;
            $query = "
            SELECT * FROM student st 
            INNER JOIN section s ON st.idSection = s.idSection 
            INNER JOIN level l ON l.idLevel = s.idLevel 
            INNER JOIN specialty sy ON s.idSpecialty = sy.idSpecialty";

            $res = $this->connection->connection->query($query);
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $user = [];
                    $user['type'] = 'S';
                    $user['idLog'] = 'idStudent';
                    foreach ($row as $key => $value) {
                        $user[($key == $user['idLog'] ? 'id' : $key)] = $value;
                    }
                    $user['element'] = "
                        <div class='user-item' id='" . $user['id'] . "' user_index='$i'>
                            <div class='info'>
                                <div class='photo'>
                                    <img src='../../files/profile_photos/" . $user['photo'] . "'>
                                </div>
                                <div class='data'>
                                    <span class='id'>" . $user['id'] . "</span>
                                    <span class='full-name'><span class='lastName'>" . $row['lastName'] . "</span>, <span class='name'>" . $row['name'] . "</span></span>
                                    <span class='xtra'>
                                        <span>" . $row['level'] . "° '" . $row['sectionIdentifier'] . "', " . $row['sName'] . "</span>
                                    </span> 
                                </div>
                            </div>
                            <div class='options'>
                                <a class='dropdown-button btn-flat waves-effect' data-activates='dropdown$i'><i class='material-icons large'>settings</i></a>
                                <ul id='dropdown$i' class='dropdown-content'>
                                    <li function='show' class='blue btnShow'><a class='waves-effect white-text'>Ver perfil<i class='material-icons left'>remove_red_eye</i></a></li>";
                    if ($user['state'] == 1) {
                        $user['element'] .= "
                                        <li class='purple btnSchedule'><a class='waves-effect white-text'>Ver horario<i class='material-icons left'>schedule</i></a></li>
                                        <li function='grades' class='orange btnGrades'><a class='waves-effect white-text'z>Notas<i class='material-icons left'>grade</i></a></li>
                                        <li function='record' class='red btnRecord'><a class='waves-effect white-text'>Conducta<i class='material-icons left'>favorite</i></a></li>
                                        <li function='appliedCode' class='blue-grey btnAppliedCode'><a class='waves-effect white-text'>Aplicar Código<i class='material-icons left'>warning</i></a></li>
                                        <li function='removeCode' class='pink btnRmvCode'><a class='waves-effect white-text'>Remover Código<i class='material-icons left'>remove_circle</i></a></li>
                                        <li class='indigo btnMandated'><a disabled class='waves-effect white-text'z>Ver responsable<i class='material-icons left'>folder_shared</i></a></li>
                                        <li function='edit' class='teal btnEdit'><a class='waves-effect white-text'>Editar<i class='material-icons left'>edit</i></a></li>
                                        <li function='edit' class='red btnDown'><a class='waves-effect white-text'>Dar de baja<i class='material-icons left'>thumb_down</i></a></li>";
                    }
                    $user['element'] .= "</ul>
                            </div>
                        </div>";

                    array_push($users_array, $user);
                    $i++;
                }
            }else{
                // return -1;
            }

            $query = "SELECT * FROM teacher";

            $res = $this->connection->connection->query($query);
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $user = [];
                    $user['type'] = 'T';
                    $user['idLog'] = 'idTeacher';
                    foreach ($row as $key => $value) {
                        $user[($key == $user['idLog'] ? 'id' : $key)] = $value;
                    }

                    $user['element'] = "
                        <div class='user-item' id='" . $user['id'] . "' user_index='$i'>
                            <div class='info'>
                                <div class='photo'>
                                    <img src='../../files/profile_photos/" . $user['photo'] . "'>
                                </div>
                                <div class='data'>
                                    <span class='id'>" . $user['id'] . "</span>
                                    <span class='full-name'><span class='lastName'>" . $row['lastName'] . "</span>, <span class='name'>" . $row['name'] . "</span></span>
                                    <span class='xtra'>
                                        <span>" . $row['profession'] . "</span>
                                    </span> 
                                </div>
                            </div>
                            <div class='options'>
                                <a class='dropdown-button btn-flat waves-effect' data-activates='dropdown$i'><i class='material-icons large'>settings</i></a>
                                <ul id='dropdown$i' class='dropdown-content'>
                                    <li class='blue btnShow'><a class='waves-effect white-text'>Ver perfil<i class='material-icons left'>remove_red_eye</i></a></li>";
                    if ($user['state'] == 1) {
                        $user['element'] .= "<li class='purple btnSchedule'><a class='waves-effect white-text'>Ver horario<i class='material-icons left'>schedule</i></a></li>
                                        <li class='indigo btnSubject'><a class='waves-effect white-text'z>Materias<i class='material-icons left'>library_books</i></a></li>
                                        <li class='teal btnEdit'><a class='waves-effect white-text'>Editar<i class='material-icons left'>edit</i></a></li>
                                        <li function='edit' class='red btnDown'><a class='waves-effect white-text'>Dar de baja<i class='material-icons left'>thumb_down</i></a></li>";
                    }
                    $user['element'] .= "</ul>
                            </div>
                        </div>";

                    array_push($users_array, $user);
                    $i++;
                }
            }else{
                // return -1;
            }

            $query = "SELECT * FROM coordinator WHERE idCoor <> '" . $_SESSION['id'] . "';";

            $res = $this->connection->connection->query($query);
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $user = [];
                    $user['type'] = 'C';
                    $user['idLog'] = 'idCoor';
                    foreach ($row as $key => $value) {
                        $user[($key == $user['idLog'] ? 'id' : $key)] = $value;
                    }

                    $user['element'] = "
                        <div class='user-item' id='" . $user['id'] . "' user_index='$i'>
                            <div class='info'>
                                <div class='photo'>
                                    <img src='../../files/profile_photos/" . $user['photo'] . "'>
                                </div>
                                <div class='data'>
                                    <span class='id'>" . $user['id'] . "</span>
                                    <span class='full-name'><span class='lastName'>" . $row['lastName'] . "</span>, <span class='name'>" . $row['name'] . "</span></span>
                                    <span class='xtra'>
                                    <span>" . $row['profession'] . "</span>
                                    </span> 
                                </div>
                            </div>
                            <div class='options'>
                                <a class='dropdown-button btn-flat waves-effect' data-activates='dropdown$i'><i class='material-icons large'>settings</i></a>
                                <ul id='dropdown$i' class='dropdown-content'>
                                <li class='blue btnShow'><a class='waves-effect white-text'>Ver perfil<i class='material-icons left'>remove_red_eye</i></a></li>";
                        if ($user['state'] == 1) {
                            $user['element'] .= "<li class='teal btnEdit'><a class='waves-effect white-text'>Editar<i class='material-icons left'>edit</i></a></li>
                                    <li function='edit' class='red btnDown'><a class='waves-effect white-text'>Dar de baja<i class='material-icons left'>thumb_down</i></a></li>";
                        }
                                $user['element'] .= "</ul>
                            </div>
                        </div>";
                    array_push($users_array, $user);
                    $i++;
                }
            }else{
                // return -1;
            }

            return $users_array;
            // var_dump($users_array);
        }
    }
?>
