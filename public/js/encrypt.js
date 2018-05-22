function encryptByDES(message, key){
    var keyHex=CryptoJS.enc.Utf8.parse(key);
    var encrypted=CryptoJS.DES.encrypt(message,keyHex,{
        mode:CryptoJS.mode.ECB,
        padding:CryptoJS.pad.Pkcs7
    });
    return encrypted.ciphertext.toString();
}

function decryptByDES(cipher, key){
    var keyHex=CryptoJS.enc.Utf8.parse(key);
    var decrypted=CryptoJS.DES.decrypt({
        ciphertext:CryptoJS.enc.Hex.parse(cipher)
    },keyHex,{
        mode:CryptoJS.mode.ECB,
        padding:CryptoJS.pad.Pkcs7
    });
    var result=decrypted.toString(CryptoJS.enc.Utf8);
    return result;
}

function mod_exp(m, key, n) {
    var i = 1, val = m;
    while (i++ < key) {
        val *= m;
        val %= n;
    }
    return val;
}

// 发送前的整套加密过程
function process(message, con_id) {
    // ks也会作为公钥加密的msg，不能取太大（必须小于N）
    var ks = Math.floor(1000 * Math.random());
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
    var packet = { 'envelope': enc_ks, 'data': enc_msg_sign };
    return JSON.stringify(packet);
}

function decrypt(packet_str, uid) {
    try {
        var packet = eval('(' + packet_str + ')');
    } catch (err) {
        // eval()解析失败，说明原本就是明文，直接返回即可
        return packet_str;
    }
    var ks, kua, n;
    $.ajax({
        url: '/open/get_ks',
        data: {
            env: packet.envelope
        },
        type: 'post',
        async: false,
        success: function (ret) {
            ks = ret;
        },
        error: function (err) {
            console.log(err);
            alert('无法获取会话密钥');
        }
    });
    var msg_sign_str = decryptByDES(packet.data, ks);
    var msg_sign = eval('(' + msg_sign_str + ')');
    $.ajax({
        url: '/open/get_pub_key',
        async: false,
        data: { id: uid },
        success: function (ret) {
            kua = ret.pub;
            n = ret.n;
        },
        error: function (err) {
            console.log(err);
            alert('无法获取对方公钥');
        }
    });
    var flag = 0;
    var msg = msg_sign.msg;
    var hash = CryptoJS.MD5(msg).toString();
    var sign = msg_sign.sign;
    for (var i=0; i<32; i++) {
        var dec_sign_i = mod_exp(sign[i], kua, n);
        if (dec_sign_i !== parseInt(hash[i], 16)) flag = 1;
    }
    if (flag) msg = '[此消息认证失败]' + msg;
    return msg;
}

function decrypt_history(packet_str, uid1, uid2) {
    try {
        var packet = eval('(' + packet_str + ')');
    } catch (err) {
        // eval()解析失败，说明原本就是明文，直接返回即可
        return packet_str;
    }
    var ks, kua, n;
    $.ajax({
        url: '/open/get_history_ks',
        data: {
            env: packet.envelope,
            uid: uid1
        },
        type: 'post',
        async: false,
        success: function (ret) {
            ks = ret;
        },
        error: function (err) {
            console.log(err);
            alert('无法获取会话密钥');
        }
    });
    var msg_sign_str = decryptByDES(packet.data, ks);
    var msg_sign = eval('(' + msg_sign_str + ')');
    $.ajax({
        url: '/open/get_pub_key',
        async: false,
        data: { id: uid2 },
        success: function (ret) {
            kua = ret.pub;
            n = ret.n;
        },
        error: function (err) {
            console.log(err);
            alert('无法获取接收者公钥');
        }
    });
    var flag = 0;
    var msg = msg_sign.msg;
    var hash = CryptoJS.MD5(msg).toString();
    var sign = msg_sign.sign;
    for (var i=0; i<32; i++) {
        var dec_sign_i = mod_exp(sign[i], kua, n);
        if (dec_sign_i !== parseInt(hash[i], 16)) flag = 1;
    }
    if (flag) msg = '[此消息认证失败]' + msg;
    return msg;
}