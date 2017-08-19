(()=>{

    var idPermission = 0, idProfile = 0, studentGrades = new Array();
    $(document).ready(function(){
        load_page();
        $('.modal').modal();
    });

    function load_page(){
        $.ajax({
            type: 'POST',
            url: '../../files/php/T_Controller.php',
            data:{
                modify_grade: 1
            }
        }).done(function(r){
            $('main .container').html(r);
            $('main').fadeIn('slow');
        });
    }

    $(document).on('click', '.btnModalOpen', function(){
        if($(this).attr('id') != null){
            idPermission = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: '../../files/php/T_Controller.php',
                data:{
                    getInfoPermission: 1,
                    idPermission: idPermission
                }
            }).done(function(r){
                $("#modal1 .modal-content").html(r);
				$('#modal1').modal('open');
            });
        }
    });

    $(document).on('click', '.select_profile', function(){
        if($(this).attr('id') != null){
            idProfile = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: '../../files/php/T_Controller.php',
                data:{
                    listStudentModification: 1,
                    idPermission: idPermission,
                    idProfile: idProfile
                }
            }).done(function(r){
                $('#modal1').modal('close');
                $('main .container').html(r);
                $('main').fadeIn('slow');
            });
        }
    });

    $(document).on('click', '.btnSave', function(){
        if(validateInputs()){
            $.ajax({
                type: 'POST',
                url: '../../files/php/T_Controller.php',
                data:{
                    updateGrades: 1,
                    idPermission: idPermission,
                    idProfile: idProfile,
                    json_students: SaveGrade()
                }
            }).done(function(r){
                alert(r);
            });
        }else{
            Materialize.toast("No dejar campos vacíos", 3000, "red");
        }
    });

    const validateInputs = () =>{
		let z = 0;
		for (var i = 0; i < $("tbody tr").length; i++) {
			if ($("tbody input[type=number]").eq(i).val() == "" || 
				(parseFloat($("tbody input[type=number]").eq(i).val()) > 10 )|| 
				(parseFloat($("tbody input[type=number]").eq(i).val()) < 0 )) {
				console.log("error");
				$("tbody input[type=number]").eq(i).addClass("error");
				z++;
			}else{
				$("tbody input[type=number]").eq(i).removeClass("error");
			}
		}
		return (z = (z > 0) ? false : true);
	};

	const SaveGrade = () =>{
		for (var i = 0; i < $("tbody tr input[type=number]").length; i++) {
			studentGrades[i] = {
				"idStudent": $("tbody tr input[type=number]").eq(i).attr("id"),
				"Grade": $("tbody tr input[type=number]").eq(i).val()
			};
		}
		return JSON.stringify(studentGrades);
	};
})()