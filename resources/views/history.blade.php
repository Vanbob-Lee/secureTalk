<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
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
        body {
            zoom: 3;
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
        $(document).ready(function () {
            var h = window.screen.height;
            // $(window).height() 非常大
            var fh = $('#footer').height();
            $('#msg_div').css('height', 3.5*h - fh);
        });

        function do_decrypt() {
            var cipher = $('#cipher').val();
            var plain = decrypt(cipher, uid);
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
    <div class="col-xs-10" style="margin-top: 5px"><b>密文：</b><input  id="cipher"></div>
    <div class="col-xs-2"><button class="btn-info btn" style="margin-left: -25px" onclick="do_decrypt()">解密</button></div>
    <div style="margin-left: 15px">
        <b>明文：</b><span id="plain">void</span>
    </div>
    <div align="center">
        {{ $msg->appends(['cid' => $con->id])->links() }}<br>
        <!--
        <a href="/view/history?cid={{ $con->id }}&page=1" class="weui-footer__link">第一页&nbsp;</a>
        <a href="/view/chat?cid={{ $con->id }}" class="weui-footer__link">返回&nbsp;</a>
        <a href="/view/history?cid={{ $con->id }}&page={{ $msg->lastPage() }}" class="weui-footer__link">末页</a>
        -->
    </div>
</div>
</body>
</html>