/**
 * Created by Vlad on 05.09.2020.
 */

function emergencyRequest(){
    var data = {
        "cause": ''
    };
    var cause = $("#emergencyTextarea").val();
    if(cause){
        console.log(cause);
        data.cause = cause;
        var request = JSON.stringify(data);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('/emergency ', request)
                .done(function(response){
                    $("#emergencyInfo").removeClass();
                    $("#emergencyInfo").empty();
                    $("#emergencyInfo").append('<div class= "'+ response.decoration + '"' + 'role="alert">' +
                    response.message +
                    '</div>');
                    $("#emergencyInfo").slideUp(5000);
                }); //works!
    } else{
        $("#emergencyInfo").addClass("alert alert-danger");
        $("#emergencyInfo").text("Причина должна быть указана обязательно!");
        $("#emergencyInfo").slideUp(5000);
    }
}

