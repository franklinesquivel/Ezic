$(document).ready(function(){

    var name = (document.location + "").split('/')[3],
        unLogDir = document.location.origin + "/" + name + "/General_Files/php/User_Close_Session.php",
        homeDir = document.location.host.origin + "/" + name + "/app/home/";
        loaderDir = document.location.host.origin + "/" + name + "/app/users/files/js/Loader.js";

    unLogDir = unLogDir.split('/');

    $('.button-collapse').sideNav({
    //   menuWidth: 300, // Default is 300
    //   edge: 'left', // Choose the horizontal origin
    //   closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
    //   draggable: true // Choose whether you can drag to open on touch screens
    });

    $('select').material_select();

    $('.collapsible').collapsible();
    $('.scrollspy').scrollSpy();

    $('.toc-wrapper').pushpin(function(){
        top: $('#index-banner').height()
    });

    $('.datepicker').pickadate({
        monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
        monthsShort: [ 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic' ],
        weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ],
        weekdaysShort: [ 'dom', 'lun', 'mar', 'mié', 'jue', 'vie', 'sáb' ],
        today: 'Hoy',
        clear: 'Borrar',
        close: 'Cerrar',
        firstDay: 1,
        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd',

        selectMonths: true, // Creates a dropdown to control month
        selectYears: 100 // Creates a dropdown of 15 years to control year
    });

    if ($('#tabs-swipe-demo').length) {
    //   $('#tabs-swipe-demo').tabs({ 'swipeable': true});
        $('#tabs-swipe-demo').tabs();
    }

    if ($('.dropdown-button').length) {
        $('.dropdown-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrainWidth: false, // Does not change width of dropdown to that of the activator
            // hover: true, // Activate on hover
            // gutter: 0, // Spacing from edge
            belowOrigin: false, // Displays dropdown below the button
            alignment: 'right', // Displays dropdown with edge aligned to the left of button
            stopPropagation: false // Stops event propagation
        });
    }

    function unLog(){
        var route = document.location + "", i = 0, newRoute = "", newHome = "";

        route = route.split('/');
        route.forEach(function(x){
            if( x == unLogDir[i] ){
                // console.log(x + " --- " + unLogDir[i] + "  -->  " + i);
                i++;
            }
        })

        i = route.length - 1 - i;

        for (var c = 0; c < i; c++) {
            newRoute += '../';
            newHome += '../';
        }

        newRoute += 'General_Files/php/User_Close_Session.php';
        newHome += 'app/home/'

        // console.log(newHome);

        console.log(newRoute);
        console.log(newHome);

        $.ajax({
            type: 'POST',
            url: newRoute,
            success: function(){
                location.href = newHome;
            }
        })
    }

    $('.btnUnlog').click(function(){
        unLog();
    })

    // alert(':p');

});


function validateSelect(valueSelect){
    return option = (valueSelect == null) ? false : true;
}

function errorSelect(selects){
    let z = 0; //Variable contar; obtendra cuantos select son vacios
    $(selects).each((i) => {
        if(($(selects).eq(i).val() ==  null) || ($(selects).eq(i).val().length == 0)){
            $(selects).eq(i).parent().children("input").addClass("error");
            z++;
        }else{
            $(selects).eq(i).parent().children("input").removeClass("error");
        }
    });
    return error = (z > 0) ? false : true;
}


