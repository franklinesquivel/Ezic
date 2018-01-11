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
                    
                    if (!isset($_SESSION)) {
                        session_start();
                    }

                    $_SESSION['id'] = $rowLog[$idLog];
                    $_SESSION['type'] = $type;
                    $_SESSION['log'] = true;
                    $_SESSION['bdd'] = "ezic_basica"; //Variable que estará iterada según el tipo de usuario
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
                                    <li class='blue btnShow'><a class='waves-effect white-text'>Ver perfil<i class='material-icons left'>remove_red_eye</i></a></li>";
                    if ($user['state'] == 1) {
                        $user['element'] .= "
                                        <li class='purple btnSchedule'><a class='waves-effect white-text'>Ver horario<i class='material-icons left'>schedule</i></a></li>
                                        <li class='orange btnGrades'><a class='waves-effect white-text'z>Notas<i class='material-icons left'>grade</i></a></li>
                                        <li class='red btnRecord'><a class='waves-effect white-text'>Conducta<i class='material-icons left'>favorite</i></a></li>
                                        <li class='blue-grey btnAppliedCode'><a class='waves-effect white-text'>Aplicar Código<i class='material-icons left'>warning</i></a></li>
                                        <li class='pink btnRmvCode'><a class='waves-effect white-text'>Remover Código<i class='material-icons left'>remove_circle</i></a></li>
                                        <li class='indigo btnMandated'><a disabled class='waves-effect white-text'z>Ver responsable<i class='material-icons left'>folder_shared</i></a></li>
                                        <li class='teal btnEdit'><a class='waves-effect white-text'>Editar<i class='material-icons left'>edit</i></a></li>
                                        <li class='red btnDown'><a class='waves-effect white-text'>Dar de baja<i class='material-icons left'>thumb_down</i></a></li>";
                    }else{
                        $user['element'] .= "
                                <li class='green btnUp'><a class='waves-effect white-text'>Dar de alta<i class='material-icons left'>thumb_up</i></a></li>";
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
                    }else{
                        $user['element'] .= "
                                <li class='green btnUp'><a class='waves-effect white-text'>Dar de alta<i class='material-icons left'>thumb_up</i></a></li>";
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
                        }else{
                        $user['element'] .= "
                                <li class='green btnUp'><a class='waves-effect white-text'>Dar de alta<i class='material-icons left'>thumb_up</i></a></li>";
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

        function registerForm($type)
        {
            $frm = "
                <div class='row'>
                    <div class='header_info_cont'>
                        <div class='frmPhoto_cont'>
                            <div class='file-field input-field photo-input hide'>
                                <div class='btn'>
                                    <span>File</span>
                                    <input class='photoFile' id='photo-file-input' type='file'>
                                </div>
                                <div class='file-path-wrapper'>
                                    <input class='file-path' type='text'>
                                </div>
                            </div>
                            <span class='btnModifyPhoto'><i class='material-icons medium'>edit</i></span>
                            <img src='../../files/profile_photos/photo.png' class='circle frmPhoto'>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <form class='frmData'>
                        <div class='row'>
                            <div class='input-field col l5 m5 s10 offset-l1 offset-m1 offset-s1'>
                                <input class='txtName' id='txtName' type='text' name='txtName'>
                                <label for='txtName'>Nombres</label>
                            </div>
                            <div class='input-field col l5 m5 s10 offset-s1'>
                                <input class=txtLastName id='txtLastName' type='text' name='txtLastName'>
                                <label for='txtLastName'>Apellidos</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='input-field col l10 m10 s10 offset-l1 offset-m1 offset-s1'>
                                <input class='txtDui' id='txtDui' type='text' name='txtDui'>
                                <label for='txtDui'>DUI</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='input-field col l10 m10 s10 offset-l1 offset-m1 offset-s1'>
                                <input class='txtPhone' id='txtPhone' type='text' name='txtPhone'>
                                <label for='txtPhone'>Teléfono</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='input-field col l10 m10 s10 offset-l1 offset-m1 offset-s1'>
                                <input class='txtEmail' id='txtEmail' type='email' name='txtEmail'>
                                <label for='txtEmail'>Correo Electrónico</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='input-field col l10 m10 s10 offset-l1 offset-m1 offset-s1'>
                                <textarea id='txtRes' name='txtRes' class='materialize-textarea'></textarea>
                                <label for='txtRes'>Residencia</label>
                            </div>
                            <div class='input-field col l10 m10 s10 offset-l1 offset-m1 offset-s1'>
                                <input class='txtDate datepicker' id='txtDate' type='date' name='txtDate'>
                                <label class='active' for='txtDate'>Fecha de Nacimiento</label>
                            </div>
                            <div class='input-field col l10 m10 s10 offset-l1 offset-m1 offset-s1'>
                                    <input class=txtProfession id='txtProfession' type='text' name='txtProfession'>
                                    <label for='txtProfession'>Profesión</label>
                            </div>
                        </div>
                        <div class='input-field col l2 m2 s4 offset-l5 offset-m5 offset-s4'>
                                <input class='txtSex_F with-gap' id='txtSex_F' type='radio' name='txtSex' value='F'>
                                <label for='txtSex_F'>Femenino</label>
                        </div>
                        <div class='input-field col l2 m2 s4 offset-l5 offset-m5 offset-s4'>
                                <input class='txtSex_M with-gap' id='txtSex_M' type='radio' name='txtSex' value='M'>
                                <label for='txtSex_M'>Masculino</label>
                        </div>
                    </form>
                    <div class='col s12 row btn_cont'>
                        <center>
                            <div class='btn waves-effect waves-light black btnSave_User'>Registrar " . ($type == 'C' ? 'coordinador' : 'docente') . "
                                <i class='material-icons right'>save</i>
                            </div>
                        </center>
                    </div>
                </div>";

            return $frm;
        }

        function getId($type)
        {
            $aux = [];
            $table = ($type == 'C' ? 'coordinator' : ($type == 'T' ? 'teacher' : 'student'));
            $idLog = ($type == 'C' ? 'idCoor' : ($type == 'T' ? 'idTeacher' : 'idStudent'));

            $query = "SELECT $idLog FROM $table;";
            $res = $this->connection->connection->query($query);
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    array_push($aux, $row[$idLog]);
                }
            }else{
                return 0;
            }

            return json_encode($aux);
        }

        function registerUser($data, $type, $idSection = 0)
        {
            $table = ($type == 'C' ? 'coordinator' : ($type == 'T' ? 'teacher' : 'student'));
            $idLog = ($type == 'C' ? 'idCoor' : ($type == 'T' ? 'idTeacher' : 'idStudent'));
            $query = "INSERT INTO $table VALUES(";

            if ($type != 'S') {
                foreach ($data as $key => $value) {
                    if ($key != 'photo' && $key != 'type')
                        $query .= "'" . ($key == 'password' ? $this->ArmedEncryption($value) : $value) . "', ";
                }


                if ($data['photo'] !== 0) {
                    $oldName = "tmp_img." . $data['photo'];
                    $newName = $data['id'] . "." . $data['photo'];
                    if(copy("../../files/profile_photos/tmp/$oldName", "../../files/profile_photos/$newName")){
                        unlink("../../files/profile_photos/tmp/$oldName");
                        $query .= "'" . $newName . "'";
                    }else{
                        $query .= "'photo.png'";
                    }
                }else{
                    $query .= "'photo.png'";
                }

                $query .= ');';

                $res = $this->connection->connection->query($query);

                return ($res ? $data['id'] : 0);
            }else{
                $query = "";
                for ($i=0; $i < count($data); $i++) { 
                    $query .= "INSERT INTO $table VALUES(";
                    foreach ($data[$i] as $key => $value) {
                        if ($key != 'type')
                            $query .= "'" . ($key == 'password' ? $this->ArmedEncryption($value) : $value) . "', ";
                    }
                    $query .= " $idSection, 1, 'A', 'photo.png', 0); ";
                }

                if (count($data) > 1) {
                   return ($this->connection->connection->multi_query($query) ? 1 : 0);
                }else{
                    return ($this->connection->connection->query($query) ? 1 : 0);
                }
            }
        }

        function getPassword($type, $code){
            if($type == 'S'){//Estudiante
                $query = "SELECT * FROM student WHERE idStudent = '$code' AND verified = 1 AND state = 1";
                $result = $this->connection->connection->query($query);
                if($result->num_rows > 0){//Se arma la contraseña
                    $fila = $result->fetch_assoc();
                    return array($this->DisarmedEncryption($fila['password']), $fila['email']);
                }else{
                    return 0;
                }
            }elseif($type == 'T'){//Docente
                $query = "SELECT * FROM teacher WHERE idTeacher = '$code' AND state = 1";
                $result = $this->connection->connection->query($query);
                if($result->num_rows > 0){//Se arma la contraseña
                    $fila = $result->fetch_assoc();
                    return array($this->DisarmedEncryption($fila['password']), $fila['email']);
                }else{
                    return 0;
                }
            }elseif($type == 'C'){//Coordinador
                $query = "SELECT * FROM coordinator WHERE idCoor = '$code' AND state = 1";
                $result = $this->connection->connection->query($query);
                if($result->num_rows > 0){//Se arma la contraseña
                    $fila = $result->fetch_assoc();
                    return array($this->DisarmedEncryption($fila['password']), $fila['email']);
                }else{
                    return 0;
                }
            }
            return 0;
        }
    }
?>
