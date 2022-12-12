$(document).ready(function () {


    // save to db

    $(document).on("click", '#saveNotification', function (e) {
        let type = $('#typeNotification').val();
        let data = $('#dataNotification').val();
        let notification_date = $('#dateNotification').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: "POST",
            url: "save_notification",
            data: {

                'type': type,
                ' data': data,
                'notification_date': notification_date

            },
            success: function (response) {

                let message = JSON.parse(response)
                var text_button_notification = message.count_notifications
                $('#main_notification_button').text(text_button_notification);
                     
               
            }

        })

    });


    // {{-- pusher --}}

    $(document).on("click", '#sendNotification', function (e) {

        let type = $('#typeNotificationPusher').val();
        let data = $('#dataNotificationPusher').val();
        let notification_date = $('#dateNotificationPusher').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: "POST",
            url: "send_notification",
            data: {

                'type': type,
                ' data': data,
                'notification_date': notification_date

            },
            success: function (response) {


            }

        })

    });


    var pusher = new Pusher('20e6273b6c356e483906', {
        cluster: 'eu'
    });
    var channel = pusher.subscribe('notifications');
    // Pusher.logToConsole = true;
    channel.bind('App\\Events\\Notifications', function (i) {
        if (i.type == 'Pusher') {
            let token = $('#_token').val();
            let type = i.type;
            let notification_data = i.data;
            let notification_date = i.date;
            $.post('/save_notification', {
                _token: token,
                type: type,
                data: notification_data,
                notification_date: notification_date
            }, function () {
            }).done(function (response) {
            })
        }
    });

    $(document).on("click", ".notification", function (e) {

        var id = $(this).attr("id");
        var content = $(this).closest('.notification').find("#data").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: "POST",
            url: "/read_notification",
            data: {


                notification_content: content


            },
            success: function (response) {
                let message = JSON.parse(response)
                var text_button_notification = message.count_notifications
                $('#main_notification_button').text(text_button_notification)
                $('#content' + id).text(message.content);

            }

        })

    });

    // toggle notification_panel 

    $(document).on("click", ".notification_panel", function (e) {

        $("#notification_panel").fadeToggle('fast', 'linear')
      

    });

   
$(document).mouseup(function(e) 
{
    var container = $("#notification_panel");    
        container.fadeOut('slow'); 
    
});

});







