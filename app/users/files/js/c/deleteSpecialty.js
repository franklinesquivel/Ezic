(() => {
	var loader, sArray = [];
	$(document).ready(function(){
		loader = new Loader();
		init();
	})

	function init(){
		loader.in();
		$('main').fadeOut(1);
		$('main').html(`
			<br>
	        <div class="container section">
	            <div class="row" id="dltSy">
	                <table class="responsive-table centered bordered">
	                    <thead class="black white-text">
	                        <th>N°</th>
	                        <th>Especialidad</th>
	                        <th>Selección</th>
	                    </thead>
	                    <tbody>
	                    </tbody>
	                </table>
	            </div>
	        </div>

	        <center><div class="btn waves-effect waves-light btnSave black">Eliminar <i class='material-icons left'>delete</i></div></center>
		`);

		$.ajax({
			type: 'POST',
			url: '../../files/php/C_Controller.php',
			data: {getSpecialtiesForDelete: 1},
			success: r => {
				if (r != -1) {
					r = JSON.parse(r);
					sArray = r;
					for (var i = 0; i < r.length; i++) {
						$("#dltSy tbody").append(`
							<tr>
								<td>${i+1}</td>
								<td>${r[i].sName}</td>
								<td>
									<input type="checkbox" id="sy${i+1}" value='${r[i].idSpecialty}'/>
									<label for="sy${i+1}"></label>
								</td>
							</tr>
						`);
					}
				}else{
					$('main').html(`<div class="container section"><div class="alert_">No hay secciones en las condiciones de ser eliminadas!</div></div>`);
				}
				$('main').fadeIn('slow', loader.out());
			}
		})
	}

	$(document).on('click', '.btnRefresh', function(){
		init();
	})

	$(document).on('click', '.btnSave', function(){
		let sy = $("input[type=checkbox]:checked");
		if (sy.length > 0) {
			loader.in();
			let ids = sy.map((i, el) => el.value).toArray();
			// console.log(ids);
			$.ajax({
				type: 'POST',
				url: '../../files/php/C_Controller.php',
				data: {deleteSpecialty: 1, data: JSON.stringify(ids)},
				success: r => {
					Materialize.toast(
						r ? 
						(ids.length == 1 ? 
							"La especialidad ha sido eliminada exitosamente!" 
							: "Las especialidades han sido eliminadas exitosamente!") 
						: "Ha ocurrido un error!", 2000);
					init();
				}
			})
		}else{
			Materialize.toast("Debe seleccionar por lo menos una especialidad!", 2000);
		}
	})
})()