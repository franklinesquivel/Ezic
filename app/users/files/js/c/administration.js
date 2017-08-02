// (function(){
	if ($('.user-item').length > 0) {
		//ACCIONES PARA ESTUDIANTE
		$('.btnGrades').click(function() {
			
		});

		$('.btnRecord').click(function(){
			var func = $(this).attr('function');
			g_id = $(this).parent().parent().parent().attr('id');
			stage[2]['record'][0](g_id);
		})

		//ACCIONES PARA DOCENTE Y COORDINADOR
		$('.btnSchedule').click(function(){

		})

		$('.btnSubject').click(function(){

		})

		//ACCIONES GENERALES
		$('.btnShow').click(function() {
			g_id = $(this).parent().parent().parent().attr('id');
			stage[2]['show'](g_id);
		});

		$('.btnEdit').click(function(){

		})
	}else if($('.user-item').length == 0 && $('.user-row').length == 0){
		// alert(':p');
		$('.btnPermission').click(function() {
			// alert('Permiso');
			stage[2]['record'][1](g_id);
			f = 0;
		});

		$('.btnJustify').click(function(event) {
			// alert('Justificante');
			stage[2]['record'][2](g_id);
			f = 0;
		});
	}
// })()