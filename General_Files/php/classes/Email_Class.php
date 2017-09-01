<?php 
    require 'PHPMailer/class.smtp.php';
    require 'PHPMailer/class.phpmailer.php';

    class Email extends PHPMailer{
        private $connection;
        private $aux;
        private $email_from;
        function __construct(){

            /* Ezic dependencias */
            require_once('Page_Constructor.php');
            $const = new Constructor();
            $this->aux = $const->getRoute();
            require_once($this->aux);
            $this->connection = new Connection();
            $this->connection->Connect();

            /* PHPMailer dependecias*/
            parent::IsSMTP();
            $this->Host = "smtp.gmail.com";
            $this->SMTPAuth = true;
            $this->Username = "ezic2017@gmail.com";
            $this->Password = "HolaYosoy.empresa.creaj2k17";
            $this->SMTPSecure = "tls";
            $this->Port = 587;
            $this->SMTPDebug = 1;
            $this->CharSet = "UTF-8";
            $this->email_from = "ezic2017@gmail.com";
            parent::setFrom($this->email_from,  "Ezic");
        }

        public function  FormEmailTeacher($periods){ /* Formulario del profesor para solicitar permisos para modificar notas */
           $option_periods = "";
           for($i = 0; $i < count($periods); $i++){
                $option_periods .= "<option value='".$periods[$i][0]."'>".$periods[$i][1].": ".$periods[$i][2]." hasta ".$periods[$i][3]."</option>";
           }
            $form = "
            <form class='SendEmail'>
                <div class='row'>
                    <div class='input-field col l6 m8 s10 offset-l3 offset-m2 offset-s1'>
                        <textarea id='justification' name='justification' class='materialize-textarea'></textarea>
                        <label for='justification'>Motivo de la solicitud</label>
                    </div>
                    <div class='input-field col l6 m8 s10 offset-l3 offset-m2 offset-s1'>
                        <select id='selectPeriod' name='selectPeriod'>
                            <option value='' disabled selected>Seleccionar Período</option> 
                            $option_periods
                        </select>
                        <label>Período</label>
                    </div>
                    <div class='input-field col l6 m8 s10 offset-l3 offset-m2 offset-s1'>
                        <select multiple id='selectProfiles' name='selectPeriod'>
                            <option value='' disabled selected>Seleccionar Perfiles</option>
                        </select>
                        <label>Perfiles de Evaluación</label>
                    </div>
                </div>
                <div class='row'>
                    <div  class='btnSendEmail btn waves-effect waves-light col l2 m2 s4 offset-l5 offset-m5 offset-s4 green darken-2' >
                            Enviar
                        <i class='material-icons right'>send</i>
                    </div>
                </div>
            </form>";

            return $form;
        }

        public function SendEmail_FromTeacher($students, $justification, $period, $subject, $profiles){ /* Cuando el profesor envíe la solicitud de modificar notas*/
            $coordinators = $this->getCoordinator();
            $subject = $this->getSubject($subject);
            $x = 0;

            $bodyMessage = "Petición de permiso para modificar notas del período #". $period[0]->numPeriod ."  de la materia  de ". $subject[0][1] ."° ". $subject[0][0] .". <br><br>";
            $bodyMessage .= "Motivo: '<em>". $justification ."</em>'";
            $bodyMessage .= $profiles;
            $bodyMessage .= $students;

            for($i = 0; $i < count($coordinators); $i++){ /* Se hace el envío a coordinadores  */
                parent::AddCC("". $coordinators[$i][0] ."", "". $coordinators[$i][1] ."");
                $x++;
            }           

            $this->Subject = "".$this->getTeacher().""; /* Se arega que profesor lo envía*/
            $this->msgHTML($bodyMessage); /* Cuerpo de email */
            parent::send(); /* Se envía el mensaje */
        }

        function getCoordinator(){ /* Obtener los coordinadores para el profesor que solicita la modificación de notas */
            $query = "SELECT * FROM coordinator WHERE state = 1";
            $result = $this->connection->connection->query($query);
            $coordinator = array();
            $i = 0;
            while($fila = $result->fetch_assoc()){
                $coordinator[$i][0] = $fila['email'];
                $coordinator[$i][1] = ($r = ($fila['sex'] == 'F') ? "Sra. ". $fila['name'] ."" : "Sr. ". $fila['name'] .""); 
                $i++;
            }
            return ($coordinator);
        }
        function getTeacher(){ /* Obtener datos del profesor que solicita la petición de modificación de notas */
            if(!isset($_SESSION)){
                session_start();
            }
            
            $query = "SELECT * FROM teacher WHERE idTeacher = '". $_SESSION['id'] ."'";
            $result = $this->connection->connection->query($query);
            $teacher = array();
            $fila = $result->fetch_assoc();
            $teacher[0][0] = "". $fila['lastName'] .", ". $fila['name'] ." - ". $fila['idTeacher'] ."";
            return ($teacher[0][0]);
        }
        function getSubject($id){ /* Obtiene datos de la materia la cual el profesor solicita permiso para modificar */
            $query = "SELECT DISTINCT subject.idSubject, subject.nameSubject, level.level FROM subject INNER JOIN register_subject ON register_subject.idSubject = subject.idSubject INNER JOIN section ON section.idSection = register_subject.idSection INNER JOIN level ON level.idLevel = section.idLevel WHERE subject.idSubject = $id";
            $result = $this->connection->connection->query($query);
            $subject = array();
            $fila = $result->fetch_assoc();
            $subject[0][0] = $fila['nameSubject'];
            $subject[0][1] = $fila['level'];

            return ($subject);
        }

        function getInfoProfile($id){/* Obtiene info de cada perfil  que el profesor envío */
            $query = "SELECT evaluation_profile.name, evaluation_profile.percentage FROM evaluation_profile WHERE idProfile = $id";
            $result = $this->connection->connection->query($query);
            $profile = array();
            $fila = $result->fetch_assoc();
            $profile[0][0] = "". $fila['name']. " (" . $fila['percentage'] . "%)";
            return ($profile[0][0]);
        }

        function listStudents($students){/* Formato de lista estudiantes que se envía */
            $list = "<h5>Alumnos</h5>
                <ul>
            ";

            for($x = 0; $x < count($students); $x++){  /* Se agrega los alumnos  */
                 $list .= "<li> ". $students[$x]->id ." - ". $students[$x]->name ." </li>";
            }

            $list .= "</ul>";
            return $list;
        }

        function listProfiles($profiles){
            $list = "<h5>Perfiles de Evaluación</h5>
                <ul>
            ";
            for($x = 0; $x < count($profiles); $x++){/* Se agregan los perfiles de evauación */
                $list .= "<li> ". $this->getInfoProfile($profiles[$x]) ."</li>";
            }
            $list .= "</ul>";
            return $list;
        }

        function SendNewPassword($email, $password){
            $bodyMessage = "<b>Contraseña: </b>".$password;

            parent::addAddress("".$email."", "Sr/Sra");     

            $this->Subject = "Recuperación de Contraseña"; /*Título*/
            $this->msgHTML($bodyMessage); /* Cuerpo de email */
            parent::send(); /* Se envía el mensaje */
        }

        function recordAssistance($table){
            $bodyMessage = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <title>Form</title>
                <style>
                
                    table {
                        border-collapse: collapse;
                        border-spacing: 0;
                    }
                  
                    td,th {
                        padding: 0;
                    }
                    table.centered thead tr th, table.centered tbody tr td {
                        text-align: center;
                    }
                    thead {
                        border-bottom: 1px solid #d0d0d0;
                    }
                  
                    td, th {
                        padding: 15px 5px;
                        display: table-cell;
                        text-align: left;
                        vertical-align: middle;
                        border-radius: 2px;
                    }

                    table.striped > tbody > tr:nth-child(odd) {
                        background-color: #f2f2f2;
                    }
                  
                    table.striped > tbody > tr > td {
                        border-radius: 0;
                    }
                    table.centered thead tr th, table.centered tbody tr td {
                        text-align: center;
                    }
                    table.striped > tbody > tr > td {
                        border-radius: 0;
                    }
                    table.bordered > thead > tr,
                    table.bordered > tbody > tr {
                      border-bottom: 1px solid #d0d0d0;
                    }
                    @media only screen and (max-width: 992px) {
                        table.responsive-table {
                          width: 100%;
                          border-collapse: collapse;
                          border-spacing: 0;
                          display: block;
                          position: relative;
                        }
                        table.responsive-table th,
                        table.responsive-table td {
                          margin: 0;
                          vertical-align: top;
                        }
                        table.responsive-table th {
                          text-align: left;
                        }
                        table.responsive-table thead {
                          display: block;
                          float: left;
                        }
                        table.responsive-table thead tr {
                          display: block;
                          padding: 0 10px 0 0;
                        }
                        table.responsive-table tbody {
                          display: block;
                          width: auto;
                          position: relative;
                          overflow-x: auto;
                          white-space: nowrap;
                        }
                        table.responsive-table tbody tr {
                          display: inline-block;
                          vertical-align: top;
                        }
                        table.responsive-table th {
                          display: block;
                          text-align: right;
                        }
                        table.responsive-table td {
                          display: block;
                          min-height: 1.25em;
                          text-align: left;
                        }
                        table.responsive-table tr {
                          padding: 0 10px;
                        }
                        table.responsive-table thead {
                          border: 0;
                          border-right: 1px solid #d0d0d0;
                        }
                        table.responsive-table.bordered th {
                          border-bottom: 0;
                          border-left: 0;
                        }
                        table.responsive-table.bordered td {
                          border-left: 0;
                          border-right: 0;
                          border-bottom: 0;
                        }
                        table.responsive-table.bordered tr {
                          border: 0;
                        }
                        table.responsive-table.bordered tbody tr {
                          border-right: 1px solid #d0d0d0;
                        }
                      }
                </style>
                </head>
            <body>
                $table
            </body>
            </html>
            ";
            $coordinators = $this->getCoordinator();
            for($i = 0; $i < count($coordinators); $i++){ /* Se hace el envío a coordinadores  */
                parent::AddCC("". $coordinators[$i][0] ."", "". $coordinators[$i][1] ."");
            }           
            $this->Subject = "Control de Asistencia"; /* Se arega que profesor lo envía*/
            $this->msgHTML($bodyMessage); /* Cuerpo de email */
            parent::send(); /* Se envía el mensaje */
        }
    }
?>