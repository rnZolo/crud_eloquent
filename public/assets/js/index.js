$('.pass-show').click(function (e) {
    e.preventDefault();
    $('.pass-show').toggleClass('bi-eye-slash-fill bi-eye-fill ')
    if ($('.pass-show').hasClass('bi-eye-fill')) {
        $('.pass-log').attr('type', 'text');
    } else {
        $('.pass-log').attr('type', 'password');
    }
});

