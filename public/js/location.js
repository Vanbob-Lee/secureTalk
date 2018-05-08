function record(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    $('#lat').text(lat); $('#lng').text(lng);
}

function showError(error) {
    var err_msg;
    switch(error.code) {
        case error.PERMISSION_DENIED:
            err_msg = "User denied the request for Geolocation.";
            break;
        case error.POSITION_UNAVAILABLE:
            err_msg = "Location information is unavailable.";
            break;
        case error.TIMEOUT:
            err_msg = "The request to get user location timed out.";
            break;
        case error.UNKNOWN_ERROR:
            err_msg = "An unknown error occurred.";
            break;
    }
    alert(err_msg);
}

var watch_id, inter_id;
function getLocation(func_name) {
    var obj_name = 'navigator.geolocation';
    if (navigator.geolocation) {
        watch_id = eval(obj_name + '.' + func_name + '(record, showError, {enableHighAccuracy: true, maximumAge: 0})');
        // 若只取当前位置 watch_id = undefined
        if (watch_id) $('#status').text('Synchronize');

        /* 不可行的调用方法
        var func = eval(obj_name + '.' +func_name);  正确
        func(record, showError, {enableHighAccuracy: true, maximumAge: 0});  错误
        */
    }
    else {
        alert("Geolocation is not supported by this browser.");
    }
}

function get_once() {
    getLocation('getCurrentPosition');
}

function interval_get() {
    inter_id = setInterval(get_once, 1000);
    $('#status').text('Interval');
}

function stop() {
    navigator.geolocation.clearWatch(watch_id);
    clearInterval(inter_id);
    $('#status').text('Static');
}