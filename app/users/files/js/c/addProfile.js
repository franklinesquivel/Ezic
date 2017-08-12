(()=>{
    var subject = new Array() , x = 0;

    $(document).ready(function(){
        load_page();
        var loader = new Loader();

        $('.info_btn').click(function(){
            $('.tap-target').tapTarget('open');
        });

        $('.btnBack').click(function(){
            load_page();
        });

        $(".check_all").click(function(){
            loader.in();
            $("table tbody tr input[type='checkbox']").prop("checked", false);
            subject.length = 0;
            x = 0;
            for (var i = 0; i < $("table tbody tr input[type='checkbox']").length; i++) {
                $("table tbody tr input[type='checkbox']").eq(i).prop("checked", true);
                subject[i] = {"id": $("table tbody tr input[type='checkbox']").eq(i).attr("id")};
            }
            loader.out();
            console.log(JSON.stringify(subject));
        });
    });
   
    function load_page(){
        var loader = new Loader();
        loader.in();
        $.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data:{
                v_AddProfile: 1,
            }
        }).done(function(r){
            $('main').html(r);
            $("main").fadeIn("slow");
            $('select').material_select();
            loader.out();
        });
        subject.length = 0;
        $('.btnBack').attr("disabled", true);
        $(".check_all").attr("disabled", true);
        x = 0;
    }
    
    var period = 0;

    $(document).on("change", "#selectPeriod", function(){
        getTable($(this).val());
        period = $(this).val();
    });

    $(document).on("click", ".btnSave", function(){
        $("form.addProfile").validate({
            rules:{
                profile_name:{
                    required: true
                },
                percentage:{
                    required: true
                }
            },
            messages:{
                profile_name:{
                    required: 'Ingrese un nombre'
                },
                percentage:{
                    required: 'Ingrese un valor'
                }
            },
            errorElement : 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                if (subject.length > 0) {
                    sendInfo($("#profile_name").val(),$("#percentage").val());
                }else{
                    Materialize.toast("Seleccionar Asignaturas" ,3000);
                }
                
            }
        });
    });

    const getTable = (period) =>{
        var loader = new Loader();
        loader.in();
        $.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data:{
                getTableProfile_add: 1,
                period: period
            }
        }).done(function(r){
            $('main').html(r);
            $('.btnBack').attr("disabled", false);
            $(".check_all").attr("disabled", false);
            loader.out();
        });
    };

    const sendInfo = (name, percentage) =>{
        if (percentage < 101) {
            var loader = new Loader();
            loader.in();
            let object = JSON.stringify(subject);
            console.log(object+" - "+name+" - "+percentage);
            $.ajax({
                type: 'POST',
                url: '../../files/php/C_Controller.php',
                data:{
                    newProfile: 1,
                    period: period,
                    name: name,
                    percentage: percentage,
                    subject: object
                }
            }).done(function(r){
                if (r == 1) {
                    Materialize.toast('Pérfil Registrado con exito', 3000);
                    load_page();
                }else{
                    let subject_error = JSON.parse(r);
                    make_error_tr(subject_error);
                    Materialize.toast('Alguna/s materia sobrepasan el 100%', 3000);
                }
                loader.out();
            });
        }else{
            Materialize.toast('Porcentaje no permitido', 3000);
        }
    };

    const make_error_tr = (object) =>{
        for (var i = 0; i < $("table tbody tr input[type='checkbox']").length; i++) {
            for (var x = 0; x < object.length; x++) {
               if (($("table tbody tr input[type='checkbox']").eq(i).attr("id")) == (object[i].id)) {
                    $("table tbody").css({"background": "#d32f2f", "color": "white"});
                }
            }
        }
    };

    $(document).on("change", ".btn_checkbox", function(){
        if($(this).prop("checked")){
            subject[x] = {"id": $(this).attr("id")};
            x++;
        }else{
            removeIndex($(this).attr("id"));
            x--;
        }
    });

    function removeIndex(id){
        for (var i = 0; i < subject.length; i++) {
            if (subject[i].id == id) {
                subject.splice(i,1);
            }
        }
    }
})()
