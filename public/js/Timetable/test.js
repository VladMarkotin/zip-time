/**
 * Created by Vlad on 26.04.2020.
 */

class Plan {

    setParams = function (arg){
        this.tasks = arg;
        this._token = '{{csrf_token()}}';
    }
}

var inputQuant = 3;




function ajaxPost(data){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post( "/add", data, null, "json" )
        .done(function( response ) {
            console.log( "Data Loaded: " + response.decoration );
            $("#info").append('<div class= "'+ response.decoration + '"' + 'role="alert">' +
            response.message +
            '</div>');
            $("#info").slideUp(5000);
        });
}

/*Объект план на день*/
var dayPlan = {
    task: "",
    time: ""
};
var planArray = [];
var dayPlanJson;
/*конец*/

$("#addRequiredTask").click(function() {
    var inputsForWork = "<hr/><div class='list-inline'>" +
        "<input type='text' title='Короткое название задания' size='32' placeholder='Короткое название задания'>" +
            "<input type='time' title='Примерное время выполнения' placeholder='Примерное время выполнения'>" +
                "<input type='text' title='Примечания' placeholder='Примечания'></div>" +
                    "<input type='hidden' value='2'></div>"; //0 - задача, 1 - необязательное, 2 - обязательное

    var status = $("#status").val();
    $("#dayStatus").text("Статус дня: " + status);
    if(status == "Ред"){
        $("#list").append(inputsForWork);
    }
});

$("#addNonRequieredTask").click(function (){
    var status = $("#status").val();
    var inputsForWork2 = "<hr/><div class='list-inline'>" +
        "<input type='text' title='Короткое название задания' size='32' placeholder='Короткое название задания'>" +
            "<input type='time' title='Примерное время выполнения' placeholder='Примерное время выполнения'>" +
                "<input type='text' title='Примечания' placeholder='Примечания'></div>" +
                    "<input type='hidden' value='1'></div>"; //0 - задача, 1 - необязательное, 2 - обязательное;

    if(status == "Ред"){
        $("#list2").append(inputsForWork2);
    }
});

$('#save').click(function (e){
    e.preventDefault();
    var plan = (new Plan());
    var arr = [];
    var len = $("input").length;

    for(var i = 0; i < len; i++){
        arr.push($("input").eq(i).val());
    }
    arr.push($("#status").val());

    var buf = [];
    var j = 0;
    while(j < len){
        buf.push(arr.slice(j, j + 4));
        j += 4;
    }
    plan.setParams(buf);
    plan = JSON.stringify(plan);
    //console.log(plan);
    ajaxPost(plan);
});