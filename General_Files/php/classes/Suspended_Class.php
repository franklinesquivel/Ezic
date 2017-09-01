<?php
    class Suspended{
		
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
        

        function ChangeState(){
            $students = $this->StudentSuspended();
            if($students != false){
                for($i = 0; $i < count($students); $i++){
                    $query = "UPDATE student SET stateAcademic = 'A' WHERE idStudent = '".$students[$i]."'";
                    $result = $this->connection->connection->query($query);
                }
            }
            return true;
        }

        function StudentSuspended(){
            ini_set("date.timezone", 'America/El_Salvador');
            $fecha = date("Y-m-d");
            $fecha = strtotime("+ 1 days", strtotime($fecha));
			$fecha = date("Y-m-d", $fecha);

            $query = "SELECT * FROM suspended WHERE EndDate  = '$fecha'";
            $result = $this->connection->connection->query($query);
            
            if($result->num_rows > 0){
                $students = array();
                $i = 0;
                while($fila = $result->fetch_assoc()){
                    $students[$i] = $fila['idStudent'];
                    $i++;
                }
                return ($students);
            }else{
                return false;
            }
        }

        function v_suspended(){
            $query = "SELECT suspended.idSuspended, suspended.StartDate, suspended.EndDate, student.idStudent, student.name, student.lastName, suspended.state FROM `suspended` INNER JOIN student ON student.idStudent = suspended.idStudent WHERE student.verified = 1";
            $result = $this->connection->connection->query($query);
            $x = 0;
            if($result->num_rows > 0){
                while($fila = $result->fetch_assoc()){
                    $x++;
                    $state = ($fila['state'] == 1) ? 'Activa' : 'Inactiva';
                    $tr = "
                        <tr> 
                            <td>$x</td>
                            <td>".$fila['idStudent']."</td>
                            <td>".$fila['lastName'].", ".$fila['name']."</td>
                            <td>".$fila['StartDate']."</td>
                            <td>".$fila['EndDate']."</td>
                            <td>
                                $state
                            </td>
                        </tr>
                    ";
                }

                $table = "<div class='row'><table class='col s10  offset-l1 suspended bordered centered responsive-table'>
                    <thead>
                        <th>N°</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha Final</th>
                        <th>Estado</th>
                    </thead>
                    <tbpdy>
                        $tr
                    </tbody>
                </table></div>";
            }else{
                $table = "<div class='alert_'><span>No hay suspensiones registradas</span></div>";
            }
            return ($table);
        }
    }
?>