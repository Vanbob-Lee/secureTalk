function encryptByDES(message, key){
    var keyHex=CryptoJS.enc.Utf8.parse(key);
    var encrypted=CryptoJS.DES.encrypt(message,keyHex,{
        mode:CryptoJS.mode.ECB,
        padding:CryptoJS.pad.Pkcs7
    });
    return encrypted.ciphertext.toString();
}

function mod_exp(m, key, n) {
    var i = 1, val = m;
    while (i++ < key) {
        val %= n;
        val *= m;
    }
    return val;
}

function process(message, con_id) {
    var ks = Math.floor(100000000 * Math.random());
    var sign, kub, n;
    var hash = CryptoJS.MD5(message).toString();
    $.ajax({
        url: '/open/signature',
        async: false,
        type: 'post',
        data: { hash: hash },
        success: function (ret) {
            sign = ret;
        },
        error: function (err) {
            console.log(err);
            alert('签名服务异常');
        }
    });
    var msg_sign = { msg: message, sign: sign };
    var enc_msg_sign = encryptByDES(JSON.stringify(msg_sign), ks);

    $.ajax({
        url: '/open/get_pub_key',
        async: false,
        data: { id: con_id },
        success: function (ret) {
            kub = ret.pub;
            n = ret.n;
        },
        error: function (err) {
            console.log(err);
            alert('无法获取对方公钥');
        }
    });
    var enc_ks = mod_exp(ks, kub, n);
    var packet = { 'envelop': enc_ks, 'data': enc_msg_sign };
    return JSON.stringify(packet);
}