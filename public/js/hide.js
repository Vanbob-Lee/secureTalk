function upload() {
    var form = new FormData();
    var pic = $('#pic')[0].files[0];
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
    $.ajax({
        url: '/logic/hide',
        type: 'post',
        data: {
            path: $('#path').val(),
            msg: $('#msg').val()
        },
        success: function (ret) {
            alert(ret.msg);
            $('#send').removeAttr('disable');
            $('#gener').removeClass('btn-disabled');
            $('#gener').addClass('btn-success');
        },
        err: function (err) {
            alert('隐写失败');
            $('#send').attr('disable', 'disable');
            $('#gener').removeClass('btn-success');
            $('#gener').addClass('btn-disabled');
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