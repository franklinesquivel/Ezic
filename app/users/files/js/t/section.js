(() => {

	var students, loader, slctStudent;
	$(document).ready(function(){
		loader = new Loader();
		$("#mandated-modal").modal();
		init();
	})

	$(document).on('click', '.btnBack', function(){
		init();
	});

	$(document).on('click', '.btnRefresh', function(){
		init();
	});

	$(document).on('click', '.btnList', function(){
		loader.in();
		$('main').fadeOut('slow');
		$.ajax({
			type: 'POST',
			url: '../../files/php/T_Controller.php',
			data: {listSection: 1, idSection: students.snInfo.idSection},
			success: r => {
				if (r != -1) {
					$('.btnBack').removeAttr('disabled');
					$('main').html(`<div class="container">${r}</div>`);
					$("#frmAction").attr('name', 'printSection');
                    $("[name=id]").val(students.snInfo.idSection);
					$(".btnPrint").removeAttr('disabled');
				}
				$('main').fadeIn('slow', loader.out());
			}
		})
	})

	$(document).on('click', '.btnGrades', function(){
		loader.in();
		$('main').fadeOut('slow', function(){
			$.ajax({
				type: 'POST',
				url: '../../files/php/T_Controller.php',
				data: {sectionGrades: 1, idSection: students.snInfo.idSection},
				success: r => {
					$('.btnBack').removeAttr('disabled');
	                $('.options_btn').attr('disabled', 1);
					$('main').html(`<div class="container section"><h4 class="center">Notas por sección</h4>${r}</div>`);
					$('main').fadeIn('slow', loader.out());
                    $("#frmAction").attr('name', 'printSectionGrades');
                    $("[name=id]").val(students.snInfo.idSection);
                    $("[name=idPeriod]").val('acc');
					$(".btnPrint").removeAttr('disabled');
				}
			})
		})
	})

	$(document).on('click', '.btnGrade', function(){
		slctStudent = students.students.findIndex(obj => {
			return obj.idStudent == $(this).parent().attr('id');
		});
		loader.in();
		$('main').fadeOut(100);
		$.ajax({
			type: 'POST',
			url: '../../files/php/T_Controller.php',
			data: {studentGrades: 1, idStudent: $(this).parent().attr('id')},
			success: r => {
				if (r == -1) {
                    $('main').html(`<div class='container'><div style='margin-top: 5%;' class='alert_'>No se encontraron materias registradas a las sección del estudiante!</div></div>`)
                }else{
                    r = JSON.parse(r);
                    let gR = r
                    $('main').html(`
                        <div class="row cmbCont" style="display: none;">
                        	<br/>
	                    	<h5 class="center">
		                    	<b>${students.students[slctStudent].idStudent}</b>
		                    	${students.students[slctStudent].name}
		                    	${students.students[slctStudent].lastName}
	                    	</h5>
                            <div class="input-field col l4 m4 s10 offset-s1 offset-l4 offset-m4">
                                <select name="" id="cmbPeriod">
                                    <option disabled>Seleciona un período</option>
                                </select>
                            </div>
                        </div>
                        <div class="container gradesCont"></div>`);
                    $('#cmbPeriod').change(function(){
                        if ($('#cmbPeriod option:selected').attr('acc') === undefined) {
                            $('.gradesCont').html(gR.subject[$('#cmbPeriod option:selected').attr('index')]);
	                        $('input[name=idPeriod]').val($('#cmbPeriod option:selected').attr('period'));
                        }else{
                            $('.gradesCont').html(gR.acc);
                            $('input[name=idPeriod]').val("acc");
                        }
                    })
                    for (var i = 0; i < r.pInfo.length; i++) {
                        if(r.subject[i] != -1){
                            $('#cmbPeriod').append(`<option index="${i}" period="${r.pInfo[i][1]}">Período N°${r.pInfo[i][1]}</option>`);
                        }else{
                            $('#cmbPeriod').append(`<option disabled>Período N°${r.pInfo[i][1]}</option>`);
                        }
                    }

                    if (r.acc !== null) {
                        $('#cmbPeriod').append(`<option acc="1">Notas Acumuladas</option>`);
                    }

                    $('#cmbPeriod option[index]:first-child').attr('selected', 1);
                    $('.gradesCont').append(r.subject[$('#cmbPeriod option:selected').attr('index')]);
                    $('.cmbCont').fadeIn('slow');
                    $('select').material_select();
                    $('.btnPrint').removeAttr('disabled');
                }
                $('.btnBack').removeAttr('disabled');
                $('.options_btn').attr('disabled', 1);
                $('main').fadeIn('slow', loader.out());

                $("#frmAction").attr('name', 'printGrades');
                $("[name=id]").val(students.students[slctStudent].idStudent);
				$('input[name=idPeriod]').val($('#cmbPeriod option:selected').attr('period'));
				$(".btnPrint").removeAttr('disabled');
            }
		})
	})

	$(document).on('click', '.btnView', function(){
		let btn = $(this);
		loader.in();
		$('main').fadeOut('slow', function(){
			$.ajax({
				type: 'POST',
				url: '../../files/php/T_Controller.php',
				data: {showUser: 1, idStudent: btn.parent().attr('id')},
				success: r => {
					$('main').html(r);
					$('main').fadeIn('slow', loader.out());
                    $("#frmAction").attr('name', 'printUser');
                    $("[name=id]").val(btn.parent().attr('id'));
					$(".btnPrint").removeAttr('disabled');
					$(".btnBack").removeAttr('disabled');
				}
			})
		})
	})

	$(document).on('click', '.btnRecord', function(){
		let btn = $(this);
		loader.in();
		$('main').fadeOut('slow', function(){
			$.ajax({
				type: 'POST',
				url: '../../files/php/T_Controller.php',
				data: {record: 1, idStudent: btn.parent().attr('id')},
				success: r => {
					$('main').html(r);
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
                    $("#frmAction").attr('name', 'printRecord');
                    $("[name=id]").val(btn.parent().attr('id'));
					$('main').fadeIn('slow', loader.out());
					$(".btnBack").removeAttr('disabled');
					$(".btnPrint").removeAttr('disabled');
				}
			})
		})
	})

	$(document).on('click', '.btnMandated', function(){
		slctStudent = students.students.findIndex(obj => {
			return obj.idStudent == $(this).parent().attr('id');
		});

        $('#mandated-modal').find('.student-id').html(students.students[slctStudent].idStudent);
        $('#mandated-modal').find('.student-name').html(students.students[slctStudent].lastName + ", " + students.students[slctStudent].name);

        loader.in();
        $.ajax({
        	type: 'POST',
            url: '../../files/php/T_Controller.php',
            data: {getMandated: 1, id: $(this).parent().attr('id')},
            success: r => {
                if (r != -1) {
                    $('#mandated-modal .row').html(r);
                    $('#mandated-modal').modal('open');
                }else{
                    Materialize.toast("No posee un responsable registrado!", 2000);
                }
                loader.out();
            }
        })
	})

	$(document).on('click', '.btnMandates', function(){
		$.ajax({
			type: 'POST',
			url: '../../files/php/T_Controller.php',
			data: {getSectionStudents: 1, idSn: students.snInfo.idSection},
			success: r => {
				if (r != -1) {
                    $('.btnBack').removeAttr('disabled');
                    $('main').fadeOut('slow', function(){
                        $('main').html(`<div class="container">${r}</div>`);
                    	$.getScript('../../files/js/init.js');
                    	$("main").append(`<br><br><center><div class='btnSave btn green darken-2 waves-effect waves-light' style='margin-bottom: 5%;'>Registrar</div></center>`);
                        $('main').fadeIn(loader.out());
                    })
                }else{
                	Materialize.toast('No hay estudiantes sin reponsables!', 2000);
                }
			}
		})
	})

	$(document).on('click', '.btnPrint', function(){
		$("#frmPrint").submit();
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

    $(document).on('click', '.btnDeleteForm', function(){
    	if ($(`.frmMandatedContainer`).length > 1) {
	    	$(`.frmMandatedContainer._${$(this).attr('frmIndex')}`).remove();
    	}else{
    		Materialize.toast('Debe registrar por lo menos un responsable!', 2000);
    	}
    })

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
		     		url: '../../files/php/T_Controller.php',
		     		type: "POST",
		     		data: {addMandated: 1, data: JSON.stringify(data), idSn: students.snInfo.idSection},
		     		success: r => {
		     			if (r > 0) {
		     				Materialize.toast("Los responsables se han registrado exitosamente!", 2000);
		     			}else{
		     				loader.out();
		     				Materialize.toast("Ha ocurrido un error!", 2000);
		     			}
	     				init();
		     		}
		     	})	
        	}
        }
    })

    $(document).on('submit', ".frmMandated", function(e){
    	e.preventDefault;
    	return false;
    })

	const init = function(){
		loader.in();
		$('main').fadeOut('slow', function(){
			$('main').html(`
				<div class="container section">
		            <table class="centered responsive-table" id="tblTeacherSection">
		                <thead class="green darken-2 white-text">
		                    <tr>
		                        <th class="tblHead" colspan="9">Estudiantes</th>
		                    </tr>
		                    <tr>
		                        <th>N°</th>
		                        <th>Código</th>
		                        <th>Nombre</th>
		                        <th colspan="4">Acciones</th>
		                        <th>Estado Académico</th>
		                        <th>Verificado</th>
		                    </tr>
		                </thead>
		                <tbody>
		                    
		                </tbody>
		            </table>
		        </div>
			`);
			$.ajax({
				type: 'POST',
				url: '../../files/php/T_Controller.php',
				data: {teacher_getStudents: 1},
				success: r => {
					if (r != -1) {
						$('.btnBack').attr('disabled', 1);
						$('.btnPrint').attr('disabled', 1);
						students = JSON.parse(r);
						if (students.snInfo != null) {
							$("main .container").prepend(`
								<div id="sectionInfo">
									<h4 class="green center darken-2 white-text">Información de la sección</h4>
									<div class="row center">
										<div class="col s12 l6 m6">Grado</div>
										<div class="col s12 l6 m6">${students.snInfo.level == 1 ? "1er" : students.snInfo.level == 2 ? "2do" : "3er"} Año de Bachillerato</div>
									</div>
									<div class="row center">
										<div class="col s12 l6 m6">Especialidad</div>
										<div class="col s12 l6 m6">${students.snInfo.sName}</div>
									</div>
									<div class="row center">
										<div class="col s12 l6 m6">Sección</div>
										<div class="col s12 l6 m6"><i>"${students.snInfo.sectionIdentifier}"</i></div>
									</div>
									<center>
										<div ${students.students == null ? 'disabled' : ''} class="btn waves-effect green darken-2 btnList">Lista <i class="material-icons right">list</i></div>
										<div ${students.students == null ? 'disabled' : ''} class="btn waves-effect green darken-2 btnGrades">Notas <i class="material-icons right">stars</i></div><span class="hide-on-med-and-up"><br/><br/></span>
										<div ${students.students == null ? 'disabled' : ''} class="btn waves-effect green darken-2 btnMandates">Registrar responsables <i class="material-icons right">contacts</i></div>
									</center>
								</div>
							`);
							if (students.students != null){
								students.students.forEach( (el, i) => {
									$("main table tbody").append(`
										<tr class="student" id="${el.idStudent}">
											<td>${i + 1}</td>
											<td class="title">${el.idStudent}</td>
											<td>${el.lastName}, ${el.name}</td>
											<td class="student-action btnView" title="Ver perfil"><i class="material-icons">remove_red_eye</i></td>
											<td class="student-action btnGrade" title="Notas"><i class="material-icons">star</i></td>
											<td class="student-action btnRecord" title="Récord Conductual"><i class="material-icons">favorite</i></td>
											<td class="student-action btnMandated" title="Ver responsable"><i class="material-icons">person</i></td>
											<td class="${el.color}-text"><b>${el.description}</b></td>
											<td><i class="material-icons ${el.verified == 1 ? "green" : "red"}-text">thumb_${el.verified == 1 ? "up" : "down"}</i></td>
										</tr>`);
									});
							}else{
								$("main table tbody").append(`<tr><td colspan='9'>No hay estudiantes registrados!</td></tr>`)
							}
						}else{
							$('main .container').html(`<div class="alert_">No posee una sección asignada!</div>`)
						}
					}
					$('main').fadeIn('slow', loader.out());
				}
			})
		});
	}
})()