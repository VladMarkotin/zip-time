


$(document).ready(function () {
  // $('.main-wrapper').hide();

  alertify.set('notifier', 'position', 'bottom-right');

  /**
   * BACKLOG
   */
  $(document).on("click", ".show_edit_delete", function (e) {

    var log_id = $(this).attr("id");
    $(".action" + log_id).fadeToggle();

  });


  /**
   * PUSHER
   */

  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher('957e0c47c6b91b024fe3', {
    cluster: 'eu'
  });

  var channel = pusher.subscribe('ziptime');
  channel.bind('notice', function (data) {

    if (data.type == 'Pusher') {

      let token = $('#_token').val();
      let type = data.type;
      let notification_data = data.data;
      let notification_date = data.date;
      $.post('/save_notification', {
        _token: token,
        type: type,
        data: notification_data,
        notification_date: notification_date
      }, function () { }).done(function (response) {
      })
    }

  });


  /**
   * NOTIFICATIONS
   */

  $(document).on("click", '#saveNotification', function (e) {
    let type = $('#type').val();
    let data = $('#data').val();
    let notification_date = $('#notification_date').val();
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

        resetModalFields()   // Empty modal inputs on send
        $('#exampleModal').modal('hide');   // hide modal
        $('input').removeClass("is-invalid");  // remove error class on success
        alertify.notify('Notification Added Successfuly');
        $("#notification_section").load(" #notification_section");  //reload notification section on success
      },
      error: function (response) {
        var data = JSON.parse(response.responseText);
        alertify.notify(data.message);
        $.each(data, function (i, item) {
          $.each(data.errors, function (key, value) {
            $('#' + key).attr("class", "form-control is-invalid");  // add error class to input field if any errors

          });
        });
      },
    })
  });


  /**
   * PUSHER
   */
  $(document).on("click", '#sendNotification', function (e) {
    let type_pusher = $('#type_pusher').val();
    let data_pusher = $('#data_pusher').val();
    let notification_date_pusher = $('#notification_date_pusher').val();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      method: "POST",
      url: "send_notification",
      data: {

        'type_pusher': type_pusher,
        ' data_pusher': data_pusher,
        'notification_date_pusher': notification_date_pusher
      },
      success: function (response) {
        resetModalFields()
        $('#exampleModal2').modal('hide');
        $('input').removeClass("is-invalid");
        alertify.notify('Notification Sent Successfuly');
        $("#notification_section").load(" #notification_section");
      },
      error: function (response) {
        var data = JSON.parse(response.responseText);
        alertify.notify(data.message);
        $.each(data, function (i, item) {
          $.each(data.errors, function (key, value) {
            $('#' + key).attr("class", "form-control is-invalid");

          });
        });
      },

    })

  });



  window.addEventListener("load", function () {
    document.querySelector('.notifications').addEventListener('click', e => {
      let content = e.target.innerHTML;
      e.target.outerHTML = content;
      let token = $('#_token').val();
      $.post('/read_notification', {
        _token: token,
        notification_content: content
      }, function () { }).done(function (response) {

        let message = JSON.parse(response)
        var text_button_notification = message.count_notifications
        $('#main_notification_button').text(text_button_notification);

      })
    });
  })



  /**
   * RESET MODAL ENTRIES
   */
  function resetModalFields() {
    $('#type').val('');
    $('#data').val('');
    $('#data_pusher').val('');
    $('#notification_date').val('');
    $('#notification_date_pusher').val('');
  }


  /*
    *GLEAP FEEDBACK
   */

  // ! function (Gleap, t, i) {
  //   if (!(Gleap = window.Gleap = window.Gleap || []).invoked) {
  //     for (window.GleapActions = [], Gleap.invoked = !0, Gleap.methods = ["identify", "clearIdentity",
  //       "attachCustomData", "setCustomData", "removeCustomData", "clearCustomData", "registerCustomAction",
  //       "logEvent", "log", "preFillForm", "sendSilentCrashReport", "startFeedbackFlow", "setAppBuildNumber",
  //       "setAppVersionCode", "preFillForm", "setApiUrl", "setFrameUrl", "isOpened", "open", "close", "on",
  //       "setLanguage", "setOfflineMode", "initialize"
  //     ], Gleap.f = function (e) {
  //       return function () {
  //         var t = Array.prototype.slice.call(arguments);
  //         window.GleapActions.push({
  //           e: e,
  //           a: t
  //         })
  //       }
  //     }, t = 0; t < Gleap.methods.length; t++) Gleap[i = Gleap.methods[t]] = Gleap.f(i);
  //     Gleap.load = function () {
  //       var t = document.getElementsByTagName("head")[0],
  //         i = document.createElement("script");
  //       i.type = "text/javascript", i.async = !0, i.src = "https://sdk.gleap.io/latest/index.js", t
  //         .appendChild(i)
  //     }, Gleap.load(),
  //       Gleap.initialize("MMrWTm1w4laW6B2JsT1qPwMxqb1dsyzI")
  //   }
  // }();


  /* 
   * LIVEWIRE
  */

  /* hide backlog modal for livewire --*/

  window.livewire.on('userStore', () => {
    $('#exampleModal').modal('hide');
  });

  /* notifyJs for livewire --*/
  window.addEventListener('message', event => {
    alertify.notify(event.detail.text);
  });


/**
 * Feedback
 */
$(document).on("click", '#feedback', function (e) {

  $('.main-wrapper').fadeToggle();

});

$(document).on("click", '#feedback-report', function (e) {


  $('.feedback-main').hide();
  $('.feedback-bug').fadeIn();
 
});

$(document).on("click", '#feedback-request', function (e) {

  $('.feedback-main').hide();
  $('.feedback-request').fadeIn();
});

$(document).on("click", '#feedback-contact', function (e) {
  $('.feedback-main').hide();
  $('.feedback-contact').fadeIn();

});

$(document).on("click", '#feedback-close', function (e) {

  $('.main-wrapper').fadeOut();

});

$(document).on("click", '#feedback-back', function (e) {

  $('.feedback-bug').hide();
  $('.feedback-request').hide();
  $('.feedback-contact').hide();
  $('.feedback-main').show();
});


/**
 * gpt
 */

$(document).on("click", '#gpt', function (e) {

  $('.gptContainer').toggle();

});

$(document).on("click", '#gpt-close', function (e) {

  $('.gptContainer').hide();

});

$('.c-toggle').on( "mouseover", function() {
  show('personal-results')
} );















































  /* pusher */

  // window.addEventListener("load", function () {
  //   $('body').on('click', '#sendNotification', function () {
  //     let token = $('#_token').val();
  //     let type = $('#typeNotificationPusher').val();
  //     let data = $('#dataNotificationPusher').val();
  //     let notification_date = $('#dateNotificationPusher').val();

  //     $.post('/send_notification', {
  //       _token: token,
  //       type: type,
  //       data: data,
  //       notification_date: notification_date
  //     }, function () { }).done(function (response) {
  //       $('#sendToPusher').modal('hide');
  //     })
  //   })
  // })




  /* Notifications */


  // var pusher = new Pusher('20e6273b6c356e483906', {
  //   cluster: 'eu'
  // });

  // var channel = pusher.subscribe('notifications');
  // // Pusher.logToConsole = true;
  // channel.bind('App\\Events\\Notifications', function (i) {

  //   if (i.type == 'Pusher') {

  //     let token = $('#_token').val();
  //     let type = i.type;
  //     let notification_data = i.data;
  //     let notification_date = i.date;


  //     $.post('/save_notification', {
  //       _token: token,
  //       type: type,
  //       data: notification_data,
  //       notification_date: notification_date
  //     }, function () { }).done(function (response) {

  //     })
  //   }
  // });

  // window.addEventListener("load", function () {
  //   $('body').on('click', '#saveNotification', function () {

  //     let token = $('#_token').val();
  //     let type = $('#typeNotification').val();
  //     let data = $('#dataNotification').val();
  //     let notification_date = $('#dateNotification').val();

  //     $.post('/save_notification', {
  //       _token: token,
  //       type: type,
  //       data: data,
  //       notification_date: notification_date
  //     }, function () { }).done(function (response) {
  //       $('#addNotification').modal('hide');
  //       $("#notification_section").load(" #notification_section");

  //       alertify.set('notifier', 'position', 'bottom-right');
  //       alertify.notify('Notification Added Successfuly');


  //     })
  //   })
  // })




});


