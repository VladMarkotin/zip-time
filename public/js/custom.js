


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
   * NOTIFICATIONS
   */


  $('#bell').click(function (event) {
    event.stopPropagation();
    $(".notification-wrapper").slideToggle('fast');
  });
  $(".notification-wrapper").on("click", function (event) {
    event.stopPropagation();
  });


  $(document).on("click", function () {
    $(".notification-wrapper").hide();
  });



  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher('957e0c47c6b91b024fe3', {
    cluster: 'eu'
  });

  var channel = pusher.subscribe('ziptime');
  channel.bind('notice', function (data) {

    let type = data.type;
    let notification_data = data.data;
    let notification_date = data.date;
    var csrf = document.querySelector('meta[name="csrf-token"]').content;

    $.post('/save_notification', {
      _token: csrf,
      type: type,
      data: notification_data,
      notification_date: notification_date
    }, function () { }).done(function (response) {

      alertify.notify('Message Brodcasted');
    })
  });




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


  $('.c-toggle').on("mouseover", function () {
    show('personal-results')
  });




});


