<script src="https://cdn.bootcss.com/crypto-js/3.1.9/core.min.js"></script>
<script src="https://cdn.bootcss.com/crypto-js/3.1.9/cipher-core.min.js"></script>
<script src="https://cdn.bootcss.com/crypto-js/3.1.9/tripledes.min.js"></script>
<script src="https://cdn.bootcss.com/crypto-js/3.1.9/mode-ecb.min.js"></script>
<script src="https://cdn.bootcss.com/crypto-js/3.1.9/hmac-md5.min.js"></script>
<script src="https://cdn.bootcss.com/crypto-js/3.1.9/md5.min.js"></script>
<script src="/js/encrypt.js"></script>
<script>
    $(document).ready(function () {
        var all_msg = $('.cipher_msg');
        for (var i=0; i<all_msg.length; i++) {
            var msg_ele = all_msg[i];
            var uid_ele = $(msg_ele).next();
            var plain = decrypt(msg_ele.textContent, uid_ele.val());
            msg_ele.textContent = plain;
        }
    });
</script>

<div class="weui-cells" style="margin-top: 0px;" id="cells">
    @if(count($messages))
        <div id="list">
        @foreach($messages as $msg)
        <div class="weui-cell">
            <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
                <img src="{{ $msg->head or '/img/head.png' }}" style="width: 50px;display: block"/>
                <span class="weui-badge" style="position: absolute;top: -.4em;right: -.4em;">{{ $msg->unread_count }}</span>
            </div>
            <div class="weui-cell__bd">
                <a href="/view/chat?cid={{ $msg->uid }}"><p style="color: black">{{ $msg->name }}</p></a>
                <!-- 此处，把密文加载出来后再显示。chat.blade中，先解密再显示-->
                <a href="/view/chat?cid={{ $msg->uid }}"><p style="font-size: 13px;color: #888888;" class="cipher_msg">{{ $msg->content }}
                    </p><input type="hidden" value="{{ $msg->uid }}"></a>
            </div>
        </div>
        @endforeach
        </div>

    @else
        <div class="weui-loadmore weui-loadmore_line" id="tip">
            <span class="weui-loadmore__tips">暂无消息</span>
        </div>
    @endif
</div>