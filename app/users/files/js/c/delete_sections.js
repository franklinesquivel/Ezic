(()=>{
    var sections = new Array();
    var x = 0;
    $(document).ready(function(){
        load_page();
    });

    function load_page(){
        let loader = new Loader();
        loader.in();
        $.ajax({
            type: 'POST',
			url: '../../files/php/C_Controller.php',
			data:{
				v_deleteSection: 1
			}
        }).done(function(r){
            sections.length = 0;
            x = 0;
            $('main .container').html(r);
            $('main').fadeIn('slow');
        });
        loader.out();
    }

    $(document).on("change", ".btn_checkbox", function(){
		if($(this).prop("checked")){
			sections[x] = {"id": $(this).attr("id")};
			x++;
		}else{
			removeIndex($(this).attr("id"));
			x--;
		}
		// console.log(JSON.stringify(sections));
	});

	function removeIndex(id){
		for (var i = 0; i < sections.length; i++) {
			if (sections[i].id == id) {
				sections.splice(i,1);
			}
		}
    }
    
    $(document).on('click', '.btnSave', function(){
        if(sections.length > 0){
            let object = JSON.stringify(sections);
            let loader = new Loader();
            loader.in();
            $.ajax({
                type: 'POST',
                url: '../../files/php/C_Controller.php',
                data:{
                    deleteSection: 1,
                    sections: object
                }
            }).done(function(r){
                if(r == 1){
                    Materialize.toast('Eliminación exitosa', 3000);
                    load_page();
                }else{
                    Materialize.toast('Ha ocurrido un error', 3000, 'red');
                }
                loader.out();
            });
        }else{
            Materialize.toast('Seleccione secciones a eliminar', 3000, 'red');
        }
        
    });
})()