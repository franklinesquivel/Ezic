(() => {

	var loader, data = [], f = 0, g_id;
	$(document).ready(function(){
		loader = new Loader();

		$.ajax({
            type: 'POST',
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
                    }
                }
            })
        })

        $('#cmbSection').change(() => {
            search_section($("#cmbLevel").val(), $("#cmbSpecialty").val(), $("#cmbSection").val());
        })

	})

	$(document).on('click', '.collection-item', function(){
        g_id = $(this).attr('idsn');
        loader.in();
        $.ajax({
            url: '../../files/php/C_Controller.php',
            data: {getSectionStudents: 1, idSn: g_id},
            success: r => {
                if (r != -1) {
                    $('.btnBack').removeAttr('disabled');
                    $('main').fadeOut('slow', function(){
                        $('.listCont').fadeOut(1);
                        $('.sectionCont').html(r);
                        $('.sectionCont').fadeIn('slow', function(){
                        	$.getScript('../../files/js/init.js');
                        	$(".sectionCont").append(`<br><br><center><div class='btnSave btn black waves-effect waves-light' style='margin-bottom: 5%;'>Registrar</div></center>`);
                            $('main').fadeIn(loader.out());
                        })
                    })
                }else{
                    loader.out();
                    Materialize.toast("La sección no posee alumnos asignados o todos sus alumnos tienen un responsable asignado!", 3000);
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

	jQuery.validator.setDefaults({
		debug: true,
		success: "valid"
	});

	$.validator.addMethod('email', function(value, element) {
        return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
    }, 'Ingrese un valor válido.');

    $.validator.addMethod('phone', function(value, element) {
        return this.optional(element) || /^\d{4}(-\d{4}|\d{4})$/.test(value);
    }, 'Ingrese un valor válido.');

    $.validator.addMethod('dui', function(value, element) {
        return this.optional(element) || /^\d{8}-\d$/.test(value);
    }, 'Ingrese un valor válido.');

    $(document).on('click', '.btnSave', function(){
    	data = [];
    	f = 0;
        for (let i = 0; i < $(".frmMandated").length; i++) {
            $(".frmMandated").eq(i).validate({
                rules: {
                	txtName: 'required',
		            txtLastName: 'required',
		            txtEmail: {
		                required: true,
		                email: true
		            },
		            txtPhone: {
		            	required: true,
		            	phone: true
		            },
		            txtDui: {
		            	required: 1,
		            	dui: 1
		            },
		            txtRelation: "required",
		            txtBirthdate: 'required',
		            txtSex: 'required'
                },
                messages: {
		            txtName: 'Ingrese un nombre',
		            txtLastName: 'Ingrese un apellido',
		            txtEmail: {
		                required: 'Ingrese un valor',
		                email: 'Ingrese un valor válido'
		            },
		            txtPhone: {
		            	required: "Este campo es necesario",
		            	phone: "Ingrese un valor válido"
		            },
		            txtDui: {
		            	required: "Este campo es necesario"
		            },
		            txtRelation: "Este campo es necesario",
		            txtBirthdate: 'Ingrese un valor',
		            txtSex: 'Seleccione un valor',
		        },
		        errorElement : 'div',
		        errorPlacement: function(error, element) {
		            var placement = $(element).data('error');
		            if (placement) {
		            	if ($(element).attr("type") == 'radio') {
			                $(placement).prepend(error);
		            	}else{
			                $(placement).append(error);
		            	}
		            } else {
		            	if ($(element).attr("type") == 'radio') {
			                error.insertBefore(element);
		            	}else{
			                error.insertAfter(element);
		            	}
		            }
		        },submitHandler: function(form) {
		        	let auxObj = {
		        		"idStudent": $(`form._${i + 1} input[name=idStudent]`).val(),
		        		"name": $(`#txtName_${i + 1}`).val(),
		        		"lastName": $(`#txtLastName_${i + 1}`).val(),
		        		"dui": $(`#txtDui_${i + 1}`).val(),
		        		"email": $(`#txtEmail_${i + 1}`).val(),
		        		"phone": $(`#txtPhone_${i + 1}`).val(),
		        		"sex": $(`form._${i + 1} input[name=txtSex]:checked`).val(),
		        		"relation": $(`#txtRelation_${i + 1}`).val(),
		        		"birthdate": $(`#txtBirthdate_${i + 1}`).val()
		        	}

		        	data.push(auxObj);
		        	f++;
		        }, invalidHandler: function(event, validator) {
		        	setTimeout(function(){
			        	$("body").animate({
			        		scrollTop: $("[class$=error]:nth-child(1)").eq(0).offset().top
			        	}, 500, "swing")

			        	$("[class$=error]:nth-child(1)").eq(0).focus();
		        	}, 100)
		        }
            })

            $(".frmMandated").eq(i).submit();

            if (f == $(".frmMandated").length) {
            	loader.in();
		     	$.ajax({
		     		url: '../../files/php/C_Controller.php',
		     		type: "POST",
		     		data: {addMandated: 1, data: JSON.stringify(data), idSn: g_id},
		     		success: r => {
		     			if (r > 0) {
		     				Materialize.toast("Los responsables se han registrado exitosamente!", 2000);
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
		     			}else{
		     				loader.out();
		     				Materialize.toast("Ha ocurrido un error!", 2000);
		     			}
		     		}
		     	})	
        	}
        }
    })

    $(document).on('submit', ".frmMandated", function(e){
    	e.preventDefault;
    	return false;
    })

    $(document).on('click', '.btnDeleteForm', function(){
        if ($(`.frmMandatedContainer`).length > 1) {
            $(`.frmMandatedContainer._${$(this).attr('frmIndex')}`).remove();
        }else{
            Materialize.toast('Debe registrar por lo menos un responsable!', 2000);
        }
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