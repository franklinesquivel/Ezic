(() => {
	var gR;
	$(document).ready(function(){
		var loader = new Loader();
		loader.in();
		$('main').fadeOut('slow');

		$.ajax({
			url: '../../files/php/S_Controller.php',
			data: {getGrades: 1},
			success: r => {
				if ( r != -1 ){
					r = JSON.parse(r);
					gR = r
					for (var i = 0; i < r.pInfo.length; i++) {
						if(r.subject[i] != -1){
							$('#cmbPeriod').append(`<option index="${i}" period="${r.pInfo[i][0]}">Período N°${r.pInfo[i][1]}</option>`);
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
				}else{
					$('main .gradesCont').html(`
						<div style='margin-top: 5%;' class='alert_'>No se encontraron materias registradas a las sección del estudiante!</div>
					`)
				}
				$('main').fadeIn('slow', loader.out());
			}
		})

		$('#cmbPeriod').change(function(){
			if ($('#cmbPeriod option:selected').attr('acc') === undefined) {
				$('.gradesCont').html(gR.subject[$('#cmbPeriod option:selected').attr('index')]);
			}else{
				$('.gradesCont').html(gR.acc);
			}
		})

		$('.btnPrint').click(() => {
			if ($('#cmbPeriod option:selected').attr('acc') === undefined) {
	            $('#printGrades input[name=period]').val($('#cmbPeriod option:selected').attr('period'));
            }else{
            	$('#printGrades input[name=period]').val("acc");
            }

            $('#printGrades').submit();
        })
	})
})()