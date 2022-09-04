
$(document).on("click", ".add", function (e) {

    var log_id = $(this).attr("id");
    $(".action"+log_id).fadeToggle();

});