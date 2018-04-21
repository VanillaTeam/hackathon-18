function open_url(url) {
    if (url == '/register' || url == '/login' || url == '/logout' || url == '#') {
        return true;
    }

    function showNewContent() {
        $(':not(#new-content) main').html($('#new-content main').html());
        $('#new-content').empty();
        $('#preloader_holder').addClass('hidden');
        $('main a').click(function () {
            return open_url($(this).attr('href'));
        });
        history.pushState(null, null, url);
    }

    $('#preloader_holder').removeClass('hidden');
    $('#new-content').load(url + ' main', '', showNewContent);
    return false;
}

function on_submit(form) {
    $.ajax({
        type: 'POST',
        url: $(form).attr('action'),
        data: $(form).serialize(),
        success: function (data) {
            $('#results').html(data);
        },
        error: function (xhr, str) {
            console.log('Возникла ошибка: ' + xhr.responseCode);
        }
    });
}

$('a').click(function () {
    return open_url($(this).attr('href'));
});