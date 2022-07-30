function exit() {
    layui.use('layer', function () {
        var $ = layui.jquery, layer = layui.layer; 
        var title = '确认退出吗？';
        layer.open({
            title: title,
            btn: ['确认退出', '取消'],
            area: ['300px', '180px'],
            content: title,
            yes: function (index, layero) {
                var httpRequest = new XMLHttpRequest();
                httpRequest.open('GET', 'exit.php', true);
                httpRequest.send();
                httpRequest.onreadystatechange = function () {
                    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                        if (httpRequest.responseText == "bye") {
                            layer.msg("退出成功，欢迎再次使用");
                            setTimeout(() => { location.reload(); }, 1000);
                        }
                    }
                };
            }
            , shadeClose: 'true'
        });
    }
    )
}