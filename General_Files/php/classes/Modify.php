<?php

    require_once('User_Class.php');

    class Modify extends Users
    {
        public $aux;
        public $idLog;
        public $table;
        public $type;

        function __construct(){
            parent::__construct();
            require_once('Page_Constructor.php');
            $const = new Constructor();

            $this->aux = $const->getRoute();

            require_once($this->aux);
            $this->connection = new Connection();
            $this->connection->Connect();
        }

        function load_Form($id)
        {
            if (!isset($_SESSION)) {
                session_start();
            }
            $type = $id;
            $coordiFlag = $_SESSION['type'] == 'C' ? 1 : 0;

            if ($type[0] == 'C' && is_numeric($type[1])) {
    			$type = 'C'; $idLog = 'idCoor'; $table = 'coordinator';
                $query = "SELECT * FROM $table WHERE $idLog = '" . $id . "';";
    		}elseif ($type[0] == 'D' && is_numeric($type[1])) {
    			$type = 'T'; $idLog = 'idTeacher'; $table = 'teacher';
                $query = "SELECT * FROM $table WHERE $idLog = '" . $id . "';";
    		}else{
    			$type = 'S'; $idLog = 'idStudent'; $table = 'student';
                $query = "
                SELECT * FROM student st 
                INNER JOIN section sn ON st.idSection = sn.idSection 
                INNER JOIN level l ON sn.idLevel = l.idLevel
                INNER JOIN specialty sy ON sn.idSpecialty = sy.idSpecialty
                WHERE st.idStudent = '" . $id . "';";
    		}

            $res = $this->connection->connection->query($query);
            $row = $res->fetch_assoc();

            $gradeRes = $this->connection->connection->query("SELECT COUNT(*) as cant FROM grade g WHERE g.idStudent = '$id';");
            $gradeFlag = ($gradeRes->fetch_assoc()['cant'] == 0 ? 1 : 0);

            $frm = "
            <div class='row'>
                <div class='header_info_cont'>";
            if ($coordiFlag || $_SESSION['type'] == 'T') {
                $frm .= "
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
                        <img src='../../files/profile_photos/" . $row['photo'] . "' class='circle frmPhoto' alt=''>
                    </div>";
            }
            $frm .= "
                    <div class='info'>
                        <h3><b id='userId'>" . $row[$idLog] . "</b></h3>
                        <h5>" . $row['lastName'] . ", " . $row['name'] . "</h5>
                    </div>
                </div>
            </div>
            <div class='row'>
                <form class='frmData'>
                    <div class='row'>";
            if ($coordiFlag) {
                $frm .= "<div class='input-field col l5 m5 s10 offset-l1 offset-m1 offset-s1'>
                            <input class='txtName' id='txtName' type='text' name='txtName' value='" . $row['name'] . "'>
                            <label for='txtName'>Nombres</label>
                        </div>
                        <div class='input-field col l5 m5 s10 offset-s1'>
                            <input class=txtLastName'' id='txtLastName' type='text' name='txtLastName' value='" . $row['lastName'] . "'>
                            <label for='txtLastName'>Apellidos</label>
                        </div>
                    </div>";
            }
            $frm .= "<div class='row'>
                        <div class='input-field col l5 m5 s10 offset-l1 offset-m1 offset-s1'>
                            <input class=txtPass'' id='txtPass' type='text' name='txtPass' value='" . $this->DisarmedEncryption($row['password']) . "'>
                            <label for='txtPass'>Contraseña</label>
                        </div>
                        <div class='input-field col l5 m5 s10 offset-s1'>
                            <input class='txtEmail' id='txtEmail' type='email' name='txtEmail' value='" . $row['email'] . "'>
                            <label for='txtEmail'>Correo Electrónico</label>
                        </div>
                    </div>";
            
            if ($coordiFlag) {
                $frm .= "<div class='row'>
                        <div class='input-field col l10 m10 s10 offset-l1 offset-m1 offset-s1'>
                            <textarea id='txtRes' name='txtRes' class='materialize-textarea'>" . $row['residence'] . "</textarea>
                            <label for='txtRes'>Residencia</label>
                        </div>
                        <div class='input-field col l10 m10 s10 offset-l1 offset-m1 offset-s1'>
                            <input class='txtDate datepicker' id='txtDate' type='date' name='txtDate' value='" . $row['birthdate'] . "'>
                            <label class='active' for='txtDate'>Fecha de Nacimiento</label>
                        </div>
                    </div>";

            if ($type != 'S') {
                $frm = $frm . "
                <div class='input-field col l10 m10 s10 offset-l1 offset-m1 offset-s1'>
                    <input class='txtProf' id='txtProf' type='text' name='txtProf' value='" . $row['profession'] . "'>
                    <label for='txtProf'>Profesión</label>
                </div>
                ";
            }else{
                if ($gradeFlag) {
                    $frm = $frm . "
                    <div class='input-field col l5 m5 s10 offset-l1 offset-m1 offset-s1'>
                        <select name='cmbLvl_Mod' id='cmbLvl_Mod' class='cmbUpdate'>
                            <option value='' disabled>Seleccione una opción</option>";

                    $lvlRes = $this->connection->connection->query("SELECT * FROM level;");
                    $snAux = "";
                    while ($lvlRow = $lvlRes->fetch_assoc()) {
                        $frm = $frm . "
                            <option value='" . $lvlRow['idLevel'] . "' " . ( $row['idLevel'] == $lvlRow['idLevel'] ? "selected" : "")  . ">Año " . $lvlRow['level'] . "</option>
                        ";

                        $snRes = $this->connection->connection->query("SELECT * FROM section sn INNER JOIN level l ON l.idLevel = sn.idLevel INNER JOIN specialty sy ON sy.idSpecialty = sn.idSpecialty WHERE sn.idLevel = " . $row['idLevel'] . ";");

                        // echo "SELECT * FROM section sn INNER JOIN level l ON l.idLevel = sn.idLevel INNER JOIN specialty sy ON sy.idSpecialty = sn.idSpecialty WHERE sn.idSection = " . $row['idSection'] . ";";

                        while ($snRow = $snRes->fetch_assoc()) {
                            if ($lvlRow['idLevel'] == $row['idLevel']) {
                                $snAux .= "<option value='" . $snRow['idSection'] . "' " . ( $row['idSection'] == $snRow['idSection'] ? "selected" : "")  . ">" . $snRow['sName'] . ", " . $snRow['sectionIdentifier'] . "</option>";
                            }
                        }

                    }
                    $frm .= "
                        </select>
                        <label>Grado</label>
                    </div>
                    <div class='input-field col l5 m5 s10 offset-s1'>
                        <select name='cmbSection_Mod' id='cmbSection_Mod'  class='cmbUpdate'>
                            <option disabled>Seleccione una opción</option>
                            $snAux
                        </select>
                        <label>Sección</label>
                    </div>";
                }
            }

            $frm = $frm . "
                    <div class='input-field col l2 m2 s4 offset-l5 offset-m5 offset-s4'>
                        <input " . ($row['sex'] == 'F' ? "checked='true'" : "") . " class='txtSex_F with-gap' id='txtSex_F' type='radio' name='txtSex' value='F'>
                        <label for='txtSex_F'>Femenino</label>
                    </div>
                    <div class='input-field col l2 m2 s4 offset-l5 offset-m5 offset-s4'>
                        <input " . ($row['sex'] == 'M' ? "checked='true'" : "") . " class='txtSex_M with-gap' id='txtSex_M' type='radio' name='txtSex' value='M'>
                        <label for='txtSex_M'>Masculino</label>
                    </div>
                </form>";
            }

            $frm .= "<div class='col s12 row btn_cont'>
                    <button class='col l3 m3 s8 offset-l3 offset-m3 offset-s2 btn waves-effect waves-light red btnCancel_User'>Cancelar
                        <i class='material-icons right'>cancel</i>
                    </button>
                    <br class='hide-on-large-only'>
                    <button class='col l3 m3 s8 offset-l1 offset-m1 offset-s2 btn waves-effect waves-light " . ($_SESSION['type'] == 'C' ? 'black' : ($_SESSION['type'] == 'T' ? 'green darken-2' : 'blue darken-2')) . " btnSave_User'>Guardar Datos
                        <i class='material-icons right'>save</i>
                    </button>
                </div>
            </div>";

            return $frm;
        }

        function getSection($lvl)
        {   
            $aux = "";
            $query = "SELECT * FROM section sn INNER JOIN specialty sy ON sy.idSpecialty = sn.idSpecialty WHERE sn.idLevel = $lvl;";
            
            $res = $this->connection->connection->query($query);
            while ($row = $res->fetch_assoc()) {
                $aux .= "<option value='" . $row['idSection'] . "'>" . $row['sName'] . ", " . $row['sectionIdentifier'] . "</option>";
            }

            return $aux;
        }

        function upload_Tmp_Img($id, $file)
        {   
            if (isset($file['tmp_name'])) {
                $imgType = explode('/', $file['type'])[1];
                $route = "../../files/profile_photos/tmp/$id.$imgType";
                $imgRoute = "../../files/profile_photos/tmp/$id.$imgType";

                return (move_uploaded_file($file['tmp_name'], $route) ? $imgRoute : 0);
            }else{
                return 0;
            }
        }

        function upload_Img($id, $imgName)
        {
            $dirFiles = scandir('../../files/profile_photos');
            foreach ($dirFiles as $key => $value) {
                if ( strpos($value, $id) !== false ) $oldName = $value;
            }

            unlink("../../files/profile_photos/$oldName");
            $route = "../../files/profile_photos/tmp/$imgName";

            if (copy($route, "../../files/profile_photos/$imgName")) {
                if (unlink($route)) {
                    if ( $id[0] == 'C' ) {
                        $table='coordinator'; $idLog='idCoor';
                    }elseif ( $id[0] == 'D' ) {
                        $table='teacher'; $idLog='idTeacher';
                    }else{
                        $table='student'; $idLog='idStudent';
                    }
                    $query = "UPDATE $table SET photo = '" . $imgName . "' WHERE $idLog = '" . $id . "'";
                    if ($this->connection->connection->query($query)) {
                        return 1;
                    }else{
                        return 0;
                    }
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }

        function insert_Mod($data_obj)
        {
            $fields = "";
            $query = "
            UPDATE " . $data_obj['table'] . "
            SET ";

            foreach ($data_obj as $key => $value) {
                $cond = $value != '' && $key != 'idLog' && $key != 'id' && $key !='type' && $key != 'table' && $key != 'idLevel';
                if ($cond) {
                    $fields .= "$key = '" . ($key == 'password' ? $this->ArmedEncryption($value) : $value) . "', ";
                }
            }
            for ($i=0; $i < strlen($fields) - 2; $i++) { 
                $query .= $fields[$i];
            }
            $query .=  "\nWHERE " . $data_obj['idLog'] . " = '" . $data_obj['id'] . "';";
            // return $query;
            $res = $this->connection->connection->query($query);
            return ( $res ? 1 : 0 );
        }
    }

?>
