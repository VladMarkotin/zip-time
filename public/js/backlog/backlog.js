
$(document).on("click", ".show_edit_delete", function (e) {

    var log_id = $(this).attr("id");
    $(".action"+log_id).fadeToggle();

});

