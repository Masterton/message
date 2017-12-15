function isSocketToken(socketToken, strCookie, type)
{
	var ca = strCookie.split('; ');
    var isSocketCookie = false;
    if (type != 'reset') {
        for (var i = 0; i < ca.length; i++) {
            var key = ca[i].split('=');
            if (key[0] == "socketToken") {
                isSocketCookie = true;
                socketToken = key[1];
                break;
            }
        }
    }
    if (isSocketCookie == false) {
        var Days = 30;
        var exp = new Date();
        exp.setTime(exp.getTime() + Days*24*60*60*1000);
        document.cookie = "socketToken="+ socketToken + ";expires=" + exp.toGMTString();
    }

    return socketToken;
}

function connectSocket(socketToken)
{
	// 连接服务端
    var socket = io('http://gitlab.zhengss.com:2120');
    // 连接后登录
    socket.on('connect', function(){
    	socket.emit('login', socketToken);
    });
    // 后端推送来消息时
    socket.on('new_msg', function(msg){
         $('#content').html('收到消息：'+msg);
         $('.notification.sticky').notify();
    });
    // 后端推送来在线人数
    socket.on('update_online_count', function(online_count){
        $('#online_count_box').html(online_count);
    });

    // 后端推送来打开页面数
    socket.on('update_online_page_count', function(online_page_count){
        $('#online_page_count_box').html(online_page_count);
    });
}

function getSocketToken(type="")
{
    $.ajax({
        url: "http://www.9988.so/api/get/socket/token",
        type: "get",
        dataType: "jsonp",
        jsonp: "callback",
        success: function(ret) {
            if (ret.error == 1) {
                console.log(ret.desc);
            } else if (ret.error == 0) {
                if (ret.data.socketToken != "") {
                    // 连接socket
                    connectSocket(isSocketToken(ret.data.socketToken, document.cookie, type));
                }
            }
        }
    });
}