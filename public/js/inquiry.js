$(document).ready(function() {
    // 画面読み込み時、選択中の連絡先タイプによって連絡先IDフォームの表記を書き換える
    change_contact_id_param();
});

$(function(){
    // ラジオボタン押下時、連絡先タイプによって連絡先IDフォームの表記を書き換える
    $('input[name=reply_type]:radio').change( function() {
        change_contact_id_param();
    });

});

function change_contact_id_param() {

    // 連絡先タイプの選択状態によって、連絡先IDのテキストボックスを書き換える
    var reply_type = $('input[name=reply_type]:checked').val();

    if (reply_type === 'discord') {
        $('#contact_id_form').show();
        $('#contact_id_label').text('Discord ID');
        $('#contact_id').attr('placeholder', 'Discord ID');
    }
    else if (reply_type === 'twitter') {
        $('#contact_id_form').show();
        $('#contact_id_label').text('Twitter ID');
        $('#contact_id').attr('placeholder', 'Twitter ID (@名前)');
    }
    else {
        $('#contact_id_form').hide();
    }
    
}