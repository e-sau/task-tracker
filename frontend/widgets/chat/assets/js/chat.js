let chat = new WebSocket('ws://task-tracker:8080');
let username = $('meta[name=chat-widget-username]').attr('content');
let task_id = $('meta[name=chat-widget-task-id]').attr('content');
let project_id = $('meta[name=chat-widget-project-id]').attr('content');
let SHOW_HISTORY = 1;
let SEND_MESSAGE = 2;

chat.onmessage = function (e) {
  // console.log(e);
  let response = JSON.parse(e.data);
  $('.chat__frame').append('<div>' +
    (response.created_at ? '<span class="created_at">' + response.created_at + ' </span>' : '') +
    '<b>' + response.username + '</b>: ' + response.message + '</div>');
  $('.chat__frame').animate({
    scrollTop: $('.chat__frame').outerHeight(),
  }, 'fast');
};

chat.onopen = function (e) {
  console.log("Connection established!");
  chat.send(JSON.stringify({
      'username': username,
      'type': SHOW_HISTORY,
      task_id,
      project_id
    })
  );
};

$('#send').click(function () {
  chat.send(JSON.stringify({
      'username': username,
      'message': $('#message').val(),
      'type': SEND_MESSAGE,
      task_id,
      project_id
    })
  );
  $('#message').val('');
});

$('.btn-hide').click(function () {
  $('#chat').addClass('chat-hidden');
  $('.show-chat').addClass('active');
});

$('.show-chat').click(function () {
  $('#chat').removeClass('chat-hidden');
  $('.show-chat').removeClass('active');
});

