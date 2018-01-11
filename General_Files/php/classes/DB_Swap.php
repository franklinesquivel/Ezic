<?php
    class DB_Swap
    {
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
        
        private function getDataBases() //Obtiene una lista de las base de datos en nuestro host
		{
			$res = $this->connection->connection->query("SHOW DATABASES");
			$databases = [];
			$i = 0;
			while($row = $res->fetch_assoc()){
				$databases[$i++] = 
				[
					"value" => $row['Database'],
					"name" => $row['Database'],
				];
			}

			return $databases;
		}

		function v_databases(){ //Carga la vista para que el administrador pueda cambiar la BDD
			$bdd = $this->getDataBases();
			$form = "";
            if(count($bdd) > 1){ //Si encuentra más de una BDD
                if (!isset($_SESSION)) { session_start(); }

                $options = "";
                for($i = 0; $i < count($bdd); $i++){
                    if($bdd[$i]['value'] == $_SESSION['bdd']){
                        $options .= "<option value='".$bdd[$i]['value']."' selected disabled>".$bdd[$i]['name']."</option>";
                    }else{
                        $options .= "<option value='".$bdd[$i]['value']."'>".$bdd[$i]['name']."</option>";
                    }
                }

                $form = 
                "   
                    <div class='row'>
                        <form class='switchBDD'>
                            <div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
                                <select name='selectBDD' id='selectBDD'>
                                    $options
                                </select>
                                <label>Bases de Datos disponibles</label>
                            </div>
                            
                            <div class='col l2 m2 s4 offset-l5 offset-m5 offset-s4 btn waves-effect waves-light black darken-2 btnSave'>Ver
		    	    		    <i class='material-icons right'>send</i>
		    	    	    </div>
                        </form>
                    </div>
                ";
			}else{
                $form = " <div class='alert_ red-text text-darken-4'>No se ha encontrado más Base de Datos que la actual.</div> ";
			}

			return $form;
        }
        
        function setBDD($name){ //Cambia la bdd a utilizar
            if (!isset($_SESSION)) { session_start(); }

            if($this->checkBDD($name)){
                $_SESSION['bdd'] = $name;
                return true;
            }else{
                return false;
            }
        }

        private function checkBDD($name){ //Chequea si el nombre de la bdd a utilizar existe
            $res = $this->connection->connection->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$name'");
			return (($res->num_rows > 0) ? true : false);
        }
    }
?>