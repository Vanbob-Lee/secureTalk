<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>图像隐写</title>
    <script src="https://cdn.bootcss.com/jquery/3.3.0/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/hide.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn_item {
            margin-top: 10px;
            width: 90%;
        }
    </style>
    <script>
        {{-- 此页面是无状态的
        var my_id = '{{ $my_id }}';
        var cid = '{{ $cid }}';
        --}}
    </script>
</head>

<body style="zoom: 3">
<ul class="list-group">
    <li class="list-group-item">
        <label>上传图片</label> <!--输入任意类型图像，输出png图像-->
        <input id="pic" type="file" accept="image/*" onchange="upload()">
        <input id="path" type="hidden">
    </li>
    <li class="list-group-item">
        <label>文字信息</label><br>
        <textarea class="form-control" id="msg" style="width: 100%" rows="10"></textarea>
        <span>最大隐写长度：</span><span id="len"></span> (UTF8 Chars)
    </li>
    <li class="list-group-item">
        <label>分享链接</label><br>
        <span id="share">http://</span>
    </li>
</ul>
<div align="center">
    <div class="col-xs-6"><button class="btn btn-default btn_item" onclick="hide()">隐写</button></div>
    <div class="col-xs-6"><button class="btn btn-info btn_item" onclick="decode()">解析</button></div>
    <button class="btn btn-disabled btn_item" disabled="disabled" id="gener">生成分享链接</button>
</div>
</body>
</html>