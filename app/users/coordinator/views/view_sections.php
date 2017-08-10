<?php 
	require_once("../../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('C');
    $userRow = $const->getData('C');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#343434">
    <meta name="msapplication-navbutton-color" content="#343434">
    <meta name="apple-mobile-web-app-status-bar-style" content="#343434">
    <title>Ezic: Coodinador.</title>

    <link rel="shortcut icon" type="image/png" href="../../../../General_Files/img/ezic.png"/>
    <link rel="stylesheet" href="../../../../General_Files/materialize/css/materialize.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="../../../../General_Files/js/jquery.js" charset="utf-8"></script>
    <script src="../../../../General_Files/js/validate.js" charset="utf-8"></script>
    <script src="../../../../General_Files/materialize/js/materialize.js" charset="utf-8"></script>

    <link rel="stylesheet" href="../../files/css/view_style.css">
    <link rel="stylesheet" href="../../files/css/c/style.css">

    <script src="../../files/js/init.js" charset="utf-8"></script>
    <script src="../../files/js/Loader.js" charset="utf-8"></script>
    <script src="../../files/js/c/viewSections.js" charset="utf-8"></script>
</head>
<body>
	<header>
        <nav class="top-nav black">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Ver Código</a></div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>

    <main class='show'>
    	<div class='container'>
            <br>
            <div class='row'>
               <div class='input-field col l6 m6 s10 offset-s1 offset-l3 offset-m3'>
                   <select id="cmbLevel">
                       <option selected disabled>Nivel</option>
                   </select>
                   <label>Selecciona un nivel</label>
               </div>

               <div class='input-field col l6 m6 s10 offset-s1 offset-l3 offset-m3'>
                   <select id="cmbSpecialty">
                       <option selected disabled>Especialidad</option>
                   </select>
                   <label>Selecciona una especialidad</label>
               </div>

               <div class='input-field col l6 m6 s10 offset-s1 offset-l3 offset-m3'>
                   <select id="cmbSection">
                       <option selected disabled>Sección</option>
                   </select>
                   <label>Selecciona una sección</label>
               </div>
                <div class='col l6 m6 s10 offset-s1 offset-l3 offset-m3 collection sectionCollection'></div>
            </div>
        </div>
    </main>
</body>
</html>