(() => {
    var loader;
	$(document).ready(function(){
        loader = new Loader();
	})

	$(document).on('change', '#fileInput', function(){
		let pattern = /(.*?)\.(zip)$/;
        if (pattern.test($(this).val())) {
        	let requestBody = new FormData(),
        		file = $(this)[0].files[0];

        	requestBody.append("file", file);
            requestBody.append("uploadSectionPhotos", 1);
            loader.in();
        	$.ajax({
                url: '../../files/php/C_Controller.php',
                type:'POST',
                data: requestBody,
                processData: false,
                contentType: false,
                cache: false,
                success: function(r){
                    console.log(r);
                    if (isNaN(parseInt(r))) {
                        r = (JSON.parse(r));
                        $(".infoValue").eq(0).html(`${r.cant}`);
                        $(".infoValue").eq(1).html(`${r.img}`);
                        $(".infoValue").eq(2).html(`${r.matches}`);
                        if (r.matches > 0) {
                            $("ul.collapsible#uploadCollapsible").fadeIn(1);
                            $(".uploaded_info.done").fadeIn(1);
                        }else{
                            $(".uploaded_info.error").fadeIn(1);
                        }
                        for (var i = 0; i < r.students.length; i++) {
                            $("ul.collection").append(`
                                <li class='collection-item avatar'>
                                    <img src='../../files/profile_photos/${r.students[i].photo}' class='circle'>
                                    <span class='title'>${r.students[i].idStudent}</span>
                                    <p>${r.students[i].name} ${r.students[i].lastName}<br></p>
                                </li>
                            `);
                        }
                        $(this).attr("disabled", 1);
                        $(".file-field .btn").attr("disabled", 1);
                        $(".file-path").attr("disabled", 1);
                        $("#reportCont").fadeIn('slow', loader.out());
                    }else {
                        loader.out();
                        let msg = (
                            r == 0 ? "Verifica que el archivo sea .ZIP" : 
                            (r == -1 ? "El servidor está teniendo problemas con el archivo, intenta más tarde" : 
                                (r == -2 ? "Verifica que el archivo no esté dañado" : 
                                    (r == -3 ? "El archivo está vacío!" : 
                                        (r == -4 ? "Ha ocurrido un problema con los nombres de las imágenes dentro del archivo compreso!" : 
                                            (r == -5 ? "Ha ocurrido un error con las fotografías anteriormente ingresadas de los estudiantes!" : "Ha ocurrido un error!")
                                            )
                                        )
                                    )
                                )
                            );
                        Materialize.toast(msg, 2000);
                    }
                }
            })
        }else{
        	$(this).val("");
        	$(".file-path").val("");
        	Materialize.toast("Seleccione un formato válido!", 2000);
        }
	})

    $(document).on('click', '.btnRefresh', function(){
        loader.in();
        $("#fileInput").val("").removeAttr('disabled');
        $(".file-path").val("").removeAttr('disabled');
        $(".file-field .btn").removeAttr('disabled');
        $("#reportCont").fadeOut('slow', function(){
            $("ul.collapsible#uploadCollapsible").fadeOut(1);
            $(".uploaded_info.done").fadeOut(1);
            $(".uploaded_info.error").fadeOut(1);
            $("ul.collection").html("");
            loader.out();
        });
    })

})()