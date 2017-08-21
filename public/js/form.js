$(function(){
    $('form').submit(function () {
        $(this).find(':submit').text('送信中').attr('disabled', true);
    });
});