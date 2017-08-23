(() => {
    var loader, g_id, rules = {}, messages;

	$(document).ready(function(){
        rules = {
            txtRows: {
                required: true,
                min: 1,
                max: 15
            }
        }

        messages = {
            txtRows: {
                required: "Este campo es requerido!",
                min: "Ingrese un valor dentro del intervalo permitido!",
                max: "Ingrese un valor dentro del intervalo permitido!"
            }
        }

        $('#getRowsData').modal();
        loader = new Loader();
        loader.in();
        $.ajax({
            url: '../../files/php/C_Controller.php',
            data: {periodsJSON: 1},
            success: (r) => {
                if (r != -1) {
                    r = JSON.parse(r);
                    for (var i = 0; i < r.length; i++) {
                        $("#cmbPeriod").append(`<option value="${r[i].idPeriod}">Período N° ${r[i].nthPeriod}</option>`);
                    }

                    $('#cmbPeriod').append(`<option value="acc">Notas Acumuladas</option>`);
                }
            }
        })
		$.ajax({
            url: '../../files/php/C_Controller.php',
            data: {getLvls: 1},
            success: (r) => {
                if (r != -1) {
                    $('#cmbLevel').append(r);
                    $('select').material_select();
                    search_section();
                }else{
                    $(".sectionCollection").html(`<div class="alert_">No se encontraron secciones con los requisitos especificados!</div>`);
                }
                $('main').fadeIn('slow', loader.out());
            }
        })

        $('#cmbLevel').change(() => {
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {getSpecialties: 1, lvl: $("#cmbLevel").val()},
                success: function(r){
                    if (r != -1) {
                        $("#cmbSpecialty").empty();
                        $("#cmbSection").empty();
                        $("#cmbSpecialty").html("<option disabled selected>Especialidad</option>");
                        $("#cmbSection").html("<option disabled selected>Sección</option>");
                        $('#cmbSpecialty').append(r);
                        $('select').material_select();
                        search_section($("#cmbLevel").val());
                    }else{
                        $("#cmbSpecialty").empty();
                        $("#cmbSection").html();
                        $("#cmbSpecialty").html("<option disabled selected>Especialidad</option>");
                        $("#cmbSection").html("<option disabled selected>Sección</option>");
                        $('select').material_select();
                        search_section($("#cmbLevel").val());
                    }
                }
            })
        })

        $('#cmbSpecialty').change(() => {
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {returSections: 1, specialty: $("#cmbSpecialty").val()},
                success: function(r){
                    if (r != -1) {
                        $("#cmbSection").html("<option disabled selected>Sección</option>");
                        $('#cmbSection').append(r);
                        $('select').material_select();
                        search_section($("#cmbLevel").val(), $("#cmbSpecialty").val());
                    }
                }
            })
        })

        $('#cmbSection').change(() => {
            search_section($("#cmbLevel").val(), $("#cmbSpecialty").val(), $("#cmbSection").val());
        })

        jQuery.validator.setDefaults({
          debug: true,
          success: "valid"
        });

        $('.frmPrint').validate({
            rules,
            messages,
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
                if($("input[name=file]:checked").attr('id') == "rdoGrades"){
                    if (errorSelect($('#cmbPeriod'))) {
                        $('#printSection [id=action]').attr("name", "printSectionGrades");
                        $('#printSection [name=idPeriod]').val($('#cmbPeriod').val());
                    }else{
                        Materialize.toast("Este dato es necesario!", 2000);
                    }
                }else if($("input[name=file]:checked").attr('id') == "rdoRecords"){
                    $('#printSection [id=action]').attr("name", "printSectionRecords");
                }else if($("input[name=file]:checked").attr('id') == "rdoUser"){
                    $('#printSection [id=action]').attr("name", "printSectionUsers");
                }else if($("input[name=file]:checked").attr('id') == "rdoList"){
                    $('#printSection [id=action]').attr("name", "printSection");
                    $("#printSection [name=rows").val($("#txtRows").val());
                }else{
                    Materialize.toast('Debes seleccionar una opción!', 2000);
                    return;
                }

                $('#printSection [name=id]').val(g_id);
                $('#printSection').submit();
            }
        })

        $('.btnPrintSectionOption').click(function(){
            $('.frmPrint').submit();
        })
	})

    $(document).on('click', '.collection-item', function(){
        g_id = $(this).attr('idsn');
        loader.in();
        $.ajax({
            url: '../../files/php/C_Controller.php',
            data: {showSection: 1, idSn: g_id},
            success: r => {
                if (r != -1) {
                    $('.btnBack').removeAttr('disabled');
                    $('.btnPrint').removeAttr('disabled');
                    $('main').fadeOut('slow', function(){
                        $('.listCont').fadeOut(1);
                        $('.sectionCont').html(r);
                        $('.sectionCont').fadeIn('slow', function(){
                            $('main').fadeIn(loader.out());
                        })
                    })
                }else{
                    loader.out();
                    Materialize.toast("La sección no posee alumnos asignados!", 2000);
                }
            }
        })
    })

    $(document).on("change", "input[name=file]", function(){
        $("#cmbPeriod").children().eq(0).attr("selected");
        $("input#txtRows").val("");
        $('input#txtRows').attr('disabled', 1);
        $('#cmbPeriod').attr('disabled', 1);
        $("select").material_select();
    })

    $(document).on('change', '#rdoList', function(){
        $('input#txtRows').removeAttr('disabled');
        rules = {
            txtRows: {
                required: true,
                min: 1,
                max: 15
            }
        }
        messages = {
            txtRows: {
                required: "Este campo es requerido!",
                min: "Ingrese un valor dentro del intervalo permitido!",
                max: "Ingrese un valor dentro del intervalo permitido!"
            }
        }
    })

    $(document).on('change', "#rdoGrades", function(){
        $('#cmbPeriod').removeAttr('disabled');
        $("select").material_select();
        rules = {};
        messages = {};
    })

    $(document).on('change', "#rdoRecords", function(){
        rules = {};
        messages = {};
    })

    $(document).on('change', "#rdoUser", function(){
        rules = {};
        messages = {};
    })

    $(document).on('click', '.btnBack', function(){
        loader.in();
        $(this).attr('disabled', 1);
        $('.btnPrint').attr('disabled', 1);
        $('main').fadeOut('slow', function(){
            init_search(function(){
                $('.sectionCont').fadeOut(1);
                $('.listCont').fadeIn('slow', function(){
                    $('main').fadeIn(loader.out());
                })
            })
        })
    })

    $(document).on('click', '.btnPrint', function(){
        $('#getRowsData').modal('open');
    })

    const search_section = (lvl = '', spcty = '', sctn = '') => {
        loader.in()
    	$.ajax({
    		url: '../../files/php/C_Controller.php',
    		data: {filterSections: 1, lvl, spcty, sctn},
    		success: r => {
                if (r != -1) {
        			$(".sectionCollection").html(r);
                }else{
                    $(".sectionCollection").html(`<div class="alert_">No se encontraron secciones con los requisitos especificados!</div>`);
                }
                loader.out();
    		}
    	})
    }

    const init_search = (callback) => {
        $("#cmbLevel").empty();
        $("#cmbSpecialty").empty();
        $("#cmbSection").empty();

        $("#cmbLevel").html("<option selected disabled>Nivel</option>");
        $("#cmbSpecialty").html("<option selected disabled>Especialidad</option>");
        $("#cmbSection").html("<option selected disabled>Sección</option>");

        $.ajax({
            url: '../../files/php/C_Controller.php',
            data: {getLvls: 1},
            success: (r) => {
                if (r != -1) {
                    $('#cmbLevel').append(r);
                    $('select').material_select();
                    search_section();
                }
                callback();
            }
        })
    }
})()