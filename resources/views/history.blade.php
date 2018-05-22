<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>与 {{ $con->name }} 的聊天记录</title>
    <script src="https://cdn.bootcss.com/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    @include('encrypt_js')

    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .my_li {
            text-align: right;
            width: 80%;
            margin-top: 10px;
            margin-right: 10px;
            background-color: #5cb85c;
            border-color: #4cae4c;
        }
        .con_li {
            width: 80%;
            margin-top: 10px;
            margin-left: 10px
        }
        span {
            word-wrap: break-word;
        }
        .footer {
            display: block;
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 1px solid #eee;
            background: white;
        }
    </style>

    <script>
        var uid = '{{ $con->id }}';
        var my_id = '{{ $me->id }}';
        $(document).ready(function () {
            var h = window.screen.height;
            // $(window).height() 非常大
            var fh = $('#footer').height();
            $('#msg_div').css('height', 3.5*h - fh);
        });
        function do_decrypt() {
            var cipher = $('#cipher').val();
            var chk = $('#con_msg')[0].checked;  // 如果是对方发来的消息
            var uid1 = (chk?my_id:uid);  // 获取自己的私钥
            var uid2 = (chk?uid:my_id);  // 如果是自己发出的消息，获取对方的私钥（不合理！但只能这么做）
            var plain = decrypt_history(cipher, uid1, uid2);
            $('#plain').text(plain);
        }
    </script>
</head>

<body>
<div id="msg_div" style="overflow: scroll;">
    <ul class="list-group">
        @if($msg)
            @foreach($msg as $m)
                @if ($m->sender_id == $con->id)
                    <div>
                        <li class="list-group-item con_li">
                            <p style="color: #1b6d85">{{ $con->name }}&nbsp;&nbsp;&nbsp;{{ $m->created_at }}</p>
                            <span style="margin-left: 5px">{{ $m->content }}</span>
                        </li>
                    </div>
                @else
                    <div align="right">
                        <li class="list-group-item my_li">
                            <p style="color: white">{{ $me->name }}&nbsp;&nbsp;&nbsp;{{ $m->created_at }}</p>
                            <span style="margin-right: 5px">{{ $m->content }}</span>
                        </li>
                    </div>
                @endif
            @endforeach
        @else
            <div class="weui-loadmore weui-loadmore_line">
                <span class="weui-loadmore__tips">暂无消息</span>
            </div>
        @endif
    </ul>
</div>

<div class="footer" id="footer">
    <div class="col-xs-6"><input type="radio" name="sender">自己的消息</div>
    <div class="col-xs-6"><input type="radio" checked="checked" name="sender" id="con_msg">对方的消息</div>
    <div class="col-xs-10" style="margin-top: 5px"><b>密文：</b><input  id="cipher"></div>
    <div class="col-xs-2"><button class="btn-info btn" style="margin-left: -25px" onclick="do_decrypt()">解密</button></div>
    <div style="margin-left: 15px"><b>明文：</b><span id="plain">void</span></div>

    <div align="center">
        {{ $msg->appends(['cid' => $con->id])->links() }}<br>
        <a href="/view/chat?cid={{ $con->id }}" class="weui-footer__link">返回聊天</a>
    </div>
</div>
</body>
</html>