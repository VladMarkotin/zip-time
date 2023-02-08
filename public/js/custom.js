$(document).ready(function () {


/* Backlog */
$(document).on("click", ".show_edit_delete", function (e) {

  var log_id = $(this).attr("id");
  $(".action" + log_id).fadeToggle();

});




/* Notifications */


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
    }, function () { }).done(function (response) {

    })
  }
});



window.addEventListener("load", function () {
  $('body').on('click', '#saveNotification', function () {

    let token = $('#_token').val();
    let type = $('#typeNotification').val();
    let data = $('#dataNotification').val();
    let notification_date = $('#dateNotification').val();

    $.post('/save_notification', {
      _token: token,
      type: type,
      data: data,
      notification_date: notification_date
    }, function () { }).done(function (response) {
      $('#addNotification').modal('hide');
      $("#notification_section").load(" #notification_section");

      alertify.set('notifier', 'position', 'bottom-right');
      alertify.notify('Notification Added Successfuly');


    })
  })
})


/* pusher */

window.addEventListener("load", function () {
  $('body').on('click', '#sendNotification', function () {
    let token = $('#_token').val();
    let type = $('#typeNotificationPusher').val();
    let data = $('#dataNotificationPusher').val();
    let notification_date = $('#dateNotificationPusher').val();

    $.post('/send_notification', {
      _token: token,
      type: type,
      data: data,
      notification_date: notification_date
    }, function () { }).done(function (response) {
      $('#sendToPusher').modal('hide');
    })
  })
})



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


/*
*Gleap get Feedback

 */

! function (Gleap, t, i) {
  if (!(Gleap = window.Gleap = window.Gleap || []).invoked) {
    for (window.GleapActions = [], Gleap.invoked = !0, Gleap.methods = ["identify", "clearIdentity",
      "attachCustomData", "setCustomData", "removeCustomData", "clearCustomData", "registerCustomAction",
      "logEvent", "log", "preFillForm", "sendSilentCrashReport", "startFeedbackFlow", "setAppBuildNumber",
      "setAppVersionCode", "preFillForm", "setApiUrl", "setFrameUrl", "isOpened", "open", "close", "on",
      "setLanguage", "setOfflineMode", "initialize"
    ], Gleap.f = function (e) {
      return function () {
        var t = Array.prototype.slice.call(arguments);
        window.GleapActions.push({
          e: e,
          a: t
        })
      }
    }, t = 0; t < Gleap.methods.length; t++) Gleap[i = Gleap.methods[t]] = Gleap.f(i);
    Gleap.load = function () {
      var t = document.getElementsByTagName("head")[0],
        i = document.createElement("script");
      i.type = "text/javascript", i.async = !0, i.src = "https://sdk.gleap.io/latest/index.js", t
        .appendChild(i)
    }, Gleap.load(),
      Gleap.initialize("MMrWTm1w4laW6B2JsT1qPwMxqb1dsyzI")
  }
}();



/* 

Livewire

*/

/* hide backlog modal for livewire --*/

window.livewire.on('userStore', () => {
  $('#exampleModal').modal('hide');
});

/* notifyJs for livewire --*/
window.addEventListener('message', event => {
  alertify.notify(event.detail.text);
});

});
