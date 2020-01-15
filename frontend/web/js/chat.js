let chat = new WebSocket('ws://task-tracker:8080');
let username = $('.js-username').val();
let SHOW_HISTORY = 1;
let SEND_MESSAGE = 2;

chat.onmessage = function (e) {
  $('#response').text('');
  console.log(e);
  let response = JSON.parse(e.data);
  $('#chat').append('<div><b>' + response.username + '</b>: ' + response.message + '</div>');
  $('#chat').animate({
    scrollTop: $('#chat').outerHeight(),
  }, 'fast');
};

chat.onopen = function (e) {
  console.log("Connection established!");
  chat.send(JSON.stringify({
      'username': username,
      'type': SHOW_HISTORY,
    })
  );
};


$('#send').click(function () {
  chat.send(JSON.stringify({
      'username': username,
      'message': $('#message').val(),
      'type': SEND_MESSAGE
    })
  );
  $('#message').val('');
});