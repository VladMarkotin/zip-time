/**
 * Created by Vlad on 06.08.2020.
 */

function addTask(){
    console.log($("#newTaskForm").serialize() );
    var newTask = $("#newTaskForm").serializeArray();
}



function save()
{
    var data = {
        "shortName": '',
        "time"     : '',
        'note'     : '',
        'status'   : '',
        'added'    :  ''
    };
    data.shortName = ($("#short").val() );
    data.time = ($("#time").val() );
    data.note = ($("#note").val() );
    data.status = ($("#status").val() );
    data.added  = '1';

    if( (data.shortName != '') && (data.time != '')) {
        var request = JSON.stringify(data);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post('/addwork ', request)
            .done(function(response){
                $("#info").removeClass();
                $("#info").empty();
                $("#info").append('<div class= "'+ response.decoration + '"' + 'role="alert">' +
                response.message +
                '</div>');
                //$("#info").slideUp(5000);
            }); //works!
    }

}