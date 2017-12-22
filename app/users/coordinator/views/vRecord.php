<?php
    require_once('../../../../General_Files/php/classes/Page_Constructor.php');
    $const = new Constructor();
    $const->verify_Log('C');
    $userRow = $const->getData('C');

    if(!isset($_POST['showRecord'])){
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'administration.php';
        header("Location: http://$host$uri/$extra");
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
    <script src="../../files/js/c/vRecord.js" charset="utf-8"></script>
</head>
<body>

    <header>
        <nav class="top-nav black">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Récord Conductual</a></div>
            </div>
        </nav>
        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>

    <main>
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

    <form action="../../../../General_Files/php/classes/Print.php" method="POST" id="printRecord"> 
        <input type="hidden" name="printRecord" value="1">
        <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
    </form>

    <div id="modalPermission" class="modal modal-fixed-footer">
        <div class="modal-content">

        </div>
        <div class="modal-footer">
            <!-- <div class="waves-effect btn green white-text btnSavePermission" style="margin-left: 2%;">Guardar <i class="material-icons right">save</i></div> -->
            <div class="modal-action modal-close waves-effect btn red white-text">Cancelar <i class="material-icons right">cancel</i></div>
        </div>
    </div>

    <div id="modalJustification" class="modal modal-fixed-footer">
        <div class="modal-content">

        </div>
        <div class="modal-footer">
            <!-- <div class="waves-effect btn green white-text btnSavePermission" style="margin-left: 2%;">Guardar <i class="material-icons right">save</i></div> -->
            <div class="modal-action modal-close waves-effect btn red white-text">Cancelar <i class="material-icons right">cancel</i></div>
        </div>
    </div>

    <script>
        var loader = new Loader();
        $(document).ready(function(){
            loader.in();
            let id = '<?php echo $_POST['id']; ?>';
            $('main').fadeOut('slow');
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {record: 1, id: id},
                success: function(r){
                    $('main').html(r);
                    $('main').append("<br><br><div class='row'><div class='col l4 m4 s10 offset-l1 offset-m1 offset-s1 green btn waves-effect btnPermission'>Permiso de ausencia <i class='material-icons right'>date_range</i></div><div class='hide-on-med-and-up col s12'><i style='opacity: 0'>.</i></div><div class='col l4 m4 s10 offset-l2 offset-m2 offset-s1 orange btn waves-effect btnJustify'>Registrar justificante <i class='material-icons right'>done_all</i></div></div>")
                    $('.recordTables thead tr th').each(function() {
                        $(this).css('border', '1px solid ' + $(this).parent().css('background-color'));
                    });

                    $('.recordTables tbody tr').each(function() {
                        $(this).css({
                            'border-left': '1px solid ' + $(this).parent().parent().children().children().css('background-color'),
                            'border-right': '1px solid ' + $(this).parent().parent().children().children().css('background-color'),
                            'border-bottom': '1px solid ' + $(this).parent().parent().children().children().css('background-color')
                        })
                    });
                    $('main').fadeIn('slow', loader.out());
                }
            })

            $('.btnPrint').click(() => {
                $('#printRecord').submit();
            })
        })
    </script>
</body>
</html>
