(()=>{
    var code1, code2;

    $(document).ready(function(){
        load_page();
    });

    function load_page(){
        var loader = new Loader();
        loader.in();
        $.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data:{v_grnlCode: 1}
        }).done(function(r){
            $('main .container').html(r);
            $('select').material_select();
            $('main').fadeIn('slow');
        });
        loader.out();
    }

    $(document).on('click', '.btnSave', function(){
        if(errorSelect($('select'))){
            var loader = new Loader();
            loader.in();
            let object = [
                {"id": $("#selectCode0").attr('gnrl_id'), "value": $("#selectCode0").val()},
                {"id": $("#selectCode1").attr('gnrl_id'), "value": $("#selectCode1").val()}
            ];
            
            $.ajax({
                type: 'POST',
                url: '../../files/php/C_Controller.php',
                data:{
                    modify_gnrlCode: 1,
                    object: JSON.stringify(object)
                }
            }).done(function(r){
                if(r == 1){
                    Materialize.toast("Modificación Exitosa", 3000);
                    load_page();
                }else{
                    Materialize.toast("Se ha producido un error", 3000, "red");
                }
            });
        }
    });
})()