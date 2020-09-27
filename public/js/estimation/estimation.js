/**
 * Created by Vlad on 21.07.2020.
 */

//alert("Hi"); works
function ajaxPost(data){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post( "/estimate", data, null, "json" )
        .done(function( response ) {
            $("#info").append('<div class= "'+ response.decoration + '"' + 'role="alert">' +
            response.message +
            '</div>');
            $("#info").slideUp(5000);
        });

}

$(document).keypress(function (event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    var marks = [];
    var flag = false;
    if (keycode == '13') {
        $('input').each(function (){
            if($(this).is(':checkbox')) {
                if ($(this).is(":checked")) {
                    marks.push(99);
                }
                else if (!$(this).is(":checked")) {
                    marks.push(50);
                }
            }else{
                marks.push($(this).val());
            }

        });
        marks.shift();
        $.each(marks, function (index,value) {
            if( value != ''){
                console.log(value);
                flag = true;
            }
        });
        if(flag){
            console.log(marks);
            //marks.shift();
            var jsonMarks = JSON.stringify(marks);
            console.log(jsonMarks);
            ajaxPost(jsonMarks);
        }
    }
});
