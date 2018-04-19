<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chat Records with {{ $con->name }}</title>
    <script src="https://cdn.bootcss.com/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
    </style>

    <script>
        $(document).ready(function () {
            //$('.pagination').addClass('footer');
        });
    </script>
</head>

<body>
<ul class="list-group">
    @if($msg)
        @foreach($msg as $m)
            @if ($m->sender_id == $con->id)
                <div>
                    <li class="list-group-item con_li">
                        <span style="color: #1b6d85">{{ $con->name }}&emsp;{{ $m->created_at }}</span>
                        <br><span style="margin-left: 5px">{{ $m->content }}</span>
                    </li>
                </div>
            @else
                <div align="right">
                    <li class="list-group-item my_li">
                        <span style="color: #1b6d85">{{ $me->name }}&emsp;{{ $m->created_at }}</span>
                        <br><span style="margin-right: 5px">{{ $m->content }}</span>
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

<div align="center">
    {{ $msg->appends(['cid' => $con->id])->links() }}
    <br><a href="/view/history?cid={{ $con->id }}&page=1" class="weui-footer__link">第一页&nbsp;</a>
    <a href="/view/chat?cid={{ $con->id }}" class="weui-footer__link">返回&nbsp;</a>
    <a href="/view/history?cid={{ $con->id }}&page={{ $msg->lastPage() }}" class="weui-footer__link">末页</a>
</div>
</body>
</html>