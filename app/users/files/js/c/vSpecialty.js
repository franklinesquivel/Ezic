(() => {
	var loader, sArray = [];
	$(document).ready(function(){
		loader = new Loader();

		init();
	})

	$(document).on('click', ".btnRefresh", function(){
		init();
	})

	function init(){
		loader.in();
		$("main").fadeOut(100);
		$.ajax({
			type: 'POST',
			url: '../../files/php/C_Controller.php',
			data: {specialtyArray: 1},
			success: r => {
				if (r != -1) {
					sArray = JSON.parse(r);
					$('main').html(`
						<br/>
						<div class="container section">
							<table class='responsive-table bordered centered'>
								<thead class='black white-text'>
									<th>N°</th>
									<th>Especialidad<th>
								</thead>
								<tbody></tbody>
							</table>
						</div>`);

					for (var i = 0; i < sArray.length; i++) {
						$('table tbody').append(`
							<tr>
								<td>${i+1}</td>
								<td>${sArray[i]}</td>
							</tr>
						`);	
					}
				}
				$('main').fadeIn('slow', loader.out());
			}
		})
	}
})()