var lastId = 0;
var MAX_INT = Math.pow(2,20);
var timeUnit = 'HOUR';
var timeVal = '3';

setInterval( function() {
    $.get('app.php?action=user_table', function(data) {
        $('#user_table').html(data);
    });
}, 2000);

setInterval( function() {
    url = 'app.php?action=messages&sender='+$id+'&receiver='+receiver+'&last_id='+lastId+'&time_unit='+timeUnit+'&time_val='+timeVal;
    $.get(url, function(data) {
        var mes = $('#messages');
        mes.append(data['html']);
        mes.scrollTop(MAX_INT);
        if(data['lastId']!=undefined) lastId = data['lastId'];
    });
}, 500);

setInterval( function() {
        if(receiver!=null) {
            var url = 'app.php?action=ajax_query&query='+encodeURIComponent(
                    'SELECT count(*) c FROM writing_info WHERE sender=:sender AND receiver=:receiver AND TIMESTAMPDIFF(SECOND, last_notified, now()) < :time'
                    )+'&args='+encodeURIComponent(JSON.stringify({sender: receiver, receiver: $id, time: 3}));
            $.get(url, function(data) {
                var is_writing = data[0]['c']==1;
                if(is_writing) $('#writing_info').show();
                else $('#writing_info').hide();
            });
        }
}, 1000);

setInterval( function() {
    $.post('app.php?action=notify', {sender: $id});
}, 2000);

function send() {
    $.post('app.php?action=send', {sender: $id, receiver: receiver, message: $('#message').val()});
    $('#message').val('');
}

function refresh_image() {
    $('#image').attr(image_src+'?'+Math.random());
}

function togglePassword() {
    $('#password').toggle();
    $('#passwordButton').html($('#passwordButton').html()[0]=='S' ? 'Hide password' : 'Show password');
}

function userClick(id, key, name) {
    receiver = id;
    lastId = 0;
    $('#messages').html('');
    $('#chat_partner').html(''+key+', '+name);
    $('#user-'+key).css('background-color', 'red');
}

function refreshMsg() {
    lastId = 0;
    $('#messages').html('');
}

$(document).ready( function() {
    timeUnit = $('#time_unit').val();
    timeVal = $('#time_val').val();
    $('#time_val').keypress(function(e) {
        if(e.which == 13) {
            timeVal = $(this).val();
            refreshMsg();
        }
    });
    $('#time_unit').change(function(e) {
        timeUnit = $(this).val();
        refreshMsg();
    });
    $('#message').keypress(function(e) {
        if(e.which == 13) send();
        if(receiver!=null) {
            var url = 'app.php?action=ajax_query&query='+encodeURIComponent(
                    'insert into writing_info(sender, receiver, last_notified) values(:sender, :receiver, now()) ON DUPLICATE KEY UPDATE last_notified=now()'
                    )+'&args='+encodeURIComponent(JSON.stringify({sender: $id, receiver: receiver}));
            $.get(url, function(data) {
            });
        }
    });
});
