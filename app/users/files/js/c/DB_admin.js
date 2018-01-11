(function(){
    var loader;
    $(document).ready(function() {
        loader = new Loader();
        init_page();
    });

    $(document).on('click', '.btnSave', function() {
        if ( errorSelect( $('#selectBDD').val() ) ){
            changeBDD($('#selectBDD').val());
        }else{
            Materialize.toast("Favor, seleccionar una Base de Datos", 3000, "red");
        }
    });

    function init_page(){
        loader.in();
        $.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data: { v_databases: 1}
        }).done(function(r){
            $('main .container').html(r);
            $('select').material_select();
        });
        $("main").fadeIn("slow");
        loader.out();
    }

    function changeBDD(name){
        loader.in();
        $.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data: { changeBDD: 1, name: name }
        }).done(function (r) {
            if(r == 1){
                init_page();
                Materialize.toast("Se ha cambiado la Base de Datos", 3000);
            }else{
                loader.out();
                Materialize.toast("Ha ocurrido un error", 3000, "red");
            }
        });      
    }
})()