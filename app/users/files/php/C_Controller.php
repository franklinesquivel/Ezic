<?php

//-------------------------------------------------------------------------------------------
//CLASES REQUERIDAS HASTA EZIC 1.5
	require_once("../../../../General_Files/php/classes/Period.php");
	require_once("../../../../General_Files/php/classes/Modify.php");
	require_once("../../../../General_Files/php/classes/Profile_Class.php");
	require_once("../../../../General_Files/php/classes/Schedule.php");
	require_once("../../../../General_Files/php/classes/Section_Class.php");
	require_once("../../../../General_Files/php/classes/Subject_Class.php");
	require_once("../../../../General_Files/php/classes/Grade_Class.php");
//FIN DE CLASES REQUERIDAS HASTA EZIC 1.5
//--------------------------------------------------------------------------------------------

//-------------------------------------------------------------------------------------------
//CLASES REQUERIDAS HASTA EZIC 1.8
	require_once("../../../../General_Files/php/classes/Teacher_Class.php");
	require_once("../../../../General_Files/php/classes/Administration.php");
	require_once("../../../../General_Files/php/classes/Code_Class.php");
	require_once("../../../../General_Files/php/classes/Permission_Class.php");
	require_once("../../../../General_Files/php/classes/Justification_Class.php");
//FIN DE CLASES REQUERIDAS HASTA EZIC 1.8
//--------------------------------------------------------------------------------------------

	require_once '../../../../General_Files/php/classes/Stadistics.php';

//--------------------------------------------------------------------------------------------
//CLASES INSTANCIADAS HASTA EZIC 1.5
	$period = new Period();
	$modify = new Modify();
	$profile = new Profile();
	$schedule = new Schedule();
	$section = new Section();
	$subject = new Subject();
	$grade = new Grade();
//FIN DE CLASES INTANCIADAS HASTA EZIC 1.5	
//--------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------
//CLASES INSTANCIADAS HASTA EZIC 1.8
	$teacher = new Teacher();
	$admin = new Administration();
	$code = new Code();
	$permission = new Permission();
	$justification = new Justification();
//FIN DE CLASES INTANCIADAS HASTA EZIC 1.8	
//--------------------------------------------------------------------------------------------

	$stadistic = new Stadistics();

//--------------------------------------------------------------------------------------------
//		AGREGAR NUEVO PERIODO
	if(isset($_REQUEST['periodNew'])){
		$a = 0;//Variable que nos traera lo máximo a agregar al período en caso de que el valor sea mayor
		if ($period->countPercentage(floatval($_REQUEST['percentage']), $a)) {
			if ($period->compareDate($_REQUEST['startDate'], $_REQUEST['endDate'])) {
				if($period->NewPeriod($_REQUEST['startDate'], $_REQUEST['endDate'], floatval($_REQUEST['percentage']))){
					echo ('-2');
				}
			}else{
				echo "-1";
			}
		}else{
			echo "$a";
		}
	}
// FIN AGREGAR PERIODO
//--------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------
//		MODIFICACIÓN DE USUARIO

	if (isset($_REQUEST['newSearch'])) {
		$search = $_REQUEST['search'] . '';
		$string = '';

		if ($search[0] == 'C') {
			$type = 'C'; $idLog = 'idCoor'; $table = 'coordinator';
		}elseif ($search[0] == 'D') {
			$type = 'T'; $idLog = 'idTeacher'; $table = 'teacher';
		}else{
			$type = 'S'; $idLog = 'idStudent'; $table = 'student';
		}

		if ($array = $modify->search($type, $idLog, $table, $search) ) {
			$aux = '';

			for ($i=0; $i < count($array) ; $i++) {
				$aux = $aux . $array[$i];
			}

			echo $aux;
		}else{
			echo 0;
		}
	}

	if (isset($_REQUEST['newForm'])) {
		session_start();
		$id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : $_SESSION['id']);
		echo $modify->load_Form($id);
	}

	if (isset($_FILES['file'])) {
		echo $modify->upload_Tmp_Img($_POST['id'], $_FILES['file']);
	}

	if(isset($_REQUEST['uploadImg'])){
		echo $modify->upload_Img($_REQUEST['idUser'], $_REQUEST['imgName']);
	}

	if ( isset($_REQUEST['sendModification']) ) {
		$data_obj = json_decode($_REQUEST['user_info'], true);
		echo $modify->insert_Mod($data_obj);
	}
// FIN MODIFICACIÓN DE USUARIO
//--------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------
//		AGREGAR PERFIL DE EVALUACION
	if (isset($_REQUEST['newProfile'])){
		$id_subject = json_decode($_REQUEST['subject']);
		$z = 0;
		$y = 0;
		$subject = array();

		for ($i=0; $i < count($id_subject) ; $i++) { 
			if ($profile->countPercentage($_REQUEST['percentage'], $_REQUEST['period'],  $id_subject[$i]->id)) {
				// $profile->NewProfile($_REQUEST['name'], $_REQUEST['percentage'], $_REQUEST['period'], $id_subject[$i]->id);
				$y++;
			}else{

				$subject[$z] = [
					"id" => $id_subject[$i]->id
				];

				$z++;
			}
		}

		if ($z > 0) {
			echo (json_encode($subject));
		}else{
			for ($i=0; $i < count($id_subject) ; $i++) { 
				$profile->NewProfile($_REQUEST['name'], $_REQUEST['percentage'], $_REQUEST['period'], $id_subject[$i]->id);
			}
			echo "1";
		}
	}
// FIN AGREGAR PERFIL DE EVALUACION
//--------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------
//		ASIGNACIÓN DE HORARIOS
	if (isset($_REQUEST['fillTeachers_Add'])) {
		echo $schedule->getTeachers(1);
	}

	if (isset($_REQUEST['newTSchedule'])) {
		echo $schedule->buildSchedule($_REQUEST['id']);
	}

	if (isset($_REQUEST['saveData'])) {
		$data_obj = json_decode($_REQUEST['scheduleInfo'], true);
		echo $schedule->saveNewSchedule($data_obj);
	}
// FIN ASIGNACIÓN DE HORARIOS
//--------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------
//		MODIFICACIÓN DE HORARIOS
	if (isset($_REQUEST['fillTeachers_Edit'])) {
		echo $schedule->getTeachers(0);
	}

	if (isset($_REQUEST['editTSchedule'])) {
		echo $schedule->loadTeacherSchedule($_REQUEST['id']);
	}

	if (isset($_REQUEST['updateData'])) {
		$data_obj = json_decode($_REQUEST['scheduleInfo'], true);
		echo $schedule->updateScheduleData($data_obj);
	}

	if (isset($_REQUEST['deleteData'])) {
		$data_obj = json_decode($_REQUEST['scheduleInfo'], true);
		echo $schedule->deleteScheduleData($data_obj);
	}

	if (isset($_REQUEST['addData'])) {
		$data_obj = json_decode($_REQUEST['scheduleInfo'], true);
		echo $schedule->addScheduleData($data_obj);
	}
// FIN MODIFICACIÓN DE HORARIOS
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		ELIMINACIÓN DE HORARIOS
	if (isset($_REQUEST['deleteSchedule'])) {
		echo $schedule->deleteSchedule($_REQUEST['id']);
	}
// FIN ELIMINACIÓN DE HORARIOS
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		TOMAR SECCIONES - SIMPLE - TODAS LAS SECCIONES
	if (isset($_REQUEST['getSections'])) {
		$sections = $section->getSections($_REQUEST['level']);
		echo $sections;
	}
// FIN TOMAR SECCIONES - SIMPLES - TODAS LAS SECCIONES
//--------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------
//		AGREGAR NUEVA MATERIA
	if (isset($_REQUEST['newSubject'])) {
		$sections = $_REQUEST['sections'];
		$z = 0;
		
		if ($subject->verifySubject($_REQUEST['name'], $_REQUEST['teacher'], $_REQUEST['level'])) {
			$idSubject = $subject->newSubject($_REQUEST['name'], $_REQUEST['teacher'], $_REQUEST['acronym'], $_REQUEST['description']);
			for ($i=0; $i <count($sections) ; $i++) { 
				$subject->register_subject($idSubject, $sections[$i]);//Llenamos la tabla que contiene la sección
				$z++;
			}
		}else{
			echo "0";
		}
		
		if ($z == count($sections)) {
			echo "1";	
		}
	}
// FIN AGREGAR NUEVA MATERIA
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		ELEGIR PERFIL PARA MODIFICAR
	if (isset($_REQUEST['chose_modifyProfile'])) {
		echo ($listSubject = $profile->getProfiles($_REQUEST['subject'], $_REQUEST['period']));
	}
// FIN ELEGIR PERFIL PARA MODIFICAR
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		MODIFICACIÓN DE PERFILES DE EVALUACION
	if (isset($_REQUEST['modifyProfile'])) {
		$object = json_decode($_REQUEST['objectProfiles']);
		$z = 0;
		for ($i=0; $i < count($object); $i++) { 
			if ($profile->modifyProfile($object[$i]->id, $object[$i]->name, $object[$i]->percentage, $object[$i]->description)) {
				$z++;
			}
		}
		echo ($z = ($z > 0) ? 1 : 0);
	}
// FIN MODIFICACIÓN DE PERFILES DE EVALUACION
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		ELEGIR PERIODO PARA MODIFICAR
	if (isset($_REQUEST['choose_modifyPeriod'])) {
		echo ($period->selectPeriod($_REQUEST['period']));
	}
// FIN ELEGIR PERIODO PARA MODIFICAR
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		MODIFICAR PERIODO
	if (isset($_REQUEST['modifyPeriod'])) {
		$a = 0;
		if ($period->countPercentageOfPeriod($_REQUEST['idPeriod'], $_REQUEST['percentage'], $a)) {
			if ($period->compareDateOfPeriod($_REQUEST['idPeriod'], $_REQUEST['startDate'], $_REQUEST['endDate'])) {
				if($period->modifyPeriod($_REQUEST['idPeriod'], $_REQUEST['startDate'], $_REQUEST['endDate'], $_REQUEST['percentage'])){
					echo "-1";
				}
			}else{
				echo "-2";
			}
		}else{
			echo "$a";
		}
	}
// FIN MODIFICAR PERIODO
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		ELEGIR PERIODO PARA ELIMINAR
	if (isset($_REQUEST['choose_deleteProfile'])) {
		echo ($profile->getProfilesForDelete($_REQUEST['subject'], $_REQUEST['period']));
	}
// FIN ELEGIR PERIODO PARA ELIMINAR
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		ELIMINAR PROFILE
	if (isset($_REQUEST['delete_profile'])) {
		$idProfiles = json_decode($_REQUEST['profiles']);
		$z = 0;

		for ($i=0; $i <count($idProfiles) ; $i++) { 
			$grade->deleteAsProfile($idProfiles[$i]->id);		
		}

		for ($x=0; $x < count($idProfiles); $x++) { 
			$profile->delete($idProfiles[$x]->id);
			$z++;
		}

		echo ($z = ($z > 0) ? 1 : 0);
	}
// FIN ELIMINAR PROFILE
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		REEMPLAZAR TEACHER - MATERIA
	if (isset($_REQUEST['replace_teacher'])) {
		if ($subject->replaceTeacher($_REQUEST['subject'], $_REQUEST['newTeacher'])) {
			echo "1";
		}else{
			echo "0";
		}
	}
// FIN REEMPLAZAR TEACHER - MATERIA
//--------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------
//		OBTENER SECCIONES SEGÚN UNA MATERIA INSCRITA
	if (isset($_REQUEST['assignSubject'])) {
		$sections = $section->getForSubject($_REQUEST['subject']);
		echo $sections;
	}
// FIN OBTENER SECCIONES SEGÚN UNA MATERIA INSCRITA
//--------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------
//		ASIGNAR MATERIA A SECCIÓN
	if (isset($_REQUEST['assign_SubjectSection'])) {
		echo ($subject->register_subject($_REQUEST['subject'], $_REQUEST['sections']));
	}
// FIN ASIGNAR MATERIA A SECCIÓN
//--------------------------------------------------------------------------------------

//**************************************************************************************
//*********************************** FIN DE EZIC 1.5 **********************************
//**************************************************************************************

//---------------------------------------------------------------------------------------
//		ELIMINAR MATERIAS
	if (isset($_REQUEST['delete_subject'])) {
		$idSubject = json_decode($_REQUEST['subjects']);
		$z = 0;
		for ($i=0; $i < count($idSubject); $i++) { 
			if ($subject->delete($idSubject[$i]->id)) {
				$z++;
			}
		}
		echo ($z = ($z > 0) ? 1 : 0);
	}
// FIN ELIMINAR MATERIAS
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		VER PERFILES DE EVALUACIÓN
	if (isset($_REQUEST['profile_view'])) {
		$profiles = $profile->getProfilesForView($_REQUEST['subject']);
		echo "$profiles";
	}
// FIN VER PERFILES DE EVALUACIÓN
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		VISTA DE ELIMINAR MATERIA
	if (isset($_REQUEST['view_deleteSubject'])) {
		$vista = $subject->v_deleteSubject();
		echo $vista;
	}
// FIN VISTA DE ELIMINAR MATERIA
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		OBTENCIÓN DE PROFESORES
	if(isset($_REQUEST['getTeacherForChangeSubject'])){
		echo $list_teachers = $teacher->getTeacherForChange($_REQUEST['subject']);
	}
// FIN OBTENCIÓN DE PROFESORES
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		OBTENCIÓN DE FORMULARIO PARA CREAR CÓDIGO
	if (isset($_REQUEST['view_addCode'])) {
		echo ($code->v_addCode());
	}
// FIN OBTENCIÓN DE FORMULARIO PARA CREAR CÓDIGO
//--------------------------------------------------------------------------------------	

//--------------------------------------------------------------------------------------
//		REGISTRANDO NUEVO CÓDIGO
	if (isset($_REQUEST['add_code'])) {
		if ($code->verifyCode($_REQUEST['description'], $_REQUEST['type'], $_REQUEST['category'])) {
			if ($code->newCode($_REQUEST['description'], $_REQUEST['type'], $_REQUEST['category'])) {
				echo "1";
			}
		}else{
			echo "0";
		}
	}

// FIN REGISTRANDO NUEVO CÓDIGO
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		SE OBTIENE MATERIA POR PROFESOR
	if (isset($_REQUEST['choose_subjectForTeacher'])) {
		echo $subject->getForTeacher($_REQUEST['teacher']);
	}
// FIN DE OBTIENE MATERIA POR PROFESOR
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		SE OBTIENE VISTA DE MODIFICAR CODIGO
	if (isset($_REQUEST['v_modifyCode'])) {
		echo $code->v_modifyCode();
	}
// FIN DE SE OBTIENE VISTA DE MODIFICAR CODIGO
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		OBTENCIÓN DE CÓDIGOS PARA MODIFICAR
	if (isset($_REQUEST['getCodeForModify'])) {
		echo $code->getForModify($_REQUEST['category'],
			$_REQUEST['type']);
	}
// FIN DE OBTENCIÓN DE CÓDIGOS PARA MODIFICAR
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		MODIFICACIÓN DE CODIGO
	if (isset($_REQUEST['modifyCode'])) {
		$z = array();
		$x = 0;
		$insert = 0;
		$object = json_decode($_REQUEST['object']);

		for ($i=0; $i < count($object); $i++) { 
		
			if($code->verifyCode_ForModify($object[$i]->description, $object[$i]->type, $object[$i]->category, $object[$i]->id)){
				$z[$x] = [
					"id"=> $object[$i]->id
				];
				$x++;
			}
		}

		if ($x == 0) {// Se realizan los insert
			for ($i=0; $i < count($object); $i++) { 
				if ($code->modifyCode($object[$i]->id, $object[$i]->description, $object[$i]->type, $object[$i]->category)) {
					$insert++;
				}
			}
			echo "S";
		}else{
			echo (json_encode($z));
		}
	}
// FIN DE MODIFICACIÓN DE CODIGO
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		OBTENCIÓN DE LA VISTA PARA ELIMINAR CÓDIGOS
	if (isset($_REQUEST['v_deleteCode'])) {
		echo ($code->v_delete());
	}
// FIN DE OBTENCIÓN DE LA VISTA PARA ELIMINAR CÓDIGOS
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		OBTENCIÓN DE CÓDIGOS POR CATEGORÍA - ELIMINAR CÓDIGO
	if (isset($_REQUEST['getCodeForCategory'])) {
		echo ($code->getForDelete($_REQUEST['category']));
	}
// FIN OBTENCIÓN DE CÓDIGOS POR CATEGORÍA - ELIMINAR CÓDIGO
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		ELIMINAR CÓDIGO
	if (isset($_REQUEST['delete_code'])) {
		$object = json_decode($_REQUEST['code']);
		$z = 0;
		for ($i=0; $i < count($object); $i++) { 
			if ($code->delete($object[$i]->id)) {
				$z++;
			}
		}
		echo ($z = ($z == count($object)) ? "1" : "0");
	}
// FIN ELIMINAR CÓDIGO
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		VER CÓDIGO
	if (isset($_REQUEST['v_Code'])) {
		echo ($code->v_code());
	}
// FIN VER CÓDIGO
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		VER CÓDIGO TABLE
	if (isset($_REQUEST['v_Code_select'])) {
		echo ($code->v_tableCodes($_REQUEST['category']));
	}
// FIN VER CÓDIGO TABLE
//--------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------
//		VISTA DE CREAR PERMISO
	if (isset($_REQUEST['v_permmission'])) {
		echo ($permission->v_make_permission($_REQUEST['student']));
	}
// FIN VISTA DE CREAR PERMISO
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		OBTENER HORARIO DE PERMISO
	if (isset($_REQUEST['getSchedulePermission'])) {
		echo ($permission->getSchedule($_REQUEST['student'], $_REQUEST['day']));
	}
// FIN DE HORARIO DE PERMISO
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		REGISTRANDO PERMISOS
	if (isset($_REQUEST['newPermission'])) {
		$object = json_decode($_REQUEST['permission']);
		$z = 0;
		for ($i=0; $i <count($object) ; $i++) { 
			if($permission->newPermission($_REQUEST['student'], $_REQUEST['justification'], $object[$i]->id, $_REQUEST['date'])){
				$z++;
			}
		}	
		echo ($z = ($z == count($object) ? "1" : "0"));
	}
// FIN REGISTRANDO PERMISOS
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		OBTENER VISTA DE JUSTIFICACIÓN DE FALTA
	if (isset($_REQUEST['v_justification'])) {
		echo ($justification->v_justificationP($period->getPeriods(), $_REQUEST['student']));
	}
// FIN OBTENER VISTA DE JUSTIFICACIÓN DE FALTA
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		TABLA DE INASISTENCIAS
	if (isset($_REQUEST['get_assistance'])) {
		echo ($justification->getTableAssistance($period->selectPeriod($_REQUEST['period']), $_REQUEST['student']));
	}
// FIN TABLA DE INASISTENCIAS
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		REGISTRAR JUSTIFICACIÓN
	if (isset($_REQUEST['newJustification'])) {
		$object = json_decode($_REQUEST['id_justification']);
		$z = 0;
		for ($i=0; $i <count($object) ; $i++) { 
			if($justification->newJustification($object[$i]->id, $_REQUEST['justification'])){
				$z++;
			}
		}	
		echo ($z = ($z == count($object) ? "1" : "0"));
	}
// FIN REGISTRAR JUSTIFICACIÓN
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		VISTA AGREGAR PERFIL
	if (isset($_REQUEST['v_AddProfile'])) {
		echo ($profile->v_AddPeriod($period->getPeriods()));
	}
// FIN VISTA AGREGAR PERFIL
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		OBTENER TABLA - AGREGAR PERFIL
	if (isset($_REQUEST['getTableProfile_add'])) {
		echo ($profile->v_tableAdd($_REQUEST['period']));
	}
// FIN VISTA OBTENER TABLA - AGREGAR PERFIL
//--------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------
//		FORMULARIO INICIAL PARA MODIFICAR UN PERFIL DE EVALUACIÓN
	if (isset($_REQUEST['v_modifyProfile'])) {
		echo ($profile->v_modifyProfile($teacher->getTeachers(), $period->getPeriods()));
	}
// FIN FORMULARIO INICIAL PARA MODIFICAR UN PERFIL DE EVALUACIÓN
//--------------------------------------------------------------------------------------
	
	if (isset($_REQUEST['getUsers'])) {
		echo json_encode($admin->sendUsers());
	}

	if (isset($_REQUEST['record'])) {
		echo $admin->conductRecord($_REQUEST['id']);
	}

	if (isset($_REQUEST['showUser'])) {
		echo $admin->showUser(json_decode($_REQUEST['user_obj']));
	}

	if (isset($_REQUEST['showSchedule'])) {
		echo $schedule->loadSchedule($_REQUEST['type'], $_REQUEST['id']);
	}

	if (isset($_REQUEST['getLvls'])) {
		echo $admin->getLvls();
	}

	if (isset($_REQUEST['getSpecialties'])) {
		echo $admin->getSpecialties($_REQUEST['lvl']);
	}

	if (isset($_REQUEST['returSections'])) {
		echo $admin->getSections($_REQUEST['specialty']);
	}

	if (isset($_REQUEST['showSubjects'])) {
		echo $admin->getSubjects($_REQUEST['id']);
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

	if (isset($_REQUEST['showTeacher'])) {
		echo $admin->showUser($admin->get_user_data($_REQUEST['id']));
	}

	if (isset($_REQUEST['showGrades'])) {
		session_start();
		echo json_encode($grade->getGrades($_REQUEST['id']));
	}

	if (isset($_REQUEST['getStudentCodes'])) {
		echo $admin->getStudentCodes($_REQUEST['id']);
	}

	if (isset($_REQUEST['rmvCodes'])) {
		echo $admin->removeCode($_REQUEST['ids']);
	}

	if (isset($_REQUEST['totalUsers'])) {
		echo json_encode($stadistic->countUsers());
	}

	if (isset($_REQUEST['filterSections'])) {
		echo $section->filterSections($_REQUEST['lvl'], $_REQUEST['spcty'], $_REQUEST['sctn']);
	}
?>
