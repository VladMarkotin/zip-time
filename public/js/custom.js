


$(document).ready(function () {

 
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

  $(document).on('click', function (e) {
    if ($(e.target).closest(".notification-wrapper").length === 0) {
      $(".notification-wrapper").slideUp('fast');
    }
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
  
    Livewire.emit('saveNotification', type, notification_data, notification_date);
    alertify.notify('New Brodcasted');
    
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


  $('#feedback').click(function (event) {
    event.stopPropagation();
    $(".main-wrapper").slideToggle('fast');
  });


  $(document).on('click', function (e) {
    if ($(e.target).closest(".main-wrapper").length === 0) {
      $(".main-wrapper").hide();
    }
  });




  $(document).on("click", '#feedback-report', function (e) {


    $('.feedback-main').hide();
    $('.feedback-bug').fadeIn('fast');

  });

  $(document).on("click", '#feedback-request', function (e) {

    $('.feedback-main').hide();
    $('.feedback-request').fadeIn('fast');
  });

  $(document).on("click", '#feedback-contact', function (e) {
    $('.feedback-main').hide();
    $('.feedback-contact').fadeIn('fast');

  });

  $(document).on("click", '#feedback-close', function (e) {

    $('.main-wrapper').hide();

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


