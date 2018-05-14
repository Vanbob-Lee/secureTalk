<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>图像隐写</title>
    <script src="https://cdn.bootcss.com/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/hide.js"></script>
    @if(Auth::check())
        @include('encrypt_js')
    @endif
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn_item {
            margin-top: 20px;
            width: 90%;
        }
    </style>
    <script>
        var my_id = '{{ $my_id }}';
        var cid = '{{ $cid }}';
    </script>
</head>

<body>
<ul class="list-group">
    <li class="list-group-item">
        <label>上传图片</label> <!--输入任意类型图像，输出png图像-->
        <input id="pic" type="file" accept="image/*" onchange="upload()">
        <input id="path" type="hidden">
    </li>
    <li class="list-group-item">
        <label>文字信息</label><br>
        <textarea class="form-control" id="msg" style="width: 100%" rows="5"></textarea>
        <span>最大隐写长度：</span><span id="len"></span> (UTF8 Chars)
    </li>
    <li class="list-group-item">
        <label>隐写输出</label><br>
        <img id="img_get" class="img-responsive" alt="暂未生成">
    </li>
</ul>
<div align="center">
    <div class="col-xs-6"><button class="btn btn-default btn_item" onclick="hide()">隐写</button></div>
    <div class="col-xs-6"><button class="btn btn-info btn_item" onclick="decode()">解析</button></div>
    <div class="col-xs-12">
        <button class="btn btn-disabled btn_item" onclick="share()" id="share" disabled="disabled">分享给当前好友</button>
    </div>
</div>

</body>
</html>