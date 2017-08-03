(() => {

	$(document).ready(function(){
		$.ajax({
			url: '../../files/php/S_Controller.php',
			data: {getGrades: 1},
			success: r => {
				r = JSON.parse(r);
				console.log(r);
				for (var i = 0; i < r.pInfo.length; i++) {
					if(r.grades[i] != -1){
						$('#cmbPeriod').append(`<option index="${i}">Período N°${r.pInfo[i][1]}</option>`);
					}else{
						$('#cmbPeriod').append(`<option disabled>Período N°${r.pInfo[i][1]}</option>`);
					}
				}
				$('#cmbPeriod option[index]:first-child').attr('selected', 1);
				$('.gradesCont').append(r.grades[$('#cmbPeriod option:selected').attr('index')]);
				$('select').material_select();
			}
		})

		$('#cmbPeriod').change(function(){
			alert($(this).children('option:selected').attr('index'));
		})
	})
})()