function rename(oldname) {
    layui.use('layer', function () {
        var $ = layui.jquery, layer = layui.layer;
        var title = '请输入' + oldname + '的新名字？';
        layer.prompt({
            formType: 0,
            value: '',
            title: title,
            btn: ['确认改名', '取消'],
            area: ['300px', '180px']
        }, function (newname, index, elem) {
            var httpRequest = new XMLHttpRequest();
            httpRequest.open('GET', '/rename.php?oldname=' + oldname + '&=newname' + newname, true);
            httpRequest.send();
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    if (httpRequest.responseText == "ok") {
                        layer.msg("改名成功");
                        setTimeout(() => { location.reload(); }, 500);
                    }
                    else layer.msg("改名失败");
                }
            };
            layer.close(index);
        });
    }
    )
}