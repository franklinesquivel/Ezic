(()=>{
    $(document).ready(function(){
        load_page();
    });

    function load_page(){
        var loader = new Loader();
        loader.in();
        $.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data:{
                addSection: 1
            }
        }).done(function(r){
            $('main .container').html(r);
            $('select').material_select();
            $('main').fadeIn('slow');
            loader.out();
        });
    }

    $(document).on('change', '#selectLevel', function(){
        if($(this).val() != null){
            var loader = new Loader();
            loader.in();
            $.ajax({
                type: 'POST',
                url: '../../files/php/C_Controller.php',
                data:{
                    getSectionIdentifier: 1,
                    level: $(this).val()
                }
            }).done(function(r){
                $('main .container form .row.next-section div').html(r);
            });
            loader.out();
        }
    });

    $(document).on('click', '.btnSave', function(){
        if(errorSelect($('select')) && $('main .container form .row.next-section div').text() != ""){
            var loader = new Loader();
            loader.in();
            $.ajax({
                type: 'POST',
                url: '../../files/php/C_Controller.php',
                data:{
                    registerSection: 1,
                    level: $("#selectLevel").val(),
                    specialty: $("#selectSpecialty").val(),
                    teacher: $("#selectTeacher").val(),
                    identifier: $('main .container form .row.next-section div h1').text()
                }
            }).done(function(r){
                //  alert(r);
                load_page();
                if(r == 1){
                    Materialize.toast("Registro exitoso", 3000);
                }else{
                    Materialize.toast("Algo salio mal", 3000); 
                } 
            });
        }else{
            Materialize.toast('Seleccionar todos los campos', 3000, 'red');
        }
    });
})()