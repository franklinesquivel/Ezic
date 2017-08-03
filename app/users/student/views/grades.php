<?php
    require_once("../../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('S');
    $userRow = $const->getData('S');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ezic: Estudiante.</title>

    <link rel="shortcut icon" type="image/png" href="../../../../General_Files/img/ezic.png"/>
    <link rel="stylesheet" href="../../../../General_Files/materialize/css/materialize.css">
    <link rel="stylesheet" href="../../files/css/view_style.css">
    <link rel="stylesheet" href="../../files/css/s/style.css">

    <meta name="theme-color" content="#005ab4">
    <meta name="msapplication-navbutton-color" content="#005ab4">
    <meta name="apple-mobile-web-app-status-bar-style" content="#005ab4">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="../../../../General_Files/js/jquery.js" charset="utf-8"></script>
    <script src="../../../../General_Files/js/validate.js" charset="utf-8"></script>
    <script src="../../../../General_Files/materialize/js/materialize.js" charset="utf-8"></script>

    <script src="../../files/js/init.js" charset="utf-8"></script>
    <script src="../../files/js/Loader.js" charset="utf-8"></script>
    <script src="../../files/js/s/loadGrades.js" charset="utf-8"></script>
</head>
<body>

    <header>
        <?php 
            echo($const->getSchedule());
        ?> 
        <nav class="top-nav blue darken-2">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Notas</a></div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <ul id="user_nav" class="side-nav fixed">
            <li>
                <div class="userView">
                    <div class="background">
                        <img src="../../files/img/student.jpg" width="100%">
                    </div>
                    <img class="circle" src="../../files/profile_photos/<?php echo $userRow['photo']; ?>">
                    <span class="white-text name"><?php echo explode(' ', $userRow['name'])[0] . " " . explode(' ', $userRow['lastName'])[0]; ?></span>
                    <span class="white-text email">Estudiante</span>
                </div>
            </li>
            <li><a href="../" class="waves-effect">Inicio<i class="material-icons">home</i></a></li>
            <li class="active"><a href="../views/grades.php" class="waves-effect">Ver Notas<i class="material-icons">grades</i></a></li>
            <li><a href="../views/record.php" class="waves-effect">Récord conductual<i class="material-icons">favorite</i></a></li>
            <li><a href="../views/schedule.php" class="waves-effect">Ver horario<i class="material-icons">schedule</i></a></li>
            <li><a class="subheader">Cuenta</a></li>
            <li><a href="#!" class="waves-effect">Configuración<i class="material-icons">settings</i></a></li>
            <li><div class="divider"></div></li>
            <li><a class="waves-effect btnUnlog"><i class="material-icons">cancel</i>Cerrar Sesión</a></li>
        </ul>
    </header>

    <main class="show">
        <div class="row">
            <div class="input-field col l4 m4 s10 offset-s1 offset-l4 offset-m4">
                <select name="" id="cmbPeriod">
                    <option disabled>Seleciona un período</option>
                </select>
            </div>
        </div>
        <div class="container gradesCont">
            <!-- <div class='grade-wrapper'>
                <div class='grade-header blue darken-2 white-text'>
                    <div class='subject'>Materia: <span class='content'>Estudios Sociales y Cívica (SOC)</span></div>
                    <div class='teacher'>Profesor: <span class='content'>Franklin Armando Esquivel Guevara</span></div>
                </div>
                <table class='centered'>
                    <thead class='blue darken-2'>
                    <tr>
                        <th>N°</th>
                        <th>Perfil de Evaluación</th>
                        <th>Porcentaje</th>
                        <th>Nota</th>               
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Prueba Objetiva</td>
                            <td>20%</td>
                            <td>8.50</td>
                        </tr>
                    </tbody>
                </table>
            </div> -->
        </div>
    </main>

    <form action='../../../../General_Files/php/classes/Print.php' method="POST" target="_blank" id="print"> 
        <input type="hidden" name="printGrades" value="1">
        <input type="hidden" name="id" value="<?php echo $userRow['idStudent'] ?>">
    </form>

    <div class="fixed-action-btn vertical">
        <a class="btn-floating btn-large blue darken-2" id="info">
            <i class="large material-icons">menu</i>
        </a>
        <ul>
            <li title="Descargar"><a class="btn-floating blue lighten-2 btnPrint"><i class="material-icons">file_download</i></a></li>
            <li title="Información"><a class="btn-floating amber btnInfo"><i class="material-icons">info_outline</i></a></li>
        </ul>
    </div>
    
    <div class="tap-target blue darken-2" data-activates="info">
        <div class="tap-target-content white-text">
            <h5>Acerca de este apartado:</h5>
            <p class="white-text"></p>
        </div>
    </div>
</body>
</html>
