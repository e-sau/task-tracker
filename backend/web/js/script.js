$('.btn-clear-cache').on('click', function(e) {
  e.preventDefault();

  $.get('clear-cache')
    .done(function (data) {
      const responseClass = data.status === '200' ? 'success' : 'danger';
      $('.body-content .row').append(
        `<div class="alert alert-${responseClass}" style="margin-top: 10px;">${data.message}</div>`
      )
    })
    .catch(function (error) {
      $('.body-content .row').append(
        `<div class="alert alert-danger" style="margin-top: 10px;">${error}</div>`
      );
    });
  setTimeout(() => {
    $('.alert').remove();
  }, 3000);
});