var loader;

    function loader(obj){
        this.obj = obj;
        this.in = function(){
            this.obj.fadeIn('slow');
            this.obj.css('display', 'flex');
        }
    
        this.out = function(){
            this.obj.fadeOut('slow');
        }
    }

$(document).ready(function(){
    loader = new loader($('.loader_cont'));
    loader.in();
    $("#logo-container img").width($("#logo-container img").height());

    $('.homeSlider').slider({
        height: 500
    });

    $('.btnHome').sideNav({
      menuWidth: 300, // Default is 300
      edge: 'left', // Choose the horizontal origin
      closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
      draggable: true // Choose whether you can drag to open on touch screens
    });

    $('.parallax').parallax();

    $('.modal').modal();

    // if ($('ul#tabs_').length) {
    //     $('ul#tabs_').tabs();
    // }


    $('#logModal').modal({
        dismissible: true, // Modal can be dismissed by clicking outside of the modal
        opacity: .5, // Opacity of modal background
        inDuration: 300, // Transition in duration
        outDuration: 200, // Transition out duration
        startingTop: '4%', // Starting top style attribute
        endingTop: '10%', // Ending top style attribute
        complete: function() {
            $('#logModal input').each(function(){
                $(this).val('');
            })
        }
    })

    $.validator.addMethod('studentCode', function(value, element) {
        return this.optional(element) || /^[a-zA-Z]{2}\d{4}$/.test(value);
    }, 'Ingrese un valor válido.');

    $.validator.addMethod('workerCode', function(value, element) {
        return this.optional(element) || /^([Cc]|[Dd])\d{4}$/.test(value);
    }, 'Ingrese un valor válido.');

    $('form.studentLog').validate({
        rules: {
            txtSCode: {
                required: true,
                studentCode: true
            },
            txtSPass: {
                required: true
            }
        },
        messages: {
            txtSCode:{
                required: 'Ingrese un código.'
            },
            txtSPass: {
                required: 'Ingrese una contraseña.'
            }
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            loader.in();
            $.ajax({
                method: 'POST',
                url: 'php/login.php',
                data: {
                    code: $('#txtSCode').val().toUpperCase(),
                    pass: $('#txtSPass').val(),
                    type: 'S'
                },
                success: function(r){
                    // console.log(r);
                    loader.out();
                    if( parseInt(r) ){
                        location.href = '../users/student/';
                    }else{
                        $('#txtSCode').val('');
                        $('#txtSPass').val('');
                        Materialize.updateTextFields();
                        $('#txtSCode').focus();
                        Materialize.toast('El usuario no ha sido encontrado!', 1000);
                    }
                }
            })
        }
    });

    $('form.workerLog').validate({
        rules: {
            txtWorkerCode: {
                required: true,
                workerCode: true
            },
            txtWorkerPass: {
                required: true
            }
        },
        messages: {
            txtWorkerCode:{
                required: 'Ingrese un código.'
            },
            txtWorkerPass: {
                required: 'Ingrese una contraseña.'
            }
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            var workerCode = $('#txtWorkerCode').val(),
                workerPass = $('#txtWorkerPass').val(),
                type = ( workerCode[0].toUpperCase() == 'C' ) ? 'C' : 'T';
            loader.in();
            $.ajax({
                method: 'POST',
                url: 'php/login.php',
                data: {
                    code: workerCode.toUpperCase(),
                    pass: workerPass,
                    type: type
                },
                success: function(r){
                    // console.log(r);
                    loader.out();
                    if( parseInt(r) ){
                        location.href = '../users/' + (( type == 'C' ) ? 'coordinator' : 'teacher') + '/';
                    }else{
                        $('#txtWorkerCode').val('');
                        $('#txtWorkerPass').val('');
                        Materialize.updateTextFields();
                        $('#txtWorkerCode').focus();
                        Materialize.toast('El usuario no ha sido encontrado!', 1000);
                    }
                }
            })
        }
    });

    $("body").fadeIn('slow', loader.out());
    
    $(window).resize(function(){
        $("#logo-container img").width($("#logo-container img").height());
    })

    $(window).scroll(function(){
        $("#logo-container img").width($("#logo-container img").height());
    })
})

