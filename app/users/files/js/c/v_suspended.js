(()=>{
    // var suspended = new Array(), x = 0;

    $(document).ready(function(){
        load_page();
    });

    function load_page(){
        $.ajax({
            type: 'POST',
            url: './../../files/php/C_Controller.php',
            data:{v_suspended: 1}
        }).done(function(r){
            $('main .container').html(r);
            $('main').fadeIn('slow');
        });
    }

    // $(document).on("change", ".btn_checkbox", function(){
	// 	if($(this).prop("checked")){
	// 		suspended[x] = {"id": $(this).attr("id")};
	// 		x++;
	// 	}else{
	// 		removeIndex($(this).attr("id"));
	// 		x--;
	// 	}
	// });

	// function removeIndex(id){
	// 	for (var i = 0; i < suspended.length; i++) {
	// 		if (suspended[i].id == id) {
	// 			suspended.splice(i,1);
	// 		}
	// 	}
    // }

    function getInfoStudent(){
        let j = 0, students =  new Array();
        for(var i = 0; i < $('table tbody tr input.btn_checkbox').length; i++){
            if($('table tbody tr input.btn_checkbox').eq(i).prop('checked')){
                students[j] = {
                    "id": $('table tbody tr input.btn_checkbox').eq(i).attr('id'),//Id del Suspended
                    "student": $('table tbody tr input.btn_checkbox').eq(i).parent().parent().children('td').eq(1), //Codigo
                    "startDate": $('table tbody tr input.btn_checkbox').eq(i).parent().parent().children('td').eq(3)
                };
                j++;
            }
        }
        return (j = (j > 0) ? JSON.stringify(students) : false);
    }
    
    $(document).on('click', '.btnSave', function(){
        let object = getInfoStudent();
        if(object != false){
            $.ajax({
                type: 'POST',
                url: './../../files/php/C_Controller.php',
                data:{
                    remove_suspended: 1,
                    students: object
                }
            }).done(function(r){

            });
        }else{
            Materialize.toast("Seleccionar suspenciones a eliminar", 3000, "red");
        }
    });
})()