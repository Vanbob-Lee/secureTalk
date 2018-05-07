<script src="https://cdn.bootcss.com/crypto-js/3.1.9/core.js"></script>
<script src="https://cdn.bootcss.com/crypto-js/3.1.9/cipher-core.js"></script>
<script src="https://cdn.bootcss.com/crypto-js/3.1.9/tripledes.js"></script>
<script src="https://cdn.bootcss.com/crypto-js/3.1.9/mode-ecb.js"></script>
<script src="https://cdn.bootcss.com/crypto-js/3.1.9/hmac-md5.js"></script>
<script src="https://cdn.bootcss.com/crypto-js/3.1.9/md5.js"></script>
<script src="/js/encrypt.js"></script>
<script>
    $(document).ready(function () {
        var all_msg = $('.cipher_msg');
        for (var i=0; i<all_msg.length; i++) {
            var msg_ele = all_msg[i];
            var uid_ele = $(msg_ele).next();
            var plain = decrypt(msg_ele.textContent, uid_ele.val());
            msg_ele.text = plain;
        }
    });
</script>

<div class="weui-cells" style="margin-top: 0px;" id="cells">
    @if(count($messages))
        <div class="weui-cell" id="msg_list">
        @foreach($messages as $msg)
            <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
                <img src="{{ $msg->head or '/img/head.png' }}" style="width: 50px;display: block"/>
                <span class="weui-badge" style="position: absolute;top: -.4em;right: -.4em;">{{ $msg->unread_count }}</span>
            </div>
            <div class="weui-cell__bd">
                <a href="/view/chat?cid={{ $msg->uid }}"><p style="color: black">{{ $msg->name }}</p></a>
                <a href="/view/chat?cid={{ $msg->uid }}"><p style="font-size: 13px;color: #888888;" class="cipher_msg">{{ $msg->content }}
                    </p><input type="hidden" value="{{ $msg->uid }}"></a>
            </div>
        @endforeach
        </div>

    @else
        <div class="weui-loadmore weui-loadmore_line" id="tip">
            <span class="weui-loadmore__tips">暂无消息</span>
        </div>
    @endif
</div>