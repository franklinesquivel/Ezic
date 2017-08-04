<?php
    require_once("../../../../General_Files/php/classes/Schedule.php");
    require_once("../../../../General_Files/php/classes/Assistance_Class.php");
    require_once("../../../../General_Files/php/classes/Code_Class.php");
    require_once("../../../../General_Files/php/classes/Administration.php");
    require_once("../../../../General_Files/php/classes/Grade_Class.php");
    require_once("../../../../General_Files/php/classes/Profile_Class.php");
    require_once("../../../../General_Files/php/classes/Student_Class.php");

    $schedule = new Schedule();
    $assistance = new Assistance();
    $admin = new Administration();
    $code = new Code();
    $grade = new Grade();
    $profile = new Profile();
    $student = new Student();

    if (isset($_REQUEST['loadSchedule'])) {
        session_start();
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
        session_start();
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
            if ($grade->InsertGrades($grades[$i]->idStudent, $grades[$i]->Grade, $_REQUEST['profile'], $_REQUEST['subject']  )) {
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
?>
