String.prototype.replaceAll = function (search, replace) {
    return this.split(search).join(replace);
};

$("#bot-input").keyup(function (event) {
    if (event.keyCode == 13) {
        event.preventDefault();
        $('#bot-output').append('<p class="usr-msg">' + $(this).val() + '</p>');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/static/php/api.php",
            data: "msg=" + $(this).val().replaceAll(' ', '+'),
            success: function (json) {
                if (json.type == 1) {
                    open_url(json.extra);
                }
                else if (json.type == 2) {
                    $('#bot-output').append('<p class="bot-msg">' + json.extra + '</p>');
                    $('#bot-output').animate({"scrollTop":$('#bot-output').height()});
                }
            }
        });
        $(this).val('')
    }
});

$('.chat-bot .header').click(function () {
    if ($('.chat-bot').hasClass('hide')) {
        $('.chat-bot').removeClass('hide');
    }
    else {
        $('.chat-bot').addClass('hide');
    }
});