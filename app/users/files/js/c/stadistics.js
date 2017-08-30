// (() => {
	var users, loader, gradesP, specialtyObj;

	$(document).ready(function(){
		loader = new Loader();
		loader.in();

		$.ajax({
			url: '../../files/php/C_Controller.php',
			data: {totalUsers: 1, type: null},
			success: r => {
				users = JSON.parse(r);
				initUsers();
			}
		})

		$.ajax({
			type: 'POST',
			url: '../../files/php/C_Controller.php',
			data: {specialtyStats: 1},
			success: r => {
				specialtyObj = (JSON.parse(r));
				initSpecialty();
				$('main').fadeIn('slow', loader.out());
			}
		})

		$.ajax({
			type: 'POST',
			url: '../../files/php/C_Controller.php',
			data: {timelineGrades: 1},
			success: r => {
				r = JSON.parse(r);
				gradesP = r;
				initGradesTN();
			}
		})

		$.ajax({
			type: 'POST',
			url: '../../files/php/C_Controller.php',
			data: {topStudents: 1},
			success: r => {
				r = JSON.parse(r);
				console.log(r);
				$("#gnrlACC").html(r.avg);
				for (var i = 0; i < r.students.length; i++) {
					if (r.students[i].student.info !== null) {
						$("main #top .col-content").append(`
							<h5 class="center">Nivel 1</h5>
                            <div class='user-item' style="width: auto;">
                                <div class='info'>
                                    <div class='photo'>
                                        <img src='../../files/profile_photos/${r.students[i].student.info.photo}'>
                                    </div>
                                    <div class='data'>
                                        <span class='id'>${r.students[i].student.info.id}</span>
                                        <span class='full-name'><span class='lastName'>${r.students[i].student.info.lastName}</span>, ${r.students[i].student.info.name}</span>
                                        <span class='xtra'>
                                            <span>
												${r.students[i].student.info.level}
												'${r.students[i].student.info.sectionIdentifier}',
												${r.students[i].student.info.sName}
                                            </span>
                                        </span> 
                                    </div>
                                </div>
                                <div class="avg">
                                    <span id="acc-title">ACC</span>
                                    <span class="avg-data">${r.students[i].student.acc}</span>
                                </div>
                            </div>
						`);	
					}
				}


			}
		})

	})

	$(document).on('click', '.btnBack', function(){
		$(this).attr('disabled', 1);
		$('.chart-cont-cont').fadeOut('slow', function(){
			$(".innerCont.active").removeClass('active');
			$('main').fadeIn('slow');
		});
	})

	function initUsers(){
		var usersChart = new Chart($("#users"), {
		    type: 'doughnut',
		    data: {
		    	datasets: [{
			        data: [users['C']['total'], users['T']['total'], users['S']['total']],
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
			        `Coordinadores ${((users['C']['total'] / users['Total']) * 100).toFixed(2)}%`,
			        `Profesores ${((users['T']['total'] / users['Total']) * 100).toFixed(2)}%`,
			        `Estudiantes ${((users['S']['total'] / users['Total']) * 100).toFixed(2)}%`
			    ]
		    },
		    options: {
		    	title: {
		    		display: 1,
		    		text: `Total: ${users['Total']}`,
		    		fontSize: 17
		    	},
		    	legend: {
		            display: true,
	                position: 'bottom'
		        }
		    }
		});
	}

	function initGradesTN(){
		var auxLabel = [""],
			auxData = [0];

		(gradesP.map((el, i) => auxLabel.push(`Período N° ${el.nthPeriod}`)));
		(gradesP.map((el, i) => auxData.push(el.average)));
		auxLabel.push("");
		auxData.push(0);
		var gradesTNChart = new Chart($("#gradesTN"), {
			type: 'line',
			data: {
				labels: auxLabel,
				datasets: [
					{
						label: 'Promedio de notas',
						fill: 0,
						borderColor: "#1976d2",
						backgroundColor: "rgba(25, 118, 210, 0.5)",
						borderCapStyle: 'round',
						pointBorderWidth: 3,
						pointRadius: 7,
						data: auxData
					}
				]
			},
			options: {
			    scales: {
			        xAxes: [{
			            ticks: {
			                // beginAtZero: true
			            }
			        }],
			        yAxes: [{
			        	ticks: {
			        		min: 0,
			        		max: 10
			        	}
			        }]
			    }
			}
		})
	}

	function initSpecialty(){
		var auxLabel = specialtyObj.map(el => el.sName),
			labels, dataHelper = [], lvlHelper = specialtyObj.map(el => el.lvl), levels = [], auxLevels = [],
			ultimateData = [], auxUltimateData = {};

		labels = auxLabel.filter( (value, index, self) => {
			return self.indexOf(value) === index;
		})

		levels['lvl'] = [];
		levels['lvl'] = lvlHelper.filter( (value, index, self) => {
			return self.indexOf(value) === index;
		})

		auxLevels = levels;
		levels = [];
		for (let j = 0; j < auxLevels['lvl'].length; j++) {
			for (let i = 0; i < specialtyObj.length; i++) {
				if(specialtyObj[i].lvl === auxLevels['lvl'][j]){
					let lvlAux = auxLevels['lvl'][j], 
						auxObj = {
							sName: specialtyObj[i].sName,
							cant: specialtyObj[i].cant
						};
					if(levels[j] === undefined) levels[j] = {};
					levels[j].level = lvlAux;
					if(levels[j].sy === undefined) {
						levels[j].sy = [auxObj]
					}else{
						levels[j].sy.push(auxObj);
					}
				}
			}
		}

		labels.sort((a, b) => ( a < b ? -1 : a > b ? 1 : 0));

		for (let i = 0; i < levels.length; i++) {
			levels[i].sy.sort((a, b) => ( a.sName < b.sName ? -1 : a.sName > b.sName ? 1 : 0));
		}

		for (let i = 0; i < levels.length; i++) {
			let auxColor = getRandomColor();
			auxUltimateData = {
				label: `Nivel ${levels[i].level}`,
				borderColor: auxColor,
				pointBackgroundColor: auxColor,
				pointBorderColor: hexToRgbA(auxColor),
				backgroundColor: hexToRgbA(auxColor),
				pointHitRadius: 10,
				pointRadius: 5,
				data: levels[i].sy.map((el, i) => el.cant)
			}
			ultimateData.push(auxUltimateData);
		}

		var specialtyChart = new Chart($("#specialty"), {
			type: 'radar',
			data: {
				labels, 
				datasets: ultimateData
			}
		})
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
// })()