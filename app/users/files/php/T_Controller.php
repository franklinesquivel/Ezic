<?php
    require_once("../../../../General_Files/php/classes/Schedule.php");
    require_once("../../../../General_Files/php/classes/Assistance_Class.php");
    require_once("../../../../General_Files/php/classes/Code_Class.php");
    require_once("../../../../General_Files/php/classes/Administration.php");
    require_once("../../../../General_Files/php/classes/Grade_Class.php");
    require_once("../../../../General_Files/php/classes/Profile_Class.php");
    require_once("../../../../General_Files/php/classes/Student_Class.php");
    require_once("../../../../General_Files/php/classes/Email_Class.php");
    require_once("../../../../General_Files/php/classes/Period.php");
    require_once("../../../../General_Files/php/classes/Permission_Grade.php");
    require_once("../../../../General_Files/php/classes/Section_Class.php");

    $schedule = new Schedule();
    $assistance = new Assistance();
    $admin = new Administration();
    $code = new Code();
    $grade = new Grade();
    $profile = new Profile();
    $student = new Student();
    $email = new Email();
    $period = new Period();
    $permission_grade = new Permission_Grade();
    $section = new Section();

    if (isset($_REQUEST['loadSchedule'])) {
        if(!isset($_REQUEST)){
            session_start();
        }
        echo $schedule->loadSchedule('T', $_SESSION['id']);
    }

    if (isset($_REQUEST['getListAssistance'])) {
    	echo $assistance->getSecheduleAssistance($_REQUEST['hour'], $_REQUEST['date']);
    }

    if (isset($_REQUEST['new_assistance'])) {
        $object = json_decode($_REQUEST['students']);
        $z = 0;
        for ($i=0; $i < count($object) ; $i++) { 
            if($assistance->insertAssistance($object[$i]->idStudent, $object[$i]->attended, $_REQUEST['date'], $_REQUEST['idSchedule'], 1)){
                $z++;
            }
        }
        echo ($z = ($z == count($object) ? 1 : 0));
    }

    if (isset($_REQUEST['getCodeOptions'])) {
        $codesObj = [];
        $codesObj[0] = $code->getCodeCategories();
        $codesObj[1] = $code->getCodeTypes();
        $codesObj[2] = $code->getCodes("", "");

        echo json_encode($codesObj);
    }

    if (isset($_REQUEST['getCodes'])) {
        echo $code->getCodes($_REQUEST['cat'], $_REQUEST['type']);
    }

    if (isset($_REQUEST['applyCode'])) {
        if(!isset($_SESSION)){
            session_start();
        }
        echo $code->applyCode($_REQUEST['idCode'], $_REQUEST['idStudent'], $_SESSION['id'], $_SESSION['type']);
    }

    if (isset($_REQUEST['getViewAddGrade'])) {
        echo($grade->v_addGrade());
    }

    if (isset($_REQUEST['getProfiles'])) {
        $period = $grade->getPeriod();
        echo ($grade->getProfiles($profile->getProfiles($_REQUEST['subject'], $period[0][0]), $student->getStudents($_REQUEST['section'])));
    }

    if (isset($_REQUEST['getListStudents'])) {
        echo ($grade->list_students($_REQUEST['section']));
    }

    if (isset($_REQUEST['SaveGrades'])) {
        $grades = json_decode($_REQUEST['grades']);
        $z = 0;
        for ($i=0; $i < count($grades) ; $i++) {
            if ($grade->InsertGrades($grades[$i]->idStudent, $grades[$i]->Grade, $_REQUEST['profile'], $_REQUEST['subject'],  0)) {
               $z++;
            }
        }
        echo ($z = ($z > 0) ? 1 : 0);
    }

    if (isset($_REQUEST['v_justification'])) {
       echo ($profile->v_Justification());
    }

    if (isset($_REQUEST['table_Justification'])) {
        echo ($profile->tableSubject_Justification($_REQUEST['period']));
    }

    if (isset($_REQUEST['getProfiles_Justification'])) {
        echo ($profile->getForJustification($_REQUEST['subject']));
    }

    if (isset($_REQUEST['InsertJustification'])) {
        $object = json_decode($_REQUEST['object']);
        $z = 0;
        for ($i=0; $i < count($object); $i++) { 
            if ($profile->InsertJustification($object[$i]->id, $object[$i]->description)) {
                $z++;
            }
        }
        echo ($z = ($z == count($object)) ? 1 : 0);
    }

    if(isset($_REQUEST['v_permissionTeacher'])){
        echo($permission_grade->v_permissionTeacher());
    }

    if (isset($_REQUEST['getStudents_Permission'])) {
        echo ($student->v_permission($_REQUEST['subject'], $_REQUEST['section']));
    }

    if(isset($_REQUEST['getFormEmail'])){ /* Solicita el formulario para enviar el correo */
        echo ($email->FormEmailTeacher($period->getPeriods()));
    }

    if(isset($_REQUEST['getProfiles_Permission'])){
        echo ($profile->getProfiles($_REQUEST['subject'], $_REQUEST['period']));
    }

    if(isset($_REQUEST['register_permission'])){ /* Ingresa Todo del envío del email */
        $object = json_decode($_REQUEST['students']);
        $z = 0;

        for($i = 0; $i < count($object); $i++){/* Se verifica la existencia de los permisos según los datos */
            if(($permission_grade->verifyPermission($object[$i]->id, $_REQUEST['profiles'])) == false){$z++;}
        }

        if($z > 0){ /* Si existe algún registro similar*/
            echo "0";
        }else{
            $students = $email->listStudents($object);
            $profiles = $email->listProfiles($_REQUEST['profiles']);
            if($permission_grade->InsertPermission($_REQUEST['students'], $_REQUEST['justification'], $_REQUEST['profiles'])){
                echo($email->SendEmail_FromTeacher($students, $_REQUEST['justification'], json_decode($period->selectPeriod($_REQUEST['period'])), $_REQUEST['subject'],  $profiles));
            }
        }
    }

    if(isset($_REQUEST['getSection'])){/* Función que carga las secciones en request_permission.php */
        echo($section->getAllForSubject($_REQUEST['subject']));
    }

    if(isset($_REQUEST['modify_grade'])){/* Se obtiene la vista para modificar notas */
        echo($grade->v_modifyGrade());
    }

    if(isset($_REQUEST['getInfoPermission'])){/* Se obtienen los perfiles a modificar */
        echo($grade->getGradesModification($_REQUEST['idPermission']));
    }

    if(isset($_REQUEST['listStudentModification'])){/* Lista de estudiantes a modificar */
        echo($grade->Students_Modification($_REQUEST['idPermission'], $_REQUEST['idProfile']));
    }

    if(isset($_REQUEST['updateGrades'])){ /* Ingresa las nuevas notas (Modificadas) */
        $z = 0;
        $object = json_decode($_REQUEST['json_students']);
        for($i = 0; $i < count($object); $i++){
            if(($grade->UpdateGrade($_REQUEST['idProfile'], $_REQUEST['idPermission'], $object[$i]->idStudent, $object[$i]->Grade)) == 1){
                $z++;
            }
        }
        echo ($z = ($z > 0) ? 1 : 0);
    }

    if (isset($_POST['teacher_getStudents'])) {
        if (!isset($_SESSION)) {
            session_start();
        }

        echo $section->getStudensSection($_SESSION['id']);
    }

    if (isset($_POST['listSection'])) {
        echo $section->showSection($_POST['idSection']);
    }

    if (isset($_POST['studentGrades'])) {
        echo json_encode($grade->getGrades($_POST['idStudent']));
    }

    if (isset($_POST['showUser'])) {
        echo $admin->showUser($admin->get_user_data($_POST['idStudent']));
    }

    if (isset($_POST['record'])) {
        echo $admin->conductRecord($_POST['idStudent']);
    }

    if (isset($_POST['getMandated'])) {
        echo $admin->getMandated($_POST['id']);
    }
?>
