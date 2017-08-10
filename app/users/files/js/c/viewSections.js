(() => {
    var loader;
	$(document).ready(function(){
        loader = new Loader();
        loader.in()
		$.ajax({
            url: '../../files/php/C_Controller.php',
            data: {getLvls: 1},
            success: (r) => {
                if (r != -1) {
                    $('#cmbLevel').append(r);
                    $('select').material_select();
                    search_section();
                }
                loader.out();
            }
        })

        $('#cmbLevel').change(() => {
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {getSpecialties: 1, lvl: $("#cmbLevel").val()},
                success: function(r){
                    if (r != -1) {
                        $("#cmbSpecialty").empty();
                        $("#cmbSection").empty();
                        $("#cmbSpecialty").html("<option disabled selected>Especialidad</option>");
                        $("#cmbSection").html("<option disabled selected>Sección</option>");
                        $('#cmbSpecialty').append(r);
                        $('select').material_select();
                        search_section($("#cmbLevel").val());
                    }else{
                        Materialize.toast('No se encontraron registros de especialidades para mostrar', 1000); 
                        $("#cmbSpecialty").empty();
                        $("#cmbSection").empty();
                        $("#cmbSpecialty").html("<option disabled selected>Especialidad</option>");
                        $("#cmbSection").html("<option disabled selected>Sección</option>");
                        $('select').material_select();
                        search_section($("#cmbLevel").val());
                    }
                }
            })
        })

        $('#cmbSpecialty').change(() => {
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {returSections: 1, specialty: $("#cmbSpecialty").val()},
                success: function(r){
                    if (r != -1) {
                        $("#cmbSection").html("<option disabled selected>Sección</option>");
                        $('#cmbSection').append(r);
                        $('select').material_select();
                        search_section($("#cmbLevel").val(), $("#cmbSpecialty").val());
                    }else{
                        Materialize.toast('No se encontraron registros de especialidades para mostrar', 3000); 
                    }
                }
            })
        })

        $('#cmbSection').change(() => {
            search_section($("#cmbLevel").val(), $("#cmbSpecialty").val(), $("#cmbSection").val());
        })

	})

    const search_section = (lvl = '', spcty = '', sctn = '') => {
        loader.in()
    	$.ajax({
    		url: '../../files/php/C_Controller.php',
    		data: {filterSections: 1, lvl, spcty, sctn},
    		success: r => {
    			// console.log(r);
    			$(".sectionCollection").html(r);
                loader.out();
    		}
    	})
    }
})()