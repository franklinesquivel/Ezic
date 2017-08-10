(() => {
	var person, loader, f = 1, f1 = 1, cxc, myChart;

	$(document).ready(function(){
		loader = new Loader();
		loader.in();
		cxc = $('#chart');
		initStuff();

		$('.btnUsers').click(function(){
			let data, options;
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
				setTimeout(genChart('doughnut', data, options), 1300);
			});
		})

			
		$('.btnSections').click(function(){
			let lblAux = [], cAux = [];
			let data, options;
			for(lvl in person['levels']){
				for (specialty in person['levels'][lvl]){
					lblAux.push([]);
					lblAux[lblAux.length - 1].push(specialty);
					lblAux[lblAux.length - 1].push(person['levels'][lvl][specialty]);
					lblAux[lblAux.length - 1].push(person['levels'][lvl]['color']);
				}
			}

			cAux = lblAux.map(i => getRandomColor());

			data = {
				datasets: [{
					label: "Cant. de Estudiantes por especialidad",
					data: lblAux.map((i) => i[1]),
		            backgroundColor: cAux.map(i => hexToRgbA(i)),
					borderColor: cAux.map(i => i)
				}],
				borderWidth: 4,
				labels: lblAux.map(i => i[0])
			};

			options = {
				title: {
		    		display: 1,
		    		text: `Alumnos por especialidad. Total: ${person.S.total}`,
		    		fontSize: 20
		    	},
		    	legend: {
		            display: true,
	                position: 'bottom'
		        }
			};

			$('main').fadeOut('slow', function(){
				setTimeout(genChart('bar', data, options), 1300);
			});
		})

		$('.btnBack').click(function(){
			$(this).attr('disabled', 1);
			$('.chart-cont-cont').fadeOut('slow');
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

	function genChart(t, d, o){
		if(myChart !== undefined){
			$('#chart').remove();
			$('<canvas></canvas>', {
				"id": "chart"
			}).appendTo(".chart-container");

			cxc = $('#chart');
		}
		myChart = new Chart(cxc, {
		    type: t,
		    data: d,
		    options: o
		});

		$('.chart-cont-cont').fadeIn('slow');
		$('.btnBack').removeAttr('disabled');
	}

	function getRandomColor() {
		var letters = '0123456789ABCDEF';
		var color = '#';
		for (var i = 0; i < 6; i++) {
			color += letters[Math.floor(Math.random() * 16)];
		}
		return color;
	}

	function hexToRgbA(hex){
	    var c;
	    if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
	        c= hex.substring(1).split('');
	        if(c.length== 3){
	            c= [c[0], c[0], c[1], c[1], c[2], c[2]];
	        }
	        c= '0x'+c.join('');
	        return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+', 0.2)';
	    }
	    throw new Error('Bad Hex');
	}
})()