(()=>{
    var permission = new Array(), x = 0;
    $(document).ready(function(){
        load_page();
        $('.modal').modal();;
        $('.chips').material_chip();
        $(".info_btn").click(function(){
            $('.tap-target').tapTarget('open');
        });
    });

    function load_page(){
        var loader = new Loader();
        loader.in();
        $.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data:{
                v_permissionCoordinator: 1
            }
        }).done(function(r){
            $("main .container").html(r);
            $("main").fadeIn("slow");
            permission.length = 0;
            x = 0;
        });
        loader.out();
    }

    $(document).on("click", ".btnModalOpen", function(){
        $.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data:{
                infoPermission: 1,
                idPermission: $(this).attr("id")
            }
        }).done(function(r){
            $('#modal_permission .modal-content').html(r);
        });
        $('#modal_permission').modal('open');
    });

    $(document).on("change", ".checkbox_add", function(){
        if($(this).prop("checked")){
            permission[x] = {"id": $(this).attr("id")};
            x++;
        }else{
            removeIndex($(this).attr("id"));
            x--;
        }
    });

    function removeIndex(id){
        for (var i = 0; i < permission.length; i++) {
            if (permission[i].id == id) {
                permission.splice(i,1);
            }
        }
    }

    $(document).on("click", "#btnSendPermission", function(){
        if(permission.length > 0){
            var loader = new Loader();
            loader.in();
            $.ajax({
                type: 'POST',
                url: '../../files/php/C_Controller.php',
                data:{
                    accept_permission: 1,
                    permissions: JSON.stringify(permission)
                }
            }).done(function(r){
                console.log(r);
                if(r == 1){
                    Materialize.toast("Permisos Aceptados", 3000);
                    load_page();
                }else{
                    Materialize.toast("Algo ha ocurrido mal, intente más tarde", 3000);
                }
            });
        }else{
            Materialize.toast("No hay permisos seleccionados", 3000, "red");
        }
    });
})()