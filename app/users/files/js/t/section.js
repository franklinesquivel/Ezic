// (() => {

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
					$('main').html(r);
				}
				$('main').fadeIn('slow', loader.out());
			}
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
                        }else{
                            $('.gradesCont').html(gR.acc);
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

                $('.btnPrint').click(() => {
                    $('#printGrades input[name=id]').val(id);
                    if ($('#cmbPeriod option:selected').attr('acc') === undefined) {
                        $('#printGrades input[name=period]').val($('#cmbPeriod option:selected').attr('period'));
                    }else{
                        $('#printGrades input[name=period]').val("acc");
                    }
                    $('#printGrades').submit();
                })
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
					$('main').fadeIn('slow', loader.out());
					$(".btnBack").removeAttr('disabled');
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
						students = JSON.parse(r);
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
									<div class="btn waves-effect green darken-2 btnList">Lista <i class="material-icons right">list</i></div>
									<div class="btn waves-effect green darken-2 btnGrades">Notas <i class="material-icons right">stars</i></div><span class="hide-on-med-and-up"><br/><br/></span>
									<div class="btn waves-effect green darken-2 btnMandates">Registrar responsables <i class="material-icons right">contacts</i></div>
								</center>
							</div>
						`);
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
					}
					$('main').fadeIn('slow', loader.out());
				}
			})
		});
	}
// })()