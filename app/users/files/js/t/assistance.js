(()=>{
    var time = new Date(), g_id;
    var hour = time.getHours()+":"+time.getMinutes()+":"+time.getSeconds();
    var date = time.getFullYear()+"-"+(time.getMonth()+1)+"-"+time.getDate();

    $(document).ready(function(){

        $('#applyCode').modal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            inDuration: 300, // Transition in duration
            outDuration: 200, // Transition out duration
            startingTop: '4%', // Starting top style attribute
            endingTop: '10%', // Ending top style attribute
            ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
                initCodes();
            },
            complete: function() { initCodes(); } // Callback for Modal close
        });
        
        $('#cmbCategory').change(function(){
            $('#cmbCodes').html('<option selected disabled>Código</option>');
            let t = ($('#cmbType option:selected').attr('idtype') === undefined ? "" : $('#cmbType option:selected').attr('idtype'));
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {
                    getCodes: 1,
                    cat: $('#cmbCategory option:selected').attr('idcat'),
                    type: t
                },
                success: r => {
                    if (r != -1) {
                        $('#cmbCodes').append(r);
                    }else{
                        $('#cmbCodes').html('<option selected disabled>Código</option>');
                        Materialize.toast('No se encontraron coincidencias!', 2000);
                    }
                    $('select').material_select();
                }
            })
        })

        $('#cmbType').change(function(){
            $('#cmbCodes').html('<option selected disabled>Código</option>');
            let c = ($('#cmbCategory option:selected').attr('idcat') === undefined ? "" : $('#cmbCategory option:selected').attr('idcat'));
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {
                    getCodes: 1,
                    cat: c,
                    type: $('#cmbType option:selected').attr('idtype')
                },
                success: r => {
                    if (r != -1) {
                        $('#cmbCodes').append(r);
                    }else{
                        $('#cmbCodes').html('<option selected disabled>Código</option>');
                        Materialize.toast('No se encontraron coincidencias!', 2000);
                    }
                $('select').material_select();
                }
            })
        })
        
        $(".btn_options").hide();
        var loader = new Loader();
        load_data();//Se carga el horario de asistencia
        $('.info_btn').click(function(){
            $('.tap-target').tapTarget('open');
        });

        $(".refresh").click(function(){
            loader.in();
            for (var i = 0; i < $("table tbody tr input[type='radio']").length; i++) {
                $("table tbody tr input[type='radio']").eq(i).prop("checked", false);
            }
            loader.out();
        });

        $(".late_all").click(function(){
            loader.in();
            for (var i = 0; i < $("table tbody tr input[type='radio']").length; i++) {
                if(!($("table tbody tr input[type='radio']").eq(i).attr("disabled")) && ($("table tbody tr input[type='radio']").eq(i).val() == "T")){
                    $("table tbody tr input[type='radio']").eq(i).prop("checked", true);
                }
            }
            loader.out();
        });

        $(".check_all").click(function(){
            loader.in();
            for (var i = 0; i < $("table tbody tr input[type='radio']").length; i++) {
                if(!($("table tbody tr input[type='radio']").eq(i).attr("disabled")) && ($("table tbody tr input[type='radio']").eq(i).val() == "S")){
                    $("table tbody tr input[type='radio']").eq(i).prop("checked", true);
                }
            }
            loader.out();
        });
    });

    function load_data(){
        var loader = new Loader();
        loader.in();
        $.ajax({
            url: '../../files/php/T_Controller.php',
            data: {getListAssistance: 1, hour: hour, date: date},
            success: function(r){

                if (r == 0) {
                    btn_floatingOptions();
                    $('main .container .list').html("<div class='alert_ red-text text-darken-4'>Según su horario no hay secciones por evaluar</div>");    
                }else if(r == -1){
                    btn_floatingOptions();
                    $('main .container .list').html("<div class='alert_ red-text text-darken-4'>No hay un horario asignado a este usuario</div>");
                }else{
                    $('main .container .list').html(r);       
                }
                $(".btn_options").show();
                $('main').fadeIn('slow');
                loader.out();
            }
        });
    }

    const btn_floatingOptions = () =>{
        for (var i = 0; i <  $(".btn_options ul li a").length; i++) {
            if ($(".btn_options ul li a").eq(i).attr("class") != $(".btn_options ul li a").eq($(".btn_options ul li a").length - 1).attr("class")) {
                    $(".btn_options ul li a").eq(i).attr("disabled", true);
            }
        }
    };

    $(document).on("click", ".btnSave", function(){
        let array = ($("table").attr("register")).split(", ");
        let object = validate_radio();
        if (object != false) {
            $.ajax({
                type: 'POST',
                url: '../../files/php/T_Controller.php',
                data:{
                    new_assistance: 1,
                    students: object,
                    date: date,
                    idSchedule: $("table").attr("register")
                }
            }).done(function(r){
                if (r == 1) {
                    $('main').fadeOut('fast');
                    Materialize.toast("Asistencia pasada con exito!",3000);
                    load_data();
                }else{
                    Materialize.toast("ERROR, intentarlo más tarde",3000);
                }
            });
        }else{
            Materialize.toast("Seleccionar todos los datos disponibles",3000);
        }
    });

    var validate_radio = () =>{
        let z = 0, y = 0, assistance_values = new Array();
        for (var i = 0; i < $("table tbody tr").length; i++) {
            if(!($("table tbody tr input[type='radio']").eq(i).attr("disabled"))){
                if($("table tbody tr input[name='student_"+i+"']:checked").val() != undefined){
                    assistance_values[y] = {
                        "idStudent": $("table tbody tr").attr("id"),
                        "attended": $("table tbody tr input[name='student_"+i+"']:checked").val()
                    };
                    y++;
                }
            }
            z++;
        }
        return (r = (z == y) ? JSON.stringify(assistance_values) : false);
    };

    $(document).on("click", ".btnCodeModal", function(event){
        g_id = $("#"+$(this).attr("id")).parent().parent().attr("id");
        let fullname = ($("#"+$(this).attr("id")).parent().parent().children('.info').text()).split(", "),
            name = fullname[0],
            lastName = fullname[1];
            
        $('.modal').find('.apply-id').html(g_id);
        $('.modal').find('.apply-name').html(lastName + ", " + name);
        $('#applyCode').modal('open');
    });

    const initCodes = () => {
        $('#cmbCategory').html("<option selected disabled>Categoría</option>");
        $('#cmbType').html("<option selected disabled>Tipo</option>");
        $('#cmbCodes').html("<option selected disabled>Código</option>");
        $.ajax({
            url: "../../files/php/C_Controller.php",
            data: {getCodeOptions: 1},
            success: r => {
                let objCodes = JSON.parse(r);
                $('#cmbCategory').append(objCodes[0]);
                $('#cmbType').append(objCodes[1]);
                $('#cmbCodes').append(objCodes[2]);
                $('select').material_select();
            }
        })
    }

    $(document).on('click', '.btnApplyCode', function() {
        if (errorSelect($('#cmbCodes'))) {
            $.ajax({
                url: '../../files/php/T_Controller.php',
                data: {
                    applyCode: 1, 
                    idCode: $('#cmbCodes option:selected').attr('idCode'),
                    idStudent: g_id
                },
                success: r => {
                    Materialize.toast((r) ? "El código ha sido aplicado con éxito!" : "Ha ocurrido un error...", 2000);
                    $('#applyCode').modal('close');
                }
            })
        }else{
            Materialize.toast('Seleccione un código!', 2000);
        }
    });
})()
