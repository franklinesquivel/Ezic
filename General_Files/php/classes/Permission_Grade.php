<?php

    class Permission_Grade{
        private $connection;
        private $aux;
        function __construct(){

            require_once('Page_Constructor.php');
            $const = new Constructor();

            $this->aux = $const->getRoute();
            
            require_once($this->aux);
            $this->connection = new Connection();
            $this->connection->Connect();
            if (!isset($_SESSION)) { session_start(); }
        }

        function v_permissionTeacher(){
            $option_subjects = "";
            $subjects = json_decode($this->getSubjects());

            if(count($subjects) > 0){
                for($i = 0; $i<count($subjects); $i++){
                    $option_subjects .= "<option value='".$subjects[$i]->id."'>".$subjects[$i]->level."° ".$subjects[$i]->name."</option>";
                }
                $form = "
                    <div class='row'>
                        <div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
                            <select id='selectSubject'>
                            <option value='' disabled selected>Seleccionar Asignatura</option>  
                                    $option_subjects
                            </select>
                            <label>Asinatura</label>
                        </div>
                    </div>
                ";
            }else{
                $form = "0";
            }

            return $form;
        }

        function getSubjects(){
            if(!isset($_SESSION)){session_start();}
            $query = "SELECT level.level, subject.nameSubject, subject.idSubject FROM subject INNER JOIN register_subject ON register_subject.idSubject = subject.idSubject INNER JOIN section ON section.idSection = register_subject.idSection INNER JOIN level ON section.idLevel = level.idLevel WHERE subject.idTeacher = '". $_SESSION['id'] ."' GROUP BY subject.idSubject";
            $result = $this->connection->connection->query($query);
            $i = 0;
            $subjects = array();
            while($fila = $result->fetch_assoc()){
                $subjects[$i] = [
                    "id"=>$fila['idSubject'],
                    "level"=>$fila['level'],
                    "name"=>$fila['nameSubject']
                ];
                $i++;
            }
            return (json_encode($subjects));
        }

        function v_permissionCoordinator(){
            $query = "SELECT pg.idPermission_Grade, pg.description, pg.startDate, level.level, COUNT(DISTINCT rp.idStudent) AS numStudent, COUNT(DISTINCT pg_profiles.idProfile) AS numProfiles, subject.nameSubject, teacher.name, teacher.lastName, teacher.idTeacher FROM `pg_students` rp INNER JOIN permission_grade pg ON pg.idPermission_Grade = rp.idPermission INNER JOIN pg_profiles ON pg_profiles.idPermission = pg.idPermission_Grade INNER JOIN evaluation_profile evp ON evp.idProfile = pg_profiles.idProfile INNER JOIN subject ON subject.idSubject = evp.idSubject INNER JOIN teacher ON teacher.idTeacher = subject.idTeacher INNER JOIN register_subject ON register_subject.idSubject = subject.idSubject INNER JOIN section ON section.idSection = register_subject.idSection INNER JOIN level ON level.idLevel = section.idLevel WHERE pg.approved = 0 GROUP BY pg.idPermission_Grade ";
            $result = $this->connection->connection->query($query);
            if($result->num_rows > 0){
                $form = "
                    <div class='row'>
                         <ul class='collection permission-container col l10 m10 s10 offset-l1 offset-m1 offset-s1'>
                ";
                while($fila = $result->fetch_assoc()){
                    $form .="
                        <li class='collection-item dismissable'>
                            <div class='header'>
                                <div class='teacher'>
                                    <span>
                                        ".$fila['lastName'].", ".$fila['name']." - ".$fila['idTeacher']."
                                    </span>
                                    <i class='material-icons left'>account_circle</i>
                                </div>
                                <div class='option'>
                                    <input type='checkbox' id='".$fila['idPermission_Grade']."' class='checkbox_add'/>
                                    <label for='".$fila['idPermission_Grade']."'>Agregar</label>
                                </div>
                            </div>
                            <div class='info-permission'>
                                <div class='gnrl-info'>
                                    <div class='info'>
                                        <span class='title'>Número de Estudiantes: </span>
                                        <span class='result'>".$fila['numStudent']."</span>
                                    </div>
                                    <div class='info'>
                                        <span class='title'>Número de Perfiles: </span>
                                        <span class='result'>".$fila['numProfiles']."</span>
                                    </div>
                                </div>
                                <div class='subject'>
                                    <div class='info'>
                                        <span class='title'>Asignatura: </span>
                                        <span class='result'>".$fila['level']."° ".$fila['nameSubject']."</span>
                                    </div>
                                    <div class='info'>
                                        <span class='title'>Fecha de Solicitud: </span>
                                        <span class='result'>".$fila['startDate']."</span>
                                    </div>
                                </div>
                                <div class='description'>
                                    <div class='title'>Motivo: </div>
                                    <div class='result'>
                                        <p>".$fila['description']."</p>
                                    </div>
                                </div>  
                                <div class='option-view row'>
                                    <button id='".$fila['idPermission_Grade']."' class='btnModalOpen btn waves-effect waves-light black col l4 m4 s6 offset-l4 offset-m4 offset-s3'>Ver Información
                                        <i class='material-icons right'>send</i>
                                    </button> 
                                </div>
                            </div>
                        </li>
                    ";
                }
                $form .= "
                        </ul>
                    </div>
                    <div class='row'>
                        <button id='btnSendPermission' class='btn waves-effect waves-light black col l2 m2 s4 offset-l5 offset-m5 offset-s4'>Enviar
                            <i class='material-icons right'>send</i>
                        </button> 
                    </div>
                ";
            }else{
                $form = "<div class='row result_cont col l10 m10 s10 offset-l1 offset-m1 offset-s1'><div class='search_error'>No hay permisos pendientes por aceptar</div></div>";
            }

            return $form;
        }

        function getInfoPermission($id){
            //Se obtiene los perfiles y su información
            $query = "SELECT evaluation_profile.name, evaluation_profile.percentage, period.nthPeriod FROM `permission_grade` pg INNER JOIN pg_profiles ON pg_profiles.idPermission = pg.idPermission_Grade INNER JOIN evaluation_profile ON evaluation_profile.idProfile = pg_profiles.idProfile INNER JOIN period ON period.idPeriod = evaluation_profile.idPeriod WHERE pg.idPermission_Grade = $id";
            $result = $this->connection->connection->query($query);
            $list_profiles = "";
            $period = 0;
            while($fila = $result->fetch_assoc()){
                $list_profiles .= "<li>".$fila['name']." - ".$fila['percentage']."%</li>";
                $period = $fila['nthPeriod'];
            }

            //Se obtienen los estudiantes y su información
            $query = "SELECT student.idStudent, section.sectionIdentifier, student.photo, level.level FROM pg_students rp INNER JOIN permission_grade pg ON pg.idPermission_Grade = rp.idPermission INNER JOIN student ON student.idStudent = rp.idStudent INNER JOIN section ON section.idSection = student.idSection INNER JOIN level ON level.idLevel = section.idLevel WHERE pg.idPermission_Grade = $id";
            $result = $this->connection->connection->query($query);
            $list_students = ""; 
            while($fila = $result->fetch_assoc()){
                $list_students .= "
                <div class='chip'>
                    <img src='../../files/profile_photos/".$fila['photo']."'>
                    <span class='code'>".$fila['idStudent']."</span>
                    <span class='section'> - ".$fila['level']."° ''".$fila['sectionIdentifier']."'</span>
                </div>";
            }

            //Se arame el contenido final del modal
            $modal_body = " 
                <div class='title grey darken-4'>
                    <h4 class='center'>Período #".$period."</h4>
                </div>
                <div class='info-gnrl'>
                    <div class='list-profiles'>
                        <h5>Perfiles de Evaluación</h5>
                        <ul>
                            ".$list_profiles."
                        </ul>
                    </div>
                    <div class='list-students'>
                        <h5>Estudiantes</h5>
                        <div class='container-chips'>
                            ".$list_students."
                        </div>
                    </div>
                </div>
            ";

            return ($modal_body);
        }

        function AcceptPermission($id){
            $query = "UPDATE permission_grade SET approved = 1, idCoor = '".$_SESSION['id']."' WHERE idPermission_Grade = $id";
            if($this->connection->connection->query($query)){
                return true;
            }else{
                return false;
            }
        }

        function verifyPermission($idStudent, $idProfiles){
            $z = 0;
            for($i = 0; $i < count($idProfiles); $i++){
                $query = "SELECT * FROM `permission_grade` INNER JOIN pg_profiles ON pg_profiles.idPermission = permission_grade.idPermission_Grade INNER JOIN pg_students ON pg_students.idPermission = permission_grade.idPermission_Grade WHERE permission_grade.approved = 0 AND pg_profiles.modified = 0 AND pg_students.idStudent = '".$idStudent."' AND pg_profiles.idProfile = '".$idProfiles[$i]."'";
                $result = $this->connection->connection->query($query);
                if($result->num_rows > 0){
                    $z++;
                }
            }
           return ($z = ($z > 0) ? false: true);
        }

        function InsertPermission($student, $justification, $profiles){
            ini_set("date.timezone", 'America/El_Salvador');
            $date = date("Y-m-d");
            
            /*Ingresamos el permiso*/
            $query = "INSERT INTO permission_grade(startDate, description) VALUES('$date', '$justification')";
            $result = $this->connection->connection->query($query);
            
            /*Obtenemos el último registro ingresado*/
            $query = "SELECT MAX(idPermission_Grade) AS id FROM permission_grade";
            $result = $this->connection->connection->query($query);
            $fila = $result->fetch_assoc();
            $id = $fila['id'];

            if($this->InsertPermission_Profiles($profiles, $id)){
                if($this->InsertPermission_Students($student, $id)){
                    return true;
                }else{
                    return false;
                }        
            }else{
                return false;
            }   
        }

        function InsertPermission_Profiles($profiles, $id){
            $z = 0;
            for($i = 0; $i < count($profiles); $i++){
                $query = "INSERT INTO pg_profiles(idProfile, idPermission)  VALUES('".$profiles[$i]."', $id)";
                if($this->connection->connection->query($query)){
                    $z++;
                }
            }
            return ($z = ($z == count($profiles)) ? true : false);
        }

        function InsertPermission_Students($students, $id){
            $z = 0;
            $students = json_decode($students);
            for($i = 0; $i < count($students); $i++){
                $query = "INSERT INTO pg_students(idStudent, idPermission)  VALUES('".$students[$i]->id."', $id)";
                if($this->connection->connection->query($query)){
                    $z++;
                }
            }
            return ($z = ($z == count($students)) ? true : false);
        }
    }
?>