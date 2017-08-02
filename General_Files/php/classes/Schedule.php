<?php

    /**
     *Clase para todos los procesos relacionados a los HORARIOS.
     */
    class Schedule
    {
        private $connection;
        private $aux;
        private $hours;
        private $days;
        private $breakHours;
        function __construct()
        {
            require_once('Page_Constructor.php');
            $const = new Constructor();

            $this->aux = $const->getRoute();

            require_once($this->aux);
            $this->connection = new Connection();
            $this->connection->Connect();

            $this->hours = array(
                1 => array(0 => "7:00", 1 => "7:45"),
                2 => array(0 => "7:45", 1 => "8:30"),

                3 => array(0 => "8:50", 1 => "9:35"),
                4 => array(0 => "9:35", 1 => "10:20"),

                5 => array(0 => "10:40", 1 => "11:25"),
                6 => array(0 => "11:25", 1 => "12:10"),

                7 => array(0 => "13:05", 1 => "13:50"),
                8 => array(0 => "13:50", 1 => "14:35"),

                9 => array(0 => "14:50", 1 => "15:35"),
                10 => array(0 => "15:35", 1 => "16:15")
            );

            $this->breakHours = array(
                2 => array(0 => '8:30', 1 => '8:50'),
                4 => array(0 => '10:20', 1 => '10:40'),
                6 => array(0 => '12:10', 1 => '13:05'),
                8 => array(0 => '14:35', 1 => '14:50')
            );

            $this->days = array(
                0 => 'Lunes',
                1 => 'Martes',
                2 => 'Miércoles',
                3 => 'Jueves',
                4 => 'Viernes'
            );
        }

        function getTeachers($f)
        {
            $query = "SELECT * FROM teacher t WHERE state = 1 && " . ($f ? "NOT" : "") . " EXISTS (SELECT * FROM schedule_teacher_gnrl_info s WHERE t.idTeacher = s.idTeacher) && EXISTS (SELECT * FROM subject st WHERE t.idTeacher = st.idTeacher);";
            $res = $this->connection->connection->query($query);
            if ($res->num_rows == 0) {
                return -1;
            }

            $aux = "<div class='collection userCollection'>";

            while ($row = $res->fetch_assoc()) {
                $aux .= "
                <a class='collection-item avatar waves-effect waves-black' id='" . $row['idTeacher'] . "'>
                    <img class='circle' src='../../files/profile_photos/" . $row['photo'] . "'>
                    <span class='title black-text'><b>" . $row['lastName'] . ", " . $row['name'] . "</b></span>
                    <p>" . $row['email'] . "<br>
                    " . $row['profession'] . "
                    </p>
                </a>
                ";
            }

            $aux .= "</div>";
            return $aux;
        }

        function buildSchedule($id)
        {
            $eArray = [];
            $oArray = [];
            $aux = "";
            $auxAux = "";
            $optionAux = "";
            $query = "SELECT * FROM teacher t INNER JOIN subject s ON s.idTeacher = t.idTeacher INNER JOIN register_subject rs ON s.idSubject = rs.idSubject INNER JOIN section sec ON rs.idSection = sec.idSection INNER JOIN level l ON sec.idLevel = l.idLevel WHERE t.idTeacher = '" . $id . "' AND t.state = 1;";
            $res = $this->connection->connection->query($query);

            while ($row = $res->fetch_object()) {
                array_push($oArray, $row);
            }

            for ($i=0; $i < count($oArray); $i++) {
                $auxAux .= "<option subject='" . $oArray[$i]->idSubject . "' section='" . $oArray[$i]->idSection . "'>" . $oArray[$i]->acronym . " - " . $oArray[$i]->level . " '" . $oArray[$i]->sectionIdentifier . "'</option>";
            }

            foreach ($this->hours as $key => $value) {
                $aux .= "
                <tr hour='" . $key . "'>
                    <td>" . $this->hours[$key][0] . ' - ' . $this->hours[$key][1] . "</td>";
                for ($i=0; $i < count($this->days); $i++) {

                    $eArray = [];
                    $optionAux = "";
                    $existenceQuery = "SELECT * FROM schedule_register WHERE nthHour = $key && day = '" . $this->days[$i] . "';";
                    $eRes = $this->connection->connection->query($existenceQuery);


                    if ($eRes->num_rows > 0) {
                        $auxArray = $oArray;
                        while ($eRow = $eRes->fetch_object()) {
                            array_push($eArray, $eRow);
                        }

                        for ($x = count($auxArray) - 1; $x >= 0 ; $x--) {
                            for ($z = count($eArray) - 1; $z >= 0 ; $z--) {
                                if ($eArray[$z]->idSection == $auxArray[$x]->idSection) {
                                    $auxFlag = 1;
                                    break 1;
                                }else{
                                    $auxFlag = 0;
                                }
                            }

                            if ($auxFlag) {
                                $optionAux .= "<option unavailable disabled subject='" . $auxArray[$x]->idSubject . "' section='" . $auxArray[$x]->idSection . "'>" . $auxArray[$x]->acronym . " - " . $auxArray[$x]->level . " '" . $auxArray[$x]->sectionIdentifier . "'</option>";
                            }else{
                                $optionAux .= "<option subject='" . $auxArray[$x]->idSubject . "' section='" . $auxArray[$x]->idSection . "'>" . $auxArray[$x]->acronym . " - " . $auxArray[$x]->level . " '" . $auxArray[$x]->sectionIdentifier . "'</option>";
                            }
                        }

                    }else {
                        $optionAux .= $auxAux;
                    }

                    $aux .= "
                    <td day='" . $i . "'>
                        <div class='input-field'>
                            <select>
                                <option disabled selected>Materia - Sección</option>"
                                . $optionAux ."
                            </select>
                        </div>
                    </td>";
                }
                $aux .= "
                </tr>";
            }


            return $aux;
        }

        function saveNewSchedule($data_obj)
        {
            $teacherTable = $this->createTeacherTable($data_obj[0]['idTeacher']);

            $query = "";
            $queryAux = [];
            for ($i=0; $i < count($data_obj) ; $i++) {
                $registerQuery =
                    "INSERT INTO schedule_register VALUES
                    (NULL,
                    '" . $data_obj[$i]['start_time'][0] . "',
                    '" . $data_obj[$i]['end_time'][0] . "',
                    '" . $data_obj[$i]['day'] . "',
                    " . $data_obj[$i]['nth_Hour'] . ",
                    " . $data_obj[$i]['idSection'] . ",
                    " . $data_obj[$i]['idSubject'] . ");";

                if (!($this->connection->connection->query($registerQuery))) return 0;

                $idS_Register = $this->connection->connection->insert_id;

                $gnrlQuery =
                    "INSERT INTO schedule_teacher_gnrl_info VALUES
                    (NULL,
                    '" . $data_obj[$i]['idTeacher'] . "',
                    " . $this->connection->connection->insert_id . ");";

                if (!($this->connection->connection->query($gnrlQuery))) return 0;

                $teacherQuery =
                    "INSERT INTO $teacherTable VALUES
                    (NULL, " . $this->connection->connection->insert_id  . ");";

                if (!($this->connection->connection->query($teacherQuery))) return 0;

                $sectionQuery =
                    "INSERT INTO section_schedule_" . $data_obj[$i]['idSection'] . "
                    VALUES (NULL, $idS_Register);";

                if (!($this->connection->connection->query($sectionQuery))) return 0;
            }

            return 1;
        }

        function createTeacherTable($id)
        {
            $tableName = "teacher_schedule_$id";

            $newTableQuery =
                "CREATE TABLE $tableName (
                  idRegister int(11) NOT NULL,
                  idScheduleInfo int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;";

            $this->connection->connection->query($newTableQuery);

            $alter1_Query =
                "ALTER TABLE $tableName
                    ADD PRIMARY KEY (idRegister),
                    ADD KEY idScheduleInfo (idScheduleInfo);";

            $this->connection->connection->query($alter1_Query);

            $alter2_Query =
                "ALTER TABLE $tableName
                    MODIFY idRegister int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";

            $this->connection->connection->query($alter2_Query);

            $alter3_Query =
                "ALTER TABLE $tableName
                    ADD CONSTRAINT " . $tableName . "_ibfk_1 FOREIGN KEY (idScheduleInfo) REFERENCES schedule_teacher_gnrl_info (idScheduleInfo);";

            $this->connection->connection->query($alter3_Query);

            return $tableName;
        }

        function loadTeacherSchedule($id)
        {
            $optionsQuery = "SELECT * FROM teacher t INNER JOIN subject s ON s.idTeacher = t.idTeacher INNER JOIN register_subject rs ON s.idSubject = rs.idSubject INNER JOIN section sec ON rs.idSection = sec.idSection INNER JOIN level l ON sec.idLevel = l.idLevel INNER JOIN specialty sy ON sy.idSpecialty = sec.idSpecialty WHERE t.idTeacher = '" . $id . "';";
            $scheduleQuery = "SELECT * FROM schedule_register s INNER JOIN schedule_teacher_gnrl_info st ON s.idS_Register = st.idS_Register WHERE st.idTeacher = '" . $id . "';";

            $aux = "";
            $optionAux = "";
            $auxAux = "";
            $scheduleInfo = [];
            $oArray = [];

            $eFlag = 0;
            $auxIndex = 0;
            $flag = 0;

            $gnrlRes = $this->connection->connection->query($optionsQuery);
            $scheduleRes = $this->connection->connection->query($scheduleQuery);

            while ($scheduleRow = $scheduleRes->fetch_object()) {
                array_push($scheduleInfo, $scheduleRow);
            }

            while ($gnrlRow = $gnrlRes->fetch_object()) {
                array_push($oArray, $gnrlRow);
            }

            for ($i=0; $i < count($oArray); $i++) {
                $auxAux .= "<option subject='" . $oArray[$i]->idSubject . "' section='" . $oArray[$i]->idSection . "'>" . $oArray[$i]->acronym . " - " . $oArray[$i]->level . " '" . $oArray[$i]->sectionIdentifier . "'</option>";
            }

            for ($i=1; $i <= 10; $i++) {
                $aux .= "
                    <tr hour='" . $i . "'>
                        <td>" . $this->hours[$i][0] . ' - ' . $this->hours[$i][1] . "</td>";
                for ($j=0; $j < 5; $j++) {
                    //----------------------------------------------------------------------------------------------
                    $eArray = [];
                    $optionAux = "";
                    $existenceQuery = "SELECT * FROM schedule_register WHERE nthHour = $i && day = '" . $this->days[$j] . "';";
                    $eRes = $this->connection->connection->query($existenceQuery);

                    if ($eRes->num_rows > 0) {
                        $eGnrlFlag = 1;
                        $auxArray = $oArray;
                        while ($eRow = $eRes->fetch_object()) {
                            array_push($eArray, $eRow);
                        }

                        for ($x = count($auxArray) - 1; $x >= 0 ; $x--) {
                            for ($z = count($eArray) - 1; $z >= 0 ; $z--) {
                                if ($eArray[$z]->idSection == $auxArray[$x]->idSection) {
                                    $eFlag = 1;
                                    break 1;
                                }else{
                                    $eFlag = 0;
                                }
                            }

                            if ($eFlag) {
                                $optionAux .= "<option unavailable disabled subject='" . $auxArray[$x]->idSubject . "' section='" . $auxArray[$x]->idSection . "'>" . $auxArray[$x]->acronym . " - " . $auxArray[$x]->level . " '" . $auxArray[$x]->sectionIdentifier . "'</option>";
                            }else{
                                $optionAux .= "<option subject='" . $auxArray[$x]->idSubject . "' section='" . $auxArray[$x]->idSection . "'>" . $auxArray[$x]->acronym . " - " . $auxArray[$x]->level . " '" . $auxArray[$x]->sectionIdentifier . "'</option>";
                            }
                        }

                    }else {
                        $eGnrlFlag = 0;
                        $optionAux .= $auxAux;
                    }
                    //----------------------------------------------------------------------------------------------
                    $gnrlRes = $this->connection->connection->query($optionsQuery);
                    $aux .= "
                        <td day='" . $j . "'>
                            <div class='input-field'>
                                <select>";
                    if (count($scheduleInfo) > 0) {
                        for ($x=0; $x < count($scheduleInfo); $x++) {
                            if( $scheduleInfo[$x]->nthHour == $i){
                                $flag = 1;
                                $auxIndex = $x;
                                break;
                            }else{$flag = 0;}
                        }
                        if ($flag) {//Hay en la fila
                            for ($x=0; $x < count($scheduleInfo); $x++) {
                                if( $scheduleInfo[$x]->day == $this->days[$j] && $scheduleInfo[$x]->nthHour == $i){
                                    $flag = 1;
                                    $auxIndex = $x;
                                    break;
                                }else{$flag = 0;}
                            }
                            if ($flag) {//Hay en la columna

                                if ($eGnrlFlag) {

                                    for ($x = count($auxArray) - 1; $x >= 0 ; $x--) {
                                        for ($z = count($eArray) - 1; $z >= 0 ; $z--) {
                                            if ($eArray[$z]->idSection == $auxArray[$x]->idSection && $scheduleInfo[$auxIndex]->idSection != $auxArray[$x]->idSection ) {
                                                $eFlag = 1;
                                                break 1;
                                            }else{
                                                $eFlag = 0;
                                            }
                                        }

                                        if ($eFlag) {
                                            $aux .= "
                                        <option " . ( $scheduleInfo[$auxIndex]->idSection == $auxArray[$x]->idSection && $scheduleInfo[$auxIndex]->idSubject == $auxArray[$x]->idSubject ? "selected register='" . $scheduleInfo[$auxIndex]->idS_Register . "'" : "update unavailable disabled") . " subject='" . $auxArray[$x]->idSubject . "' section='" . $auxArray[$x]->idSection . "'>" . $auxArray[$x]->acronym .
                                        " - " . $auxArray[$x]->level . " '" . $auxArray[$x]->sectionIdentifier . "'</option>";
                                        }else{
                                            $aux .= "
                                        <option " . ( $scheduleInfo[$auxIndex]->idSection == $auxArray[$x]->idSection && $scheduleInfo[$auxIndex]->idSubject == $auxArray[$x]->idSubject ? "selected register='" . $scheduleInfo[$auxIndex]->idS_Register . "'" : "update") . " subject='" . $auxArray[$x]->idSubject . "' section='" . $auxArray[$x]->idSection . "'>" . $auxArray[$x]->acronym .
                                        " - " . $auxArray[$x]->level . " '" . $auxArray[$x]->sectionIdentifier . "'</option>";
                                        }
                                    }

                                }else {
                                    while ($gnrlRow = $gnrlRes->fetch_object()) {
                                        $aux .= "
                                        <option " . ( $scheduleInfo[$auxIndex]->idSection == $gnrlRow->idSection && $scheduleInfo[$auxIndex]->idSubject == $gnrlRow->idSubject ? "selected register='" . $scheduleInfo[$auxIndex]->idS_Register . "'" : "update") . " subject='" . $gnrlRow->idSubject . "' section='" . $gnrlRow->idSection . "'>" . $gnrlRow->acronym .
                                        " - " . $gnrlRow->level . " '" . $gnrlRow->sectionIdentifier . "'</option>";
                                    }
                                }

                                array_splice($scheduleInfo, $auxIndex, 1);
                            }else {//No hay en la columna pero si en la fila (repetir)
                                $aux .= "
                                    <option disabled selected>Materia - Sección</option>
                                    $optionAux";
                            }
                        }else {//No hay en la fila (siguiente)
                            $aux .= "
                                    <option disabled selected>Materia - Sección</option>
                                    $optionAux";
                        }
                        $aux .= "
                                    <option delete>Vaciar</option>
                                </select>
                            </div>
                        </td>";
                    }else{
                        $aux .= "
                                    <option disabled selected>Materia - Sección</option>
                                    $optionAux
                                    <option delete>Vaciar</option>
                                </select>
                            </div>
                        </td>";
                    }
                }
                $aux .= "
                    </tr>";
            }

            return $aux;
        }

        function updateScheduleData($obj)
        {
            if ( count($obj) > 0 ) {
                for ($i=0; $i < count($obj); $i++) {

                    $prevDataQuery = "SELECT * FROM schedule_register WHERE idS_Register = '" . $obj[$i]['idS_Register'] . "';";

                    $dataRes = $this->connection->connection->query($prevDataQuery);
                    $dataRow =$dataRes->fetch_assoc();

                    if ( $dataRow['idSection'] != $obj[$i]['idSection'] ) {
                        $deleteSectionQuery =
                            "DELETE FROM section_schedule_" . $dataRow['idSection'] . " WHERE idScheduleRegister = " . $obj[$i]['idS_Register'] . ";";

                        if (!($this->connection->connection->query($deleteSectionQuery))) return 0;

                        $insertSectionQuery =
                            "INSERT INTO section_schedule_" . $obj[$i]['idSection'] . "
                            VALUES (NULL, " . $obj[$i]['idS_Register'] . ");";

                        if (!($this->connection->connection->query($insertSectionQuery))) return 0;
                    }

                    $updateQuery =
                        "UPDATE schedule_register
                        SET startTime = '" . $obj[$i]['start_time'][0] . "', endTime = '" . $obj[$i]['end_time'][0] . "',
                        day = '" . $obj[$i]['day'] . "', nthHour = '" . $obj[$i]['nth_Hour'] . "',
                        idSection = '" . $obj[$i]['idSection'] . "', idSubject = '" . $obj[$i]['idSubject'] . "'
                        WHERE idS_Register = " . $obj[$i]['idS_Register'] . ";";

                    if (!($this->connection->connection->query($updateQuery))) return 0;
                }
                return 1;
            }else {
                return 1;
            }
        }

        function deleteScheduleData($obj)
        {
            if ( count($obj) > 0 ) {
                for ($i=0; $i < count($obj); $i++) {
                    $idsQuery =
                    "SELECT tt.idRegister, st.idScheduleInfo
                    FROM teacher_schedule_" . $obj[$i]['idTeacher'] . " tt
                    INNER JOIN schedule_teacher_gnrl_info st ON tt.idScheduleInfo = st.idScheduleInfo
                    INNER JOIN schedule_register sr ON sr.idS_Register = st.idS_Register
                    WHERE sr.idS_Register = " . $obj[$i]['idS_Register'] . ";";

                    $res = $this->connection->connection->query($idsQuery);
                    $row = $res->fetch_assoc();

                    $sectionQuery =
                    "DELETE FROM section_schedule_" . $obj[$i]['idSection'] . " WHERE idScheduleRegister = " . $obj[$i]['idS_Register'] . ";";
//
                    if (!($this->connection->connection->query($sectionQuery))) return 0;

                    $teacherQuery =
                        "DELETE FROM teacher_schedule_" . $obj[$i]['idTeacher'] . "
                        WHERE idRegister = " . $row['idRegister'] . ";";

                    if (!($this->connection->connection->query($teacherQuery))) return 0;

                    $gnrlQuery =
                        "DELETE FROM schedule_teacher_gnrl_info WHERE idScheduleInfo = " . $row['idScheduleInfo'] . ";";

                    if (!($this->connection->connection->query($gnrlQuery))) return 0;

                    $registerQuery =
                        "DELETE FROM schedule_register WHERE idS_Register = " . $obj[$i]['idS_Register'] . ";";

                    if (!($this->connection->connection->query($registerQuery))) return 0;

                }

                return 1;
            }else {
                return 1;
            }
        }

        function addScheduleData($obj)
        {
            $idS_Register = 0;
            if ( count($obj) > 0 ) {
                for ($i=0; $i < count($obj); $i++) {
                    $registerQuery =
                        "INSERT INTO schedule_register VALUES
                        (NULL,
                        '" . $obj[$i]['start_time'][0] . "',
                        '" . $obj[$i]['end_time'][0] . "',
                        '" . $obj[$i]['day'] . "',
                        " . $obj[$i]['nth_Hour'] . ",
                        " . $obj[$i]['idSection'] . ",
                        " . $obj[$i]['idSubject'] . ");";

                    if (!($this->connection->connection->query($registerQuery))) return 0;

                    $idS_Register = $this->connection->connection->insert_id;

                    $gnrlQuery =
                        "INSERT INTO schedule_teacher_gnrl_info VALUES
                        (NULL,
                        '" . $obj[$i]['idTeacher'] . "', $idS_Register);";

                    if (!($this->connection->connection->query($gnrlQuery))) return 0;

                    $teacherQuery =
                        "INSERT INTO teacher_schedule_" . $obj[$i]['idTeacher'] . "
                        VALUES (NULL, " . $this->connection->connection->insert_id . ");";

                    if (!($this->connection->connection->query($teacherQuery))) return 0;;

                    $sectionQuery =
                        "INSERT INTO section_schedule_" . $obj[$i]['idSection'] . "
                        VALUES (NULL, $idS_Register);";

                    if (!($this->connection->connection->query($sectionQuery))) return 0;
                }

                return 1;
            }else {
                return 1;
            }
        }

        function loadSchedule($type, $id)
        {
            $aux = "";
            $dataArray = [];
            $auxHistorial = [];
            $auxArray = array( 0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0);
            $auxEmpty = $auxArray;
            $auxEmpty_2 = $auxArray;
            $auxEmpty_3 = $auxArray;
            $flag = 0;
            $equalF = 0;
            $equalF_2 = 0;
            $auxIndex;
            $auxIndex_2;
            if ($type == 'S') {
                $indexInd = "nameSubject";
                $indexInfo = "acronym";
                $studentQuery = "SELECT idSection FROM student WHERE idStudent = '$id';";
                $sectionAux = $this->connection->connection->query($studentQuery)->fetch_assoc()['idSection'];
                $query =
                "SELECT * FROM section_schedule_" . $sectionAux . " ss
                INNER JOIN schedule_register sr ON ss.idScheduleRegister = sr.idS_Register
                INNER JOIN section s ON s.idSection = sr.idSection
                INNER JOIN subject sct ON sr.idSubject = sct.idSubject
                INNER JOIN specialty sy ON s.idSpecialty = sy.idSpecialty;";
                $verify_Query = "SELECT * FROM schedule_register sr WHERE sr.idSection = (SELECT st.idSection FROM student st WHERE st.idStudent = '$id')";
            }else {
                $indexInd = "sectionIdentifier";
                $indexInfo = "sName";
                $query =
                "SELECT * FROM teacher_schedule_$id ts
                INNER JOIN schedule_teacher_gnrl_info gi ON ts.idScheduleInfo = gi.idScheduleInfo
                INNER JOIN schedule_register sr ON sr.idS_Register = gi.idS_Register
                INNER JOIN section s ON sr.idSection = s.idSection
                INNER JOIN specialty sy ON s.idSpecialty = sy.idSpecialty
                INNER JOIN level l ON l.idLevel = s.idLevel;";
                $verify_Query = "SHOW TABLES LIKE 'teacher_schedule_$id';";
            }

            $verify = $this->connection->connection->query($verify_Query);

            if($verify->num_rows == 0){
                return -1;
            }else{
                $res = $this->connection->connection->query($query);

                while ($row = $res->fetch_assoc()) {
                    array_push($dataArray, $row);
                }

                for ($i=1; $i <= 10; $i++) {
                    if ($i % 2 == 1) {
                        for ($a=0; $a < count($auxArray); $a++) {
                            $auxArray[$a] = 0;
                            $auxEmpty[$a] = 0;
                            $auxEmpty_2[$a] = 0;
                            $auxEmpty_3[$a] = 0;
                        }
                    }
                    $aux .= "
                        <tr hour='" . $i . "'>
                            <td class='hour'>" . $this->hours[$i][0] . ' - ' . $this->hours[$i][1] . "</td>";
                    for ($j=0; $j < 5; $j++) {
                        if (count($dataArray) > 0) {
                            for ($x=0; $x < count($dataArray); $x++) {
                                if( $dataArray[$x]['nthHour'] == $i){
                                    $flag = 1;
                                    $auxIndex = $x;
                                    break;
                                }else{$flag = 0;}
                            }
                            if ($flag) {//Hay en la fila
                                for ($x=0; $x < count($dataArray); $x++) {
                                    if( $dataArray[$x]['day'] == $this->days[$j] && $dataArray[$x]['nthHour'] == $i){
                                        $flag = 1;
                                        $auxIndex = $x;
                                        break;
                                    }else{$flag = 0;}
                                }

                                for ($g=0; $g < count($dataArray); $g++) {
                                    if ($g == $auxIndex){continue;}
                                    if ($dataArray[$auxIndex]['day'] == $dataArray[$g]['day'] &&
                                    $dataArray[$auxIndex]['idSubject'] == $dataArray[$g]['idSubject'] &&
                                    $dataArray[$auxIndex]['idSection'] == $dataArray[$g]['idSection'] &&
                                    ($dataArray[$auxIndex]['nthHour'] + 1) == $dataArray[$g]['nthHour'] &&
                                    ($i + 1) == $dataArray[$g]['nthHour'] &&
                                    $dataArray[$g]['day'] == $this->days[$j] && $i % 2 == 1) {
                                        $equalF = 1;
                                        $auxIndex_2 = $g;
                                        $auxArray[$j] = 1;
                                        // return $dataArray[$auxIndex]['day'] . " - " . $dataArray[$g]['day'];
                                        break;
                                    }else{
                                        $equalF = 0;
                                        $auxArray[$j] = $auxArray[$j];
                                    }
                                }

                                if ($flag) {//Hay en la columna
                                    if ($equalF) {
                                        $aux .= "
                                        <td class='style' rowspan=2 style='font-size: 1.5em;' title='" . $dataArray[$auxIndex][$indexInfo] . "'><b>" . ($type == 'T' ? $dataArray[$auxIndex]['level'] . "°" : "") . " " . $dataArray[$auxIndex][$indexInd] . "<b></td>";
                                        $equalF = 0;
                                        // array_splice($dataArray, $auxIndex_2, 1);
                                    }else{
                                        $aux .= ($auxArray[$j] ? "" : "<td class='style' title='" . $dataArray[$auxIndex][$indexInfo] . "'><b>" . ($type == 'T' ? $dataArray[$auxIndex]['level'] . "°" : "") . " " . $dataArray[$auxIndex][$indexInd] . "<b></td>");
                                        $auxEmpty_3[$j] = ($i % 2 == 1 ? 1 : 0);
                                    }
                                    array_splice($dataArray, $auxIndex, 1);
                                }else {//No hay en la columna pero si en la fila (repetir)
                                    if ($auxEmpty[$j]) {
                                        $aux .= "";
                                    }else{
                                        for ($b=0; $b < count($dataArray); $b++) {
                                            if ($dataArray[$b]['day'] == $this->days[$j] && $dataArray[$b]['nthHour'] == ($i+1) && $i % 2 == 1) {
                                                $auxEmpty_2[$j] = 0;
                                                $asd = $b;
                                                break;
                                            }elseif ($i % 2 == 1){
                                                $auxEmpty_2[$j] = 1;
                                            }elseif ($i % 2 == 0) {
                                                $auxEmpty_2[$j] = -1;
                                            }
                                        }

                                        if ($auxEmpty_2[$j] == 0) {
                                            $aux .= "<td></td>";
                                        }elseif ($auxEmpty_2[$j] == 1) {
                                            $aux .= "<td rowspan=2></td>";
                                        }else {
                                            $aux .= ($auxEmpty_3[$j] ? "<td></td>" : "");
                                        }
                                    }
                                }
                            }else {//No hay en la fila (siguiente)
                                for ($c=0; $c < count($dataArray); $c++) {
                                    if ($dataArray[$c]['day'] == $this->days[$j] && $dataArray[$c]['nthHour'] == ($i+1) && $i % 2 == 1) {
                                        $iFlag = 1;
                                        break;
                                    }elseif($i % 2 == 1){
                                        $iFlag = 0;
                                    }else{
                                        $iFlag = -1;
                                    }
                                }

                                if ($iFlag == 1) {
                                    $aux .= "<td></td>";
                                }elseif ($iFlag == 0){
                                    $aux .= "<td rowspan=2></td>";
                                    $auxEmpty[$j] = 1;
                                }else{
                                    $aux .= ($auxEmpty_3[$j] ? "<td></td>" : "");//
                                }
                            }
                        }else{
                            if ($i % 2 == 0) {
                                $aux .= "";//
                            }else{
                                $aux .= "<td rowspan=2></td>";
                            };
                        }
                    }
                    $aux .= "
                        </tr>";
                    if ( $i == 2 || $i == 4 || $i == 6 || $i == 8 ) {
                        $aux .= "
                        <tr $i class='" . ($type == 'S' ? "blue" : "green") . " lighten-4'><td>" . $this->breakHours[$i][0] . " - " . $this->breakHours[$i][1] . "</td><td colspan='5'>" . ($i == 6 ? "ALMUERZO" : "RECREO") . "</td></td>";
                    }
                }

                return $aux; 
            }
        }

        function printSchedule($type, $id, $title)
        {
            $aux = "
            <table>
                <tbody>
                    <tr>
                        <th>Hora</th>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miércoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                    </tr>";
            $dataArray = [];
            $auxHistorial = [];
            $auxArray = array( 0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0);
            $auxEmpty = $auxArray;
            $auxEmpty_2 = $auxArray;
            $auxEmpty_3 = $auxArray;
            $flag = 0;
            $equalF = 0;
            $equalF_2 = 0;
            $auxIndex;
            $auxIndex_2;
            if ($type == 'S') {
                $indexInd = "nameSubject";
                $indexInfo = "nameSubject";
                $studentQuery = "SELECT idSection FROM student WHERE idStudent = '$id';";
                $sectionAux = $this->connection->connection->query($studentQuery)->fetch_assoc()['idSection'];
                $query =
                "SELECT * FROM section_schedule_" . $sectionAux . " ss
                INNER JOIN schedule_register sr ON ss.idScheduleRegister = sr.idS_Register
                INNER JOIN section s ON s.idSection = sr.idSection
                INNER JOIN specialty sy ON s.idSpecialty = sy.idSpecialty
                INNER JOIN subject sct ON sr.idSubject = sct.idSubject;";
            }else {
                $indexInd = "sectionIdentifier";
                $indexInfo = "sName";
                $query =
                "SELECT * FROM teacher_schedule_$id ts
                INNER JOIN schedule_teacher_gnrl_info gi ON ts.idScheduleInfo = gi.idScheduleInfo
                INNER JOIN schedule_register sr ON sr.idS_Register = gi.idS_Register
                INNER JOIN section s ON sr.idSection = s.idSection
                INNER JOIN specialty sy ON s.idSpecialty = sy.idSpecialty
                INNER JOIN level l ON l.idLevel = s.idLevel;";
            }

            $res = $this->connection->connection->query($query);
            while ($row = $res->fetch_assoc()) {
                array_push($dataArray, $row);
            }

            for ($i=1; $i <= 10; $i++) {
                if ($i % 2 == 1) {
                    for ($a=0; $a < count($auxArray); $a++) {
                        $auxArray[$a] = 0;
                        $auxEmpty[$a] = 0;
                        $auxEmpty_2[$a] = 0;
                        $auxEmpty_3[$a] = 0;
                    }
                }
                $aux .= "
                    <tr>
                        <td class='hour'>" . $this->hours[$i][0] . ' - ' . $this->hours[$i][1] . "</td>";
                for ($j=0; $j < 5; $j++) {
                    if (count($dataArray) > 0) {
                        for ($x=0; $x < count($dataArray); $x++) {
                            if( $dataArray[$x]['nthHour'] == $i){
                                $flag = 1;
                                $auxIndex = $x;
                                break;
                            }else{$flag = 0;}
                        }
                        if ($flag) {//Hay en la fila
                            for ($x=0; $x < count($dataArray); $x++) {
                                if( $dataArray[$x]['day'] == $this->days[$j] && $dataArray[$x]['nthHour'] == $i){
                                    $flag = 1;
                                    $auxIndex = $x;
                                    break;
                                }else{$flag = 0;}
                            }

                            for ($g=0; $g < count($dataArray); $g++) {
                                if ($g == $auxIndex){continue;}
                                if ($dataArray[$auxIndex]['day'] == $dataArray[$g]['day'] &&
                                $dataArray[$auxIndex]['idSubject'] == $dataArray[$g]['idSubject'] &&
                                $dataArray[$auxIndex]['idSection'] == $dataArray[$g]['idSection'] &&
                                ($dataArray[$auxIndex]['nthHour'] + 1) == $dataArray[$g]['nthHour'] &&
                                ($i + 1) == $dataArray[$g]['nthHour'] &&
                                $dataArray[$g]['day'] == $this->days[$j] && $i % 2 == 1) {
                                    $equalF = 1;
                                    $auxIndex_2 = $g;
                                    $auxArray[$j] = 1;
                                    break;
                                }else{
                                    $equalF = 0;
                                    $auxArray[$j] = $auxArray[$j];
                                }
                            }

                            if ($flag) {//Hay en la columna
                                if ($equalF) {
                                    $aux .= "
                                    <td rowspan=2>" . ($type == 'T' ? $dataArray[$auxIndex]['level'] . "°" : "") . " " . $dataArray[$auxIndex][$indexInd] . "</td>";
                                    $equalF = 0;
                                }else{
                                    $aux .= ($auxArray[$j] ? "" : "<td>" . ($type == 'T' ? $dataArray[$auxIndex]['level'] . "°" : "") . " " . $dataArray[$auxIndex][$indexInd] . "</td>");
                                    $auxEmpty_3[$j] = ($i % 2 == 1 ? 1 : 0);
                                }
                                array_splice($dataArray, $auxIndex, 1);
                            }else {//No hay en la columna pero si en la fila (repetir)
                                if ($auxEmpty[$j]) {
                                    $aux .= "";
                                }else{
                                    for ($b=0; $b < count($dataArray); $b++) {
                                        if ($dataArray[$b]['day'] == $this->days[$j] && $dataArray[$b]['nthHour'] == ($i+1) && $i % 2 == 1) {
                                            $auxEmpty_2[$j] = 0;
                                            $asd = $b;
                                            break;
                                        }elseif ($i % 2 == 1){
                                            $auxEmpty_2[$j] = 1;
                                        }elseif ($i % 2 == 0) {
                                            $auxEmpty_2[$j] = -1;
                                        }
                                    }

                                    if ($auxEmpty_2[$j] == 0) {
                                        $aux .= "<td></td>";
                                    }elseif ($auxEmpty_2[$j] == 1) {
                                        $aux .= "<td rowspan=2></td>";
                                    }else {
                                        $aux .= ($auxEmpty_3[$j] ? "<td></td>" : "");
                                    }
                                }
                            }
                        }else {//No hay en la fila (siguiente)
                            for ($c=0; $c < count($dataArray); $c++) {
                                if ($dataArray[$c]['day'] == $this->days[$j] && $dataArray[$c]['nthHour'] == ($i+1) && $i % 2 == 1) {
                                    $iFlag = 1;
                                    break;
                                }elseif($i % 2 == 1){
                                    $iFlag = 0;
                                }else{
                                    $iFlag = -1;
                                }
                            }

                            if ($iFlag == 1) {
                                $aux .= "<td></td>";
                            }elseif ($iFlag == 0){
                                $aux .= "<td rowspan=2></td>";
                                $auxEmpty[$j] = 1;
                            }else{
                                $aux .= ($auxEmpty_3[$j] ? "<td></td>" : "");//
                            }
                        }
                    }else{
                        if ($i % 2 == 0) {
                            $aux .= "";//
                        }else{
                            $aux .= "<td rowspan=2></td>";
                        };
                    }
                }
                $aux .= "
                    </tr>";
                if ( $i == 2 || $i == 4 || $i == 6 || $i == 8 ) {
                    $aux .= "
                    <tr class='break $type'><td>" . $this->breakHours[$i][0] . " - " . $this->breakHours[$i][1] . "</td><td colspan='5'>" . ($i == 6 ? "ALMUERZO" : "RECREO") . "</td></td>";
                }
            }

            $aux .= "
                </tbody></table>
            ";

            return $aux; 
        }

        function deleteSchedule($id){
            $idAux = [];
            $teacherTableQuery = "DROP TABLE teacher_schedule_$id";

            if (!($this->connection->connection->query($teacherTableQuery))) return 0;

            $gnrlTeacherQuery =
            "SELECT * FROM schedule_teacher_gnrl_info st
            INNER JOIN schedule_register sr ON sr.idS_Register = st.idS_Register
            WHERE idTeacher = '$id'";

            $gnrlT_Res = $this->connection->connection->query($gnrlTeacherQuery);

            while($gnrlRow = $gnrlT_Res->fetch_assoc()){
                array_push($idAux, $gnrlRow);
            }

            for ($i=0; $i < count($idAux); $i++) {
                $deleteGnrl = "DELETE FROM schedule_teacher_gnrl_info WHERE idScheduleInfo = " . $idAux[$i]['idScheduleInfo'];
                $deleteSection = "DELETE FROM section_schedule_" . $idAux[$i]['idSection'] . " WHERE idScheduleRegister = " . $idAux[$i]['idS_Register'];
                $deleteRegister = "DELETE FROM schedule_register WHERE idS_Register = " . $idAux[$i]['idS_Register'];

                if (!($this->connection->connection->query($deleteGnrl))) return 0;
                if (!($this->connection->connection->query($deleteSection))) return 0;
                if (!($this->connection->connection->query($deleteRegister))) return 0;
            }

            return 1;
        }
    }


?>
