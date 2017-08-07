// (() => {
	var person, loader, f = 1, f1 = 1, data, options, cxc;

	$(document).ready(function(){
		loader = new Loader();
		loader.in();
		cxc = $('#actualChart');
		initStuff();

		$('.btnUsers').click(function(){
			data = {
				datasets: [{
			        data: [person['C']['total'], person['T']['total'], person['S']['total']],
				    backgroundColor: [
		                'rgba(0, 0, 0, 0.2)',
		                'rgba(76, 175, 80, 0.2)',
		                'rgba(25, 118, 210, 0.2)'
		            ],
		            borderColor: [
		                '#000',
		                '#4CAF50',
		                '#1976D2'
		            ],
			    }],
	            borderWidth: 1,
			    labels: [
			        `Coordinadores ${((person['C']['total'] / person['Total']) * 100).toFixed(2)}%`,
			        `Profesores ${((person['T']['total'] / person['Total']) * 100).toFixed(2)}%`,
			        `Estudiantes ${((person['S']['total'] / person['Total']) * 100).toFixed(2)}%`
			    ]
			};
			options = {
				title: {
		    		display: 1,
		    		text: `Tipos de usuario registrados. Total: ${person['Total']}`,
		    		fontSize: 20
		    	},
		    	legend: {
		            display: true,
	                position: 'bottom'
		        }
			}

			$('main').fadeOut('slow', function(){
				setTimeout(genChart('doughnut'), 1300);
			});
		})

			
		$('.btnSections').click(function(){
			let lblAux = [];
			for(lvl in person['levels']){
				for (specialty in person['levels'][lvl]){
					// console.log(`Año: ${lvl} ${specialty}: ${person['levels'][lvl][specialty]}`);
					lblAux.push([]);
					lblAux[lblAux.length - 1].push(specialty);
					lblAux[lblAux.length - 1].push(person['levels'][lvl][specialty]);
				}
			}
			console.log(lblAux);
			data = {
				labels: lblAux.map((i) => i[0]),
				datasets: [{
					data: lblAux.map((i) => i[1])
				}]
			};

			options = {

			};

			$('main').fadeOut('slow', function(){
				setTimeout(genChart('bar'), 1300);
			});
		})

		$('.btnBack').click(function(){
			$(this).attr('disabled', 1);
			// cxc.fadeOut('slow', $('main').fadeIn('slow'));
			cxc.fadeOut('slow');
			setTimeout(function(){
				$('main').fadeIn('slow');
			}, 800);
		})
	})

	$.ajax({
		url: '../../files/php/C_Controller.php',
		data: {totalUsers: 1, type: null},
		success: r => {
			person = JSON.parse(r);
			console.log(person);
		}
	})

	function initStuff(){
		setTimeout(function(){
			if (person){
				$('main').fadeIn('slow', loader.out());
			}else{
				initStuff();
			}
		}, 100)
	}

	function genChart(type){
		let myChart = new Chart(cxc, {
		    type,
		    data,
		    options: options
		});

		cxc.fadeIn('slow');
		$('.btnBack').removeAttr('disabled');
	}
// })()