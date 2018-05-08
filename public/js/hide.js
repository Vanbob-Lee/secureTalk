function upload() {
    var form = new FormData();
    var pic = $('#pic')[0].files[0];
    if (pic == null) return;
    form.append('pic', pic);
    $.ajax({
        url: '/logic/upload_pic',
        type: 'post',
        data: form,
        contentType: false,
        processData: false,
        success: function (ret) {
            alert('上传成功');
            $('#path').val(ret.p);
            $('#len').text(ret.len);
        },
        err: function (err) {
            alert('上传失败');
            console.log(err);
        }
    });
}

function hide() {
    var p = $('#path').val();
    var shr = $('#share');
    $.ajax({
        url: '/logic/hide',
        type: 'post',
        data: {
            path: p,
            msg: $('#msg').val()
        },
        success: function (ret) {
            alert(ret.msg);
            if (my_id && cid) {
                shr.attr('disabled', false);
                shr.removeClass('btn-disabled');
                shr.addClass('btn-success');
            }
            $('#img_get').attr('src', '/view/show_pic?path=' + p);
        },
        err: function (err) {
            alert('隐写失败');
            shr.attr('disable', 'disable');
            shr.removeClass('btn-success');
            shr.addClass('btn-disabled');
            $('#img_get').removeAttribute('src');
            console.log(err);
        }
    });
}

function decode() {
    $('#msg').val('');
    $.ajax({
        url: '/logic/decode',
        type: 'post',
        data: {
            path: $('#path').val()
        },
        success: function (ret) {
            alert('解析成功');
            $('#msg').val(ret);
        },
        err: function (err) {
            alert('解析失败');
            console.log(err);
        }
    });
}

function share() {
    var host = window.location.host;
    var route = $('#img_get').attr('src');
    var msg = '[隐写图片] 请打开链接查看：' + host + route;
    var content = process(msg, cid);
    var data = {
        sender_id: my_id,
        recv_id: cid,
        content: content
    };
    $.ajax({
        url: '/logic/send_msg',
        type: 'post',
        data: data,
        success: function(ret) {
            alert('发送成功。可到聊天记录中查看');
        },
        error: function (err) {
            alert('消息发送失败');
            console.log(err);
        }
    });
}