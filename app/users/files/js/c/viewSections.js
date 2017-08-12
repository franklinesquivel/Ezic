(() => {
    var loader, g_id;

	$(document).ready(function(){
        $('#getRowsData').modal();
        $('#getRowsData').modal('open');
        loader = new Loader();
        loader.in()
		$.ajax({
            url: '../../files/php/C_Controller.php',
            data: {getLvls: 1},
            success: (r) => {
                if (r != -1) {
                    $('#cmbLevel').append(r);
                    $('select').material_select();
                    search_section();
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
                        Materialize.toast('No se encontraron registros de especialidades para mostrar', 1000); 
                        $("#cmbSpecialty").empty();
                        $("#cmbSection").empty();
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
                    }else{
                        Materialize.toast('No se encontraron registros de especialidades para mostrar', 3000); 
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
            rules: {
                txtRows: {
                    required: true,
                    min: 1,
                    max: 15
                }
            },
            messages: {
                txtRows: {
                    required: "Este campo es requerido!",
                    min: "Ingrese un valor dentro del intervalo permitido!",
                    max: "Ingrese un valor dentro del intervalo permitido!"
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
                $('#printSection [name=id]').val(g_id);
                $("#printSection [name=rows").val($("#txtRows").val());
                $('#printSection').submit();
            }
        })

        $('.btnPrintSectionOption').click(function(){
            $('.frmPrint').submit();
        })
	})

    $(document).on('click', '.collection-item', function(){
        g_id = $(this).attr('idsn')
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
                    console.log(r);
                }
            }
        })
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
    			$(".sectionCollection").html(r);
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