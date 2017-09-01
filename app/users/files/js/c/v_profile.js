$(document).ready(function(){
	var loader = new Loader();
	class Element {
        constructor(type) {
            this.element = document.createElement(type);
        }

        setClass(c){
            this.element.setAttribute('class', c);
        }

        setId(c){
            this.element.setAttribute('id', c);
        }

        setAttr(attr, value){
            this.element.setAttribute(attr, value);
        }

        add_el(element){
            this.element.append(element);
        }

        content(content){
            this.element.innerHTML = content;
        }

        clearContent(){
            this.element.innerHTML = "";
        }
    }

	$("#selectSubject").change("value", function(){
		$(".v_table").empty();
		$(".btn_periodContainer ul li.btn_options").remove();
		if((validateSelect($("#selectSubject").val()))==true){
			loader.in();
			$.ajax({
				type: 'POST',
				url: './../../files/php/C_Controller.php',
				data:{
					profile_view: 'Si',
					subject: $(this).val()
				}
			}).done(function(r){
				let object = JSON.parse(r);
				if (object.length > 0) {//Objeto con perfiles
					let table = create_table(object);
					$(".v_table").fadeIn("slow", function(){
						$(".v_table").html(table);
					});
				}else{
					$(".v_table").html("<div class='result_cont'><div class='search_error col s8 offset-s2'><span>La asignatura no cuenta con perfiles de evaluación</span</div></div>");
				}
				loader.out();
			});
		}
	});

	$("#selectTeacher").change("value", function(){
		if(validateSelect($(this).val())){
			$.ajax({
				type: 'POST',
				url: './../../files/php/C_Controller.php',
				data:{
					choose_subjectForTeacher: 1,
					teacher: $(this).val()
				}
			}).done(function(r){
				let object = JSON.parse(r);
				$("#selectSubject").empty();
				$("#selectSubject").append("<option value='' disabled selected>Elegir Materia</option>");
				if (object.length > 0) {
					for (var i in object) {
						$("#selectSubject").append("<option value='"+object[i].id+"'>"+object[i].level+"° "+object[i].name+"</option>");
						$("#selectSubject").material_select();
					}
				}
				$("#selectSubject").material_select();
			});
		}
	});

	var create_table = (object) =>{
		let table, div, thead, tr = new Array(), th = new Array(3), tbody, td = new Array(), z = 0, li = new Array(), a = new Array(), Period_ID;
		div = new Element('div');
		div.setClass('row col l8 m10 s10 offset-l2 offset-m1 offset-s1');
		table = new Element('table');
		table.setClass('centered responsive-table');

		//CABEZA
		thead = new Element('thead');
		tr[z] = new Element('tr');
		th[0] = new Element('th'); th[1] = new Element('th'); th[2] = new Element('th'); th[3] = new Element('th');
		th[0].content("# Perfil"); th[1].content("Nombre"); th[2].content("Porcentaje (%)"); th[3].content("Período");
		tr[z].add_el(th[0].element); tr[z].add_el(th[1].element); tr[z].add_el(th[2].element); tr[z].add_el(th[3].element);
		thead.add_el(tr[z].element);

		//CUERPO
		tbody = new Element('tbody');
		for(var i in object){
			z++;
			tr[z] = new Element('tr');
			tr[z].setAttr("id", object[i].period);

			td[i] = new Element('td');
			td[i].content(z);
			td[i+1] = new Element('td');
			td[i+1].content(object[i].name);
			td[i+2] = new Element('td');
			td[i+2].content(object[i].percentage);
			td[i+3] = new Element('td');
			td[i+3].content(object[i].period);

			tr[z].add_el(td[i].element);
			tr[z].add_el(td[i+1].element);
			tr[z].add_el(td[i+2].element);
			tr[z].add_el(td[i+3].element);
			tbody.add_el(tr[z].element);

			//Creación y agregar los periodos al boton flotante
			if (object[i].period != Period_ID) {
				li[i] = new Element('li');
				li[i].setClass('btn_options');
				li[i].setAttr("id", object[i].period);
				a[i] = new Element('a');
				a[i].setClass('btn-floating teal accent-4');
				a[i].content(object[i].period);
				li[i].add_el(a[i].element);
				li[i].setAttr('title', 'Período');
				$('.btn_periodContainer ul').append(li[i].element);
			}

			Period_ID = object[i].period;
		}
		table.add_el(thead.element);
		table.add_el(tbody.element);
		div.add_el(table.element);
		return (div.element);
	};

	$('.info_btn').click(function(){
        $('.tap-target').tapTarget('open');
    });

	$(".refresh").click(function(){
        loader.in();
        $("#selectSubject").val('');
        $("#selectTeacher").val('');
        $("#selectSubject").material_select();
        $(".v_table").empty();
        $("#selectTeacher").material_select();
        $(".btn_periodContainer ul li.btn_options").remove();
        loader.out();
    });

   	
});

$(document).on("click", ".btn_options", function(){
	for (var i = 0; i < $("tbody tr").length; i++) {
		if ($("tbody tr").eq(i).attr("id") == $(this).attr("id")) {
			$("tbody tr").eq(i).show();
		}else{
			$("tbody tr").eq(i).hide();
		}
	}
});
