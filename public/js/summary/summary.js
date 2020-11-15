/**
 * Created by Vlad on 27.09.2020.
 */
/*Подводим итоги дня*/
function ajaxPost2(data){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post( "/approve", data, null, "json" )
        .done(function( response ) {
            $("#info").append('<div class= "'+ response.decoration + '"' + 'role="alert">' +
            response.message +
            '</div>');
            $("#info").slideUp(5000);
        });

}

function ApproveRequest() {
  var own_mark = 0;
  var comment = '';
  var necessary = '';
  var for_tomorrow = '';
}

function closeDay(){
    //alert("uygf"); //works
    var request = new ApproveRequest();
    request.own_mark     = $("#own_mark").val();
    request.comment      = $("#approveComment").val();
    request.necessary    = $("#necessary").val();
    request.for_tomorrow = $("#for_tomorrow").val();
    request.status       = $("#dayStatus").text();

    var jsonRequest = JSON.stringify(request);
    //console.log(jsonRequest);
    ajaxPost2(jsonRequest);
}

function blockAllInputs(){
    alert("hgyu");
    $("input").prop( "disabled", true );
}
