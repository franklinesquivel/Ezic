<?php
    require_once('../../../../General_Files/php/classes/Page_Constructor.php');
    $const = new Constructor();
    $const->verify_Log('C');
    $userRow = $const->getData('C');

    if(!isset($_POST['showUser'])){
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'administration.php';
        header("Location: http://$host$uri/$extra");
    }else{
        require_once('../../../../General_Files/php/classes/Administration.php');
        require_once('../../../../General_Files/php/classes/User_Class.php');
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv=”Expires” content=”0″>
    <meta http-equiv=”Last-Modified” content=”0″>
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv=”Pragma” content=”no-cache”>

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
</head>
<body>

    <header>
        <nav class="top-nav black">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Usuario</a></div>
            </div>
        </nav>
        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>

    <main>
<?php
    $admin = new Administration();
    
    echo $admin->showUser($admin->get_user_data($_POST['id']));
?>
    </main>

    <div class="fixed-action-btn vertical">
        <a class="btn-floating btn-large black" id="info">
            <i class="material-icons">menu</i>
        </a>
        <ul>
            <li title="Imprimir"><a class="btn-floating blue lighten-2 btnPrint"><i class="material-icons">file_download</i></a></li>
            <li title="Información"><a class="btn-floating amber info_btn"><i class="material-icons">info_outline</i></a></li>
        </ul>
    </div>

    <form action="../../../../General_Files/php/classes/Print.php" method="POST" id="printUser"> 
        <input type="hidden" name="printUser" value="1">
        <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
    </form>

    <script>
        var loader = new Loader();
        $(document).ready(function(){
            loader.in();
            $('main').fadeIn('slow', loader.out());
            $('.options_btn').attr('disabled', 1);

            $('.btnPrint').click(function() {
                $('#printUser').submit();
            })
        })
    </script>
</body>
</html>
