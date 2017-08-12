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
            session_start();
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
    }
?>