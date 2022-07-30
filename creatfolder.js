function creatfolder(path) {
    layui.use('layer', function () {
        var $ = layui.jquery, layer = layui.layer;
        layer.prompt({
            formType: 0,
            value: '',
            title: '请输入值文件夹名',
            btn: ['确认创建', '取消'],
            area: ['300px', '180px']
        }, function (name, index, elem) {
            var httpRequest = new XMLHttpRequest();
            httpRequest.open('GET', '/creatfolder.php?name=' + path + '/' + name, true);
            httpRequest.send();
            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    if (httpRequest.responseText == "ok") {
                        layer.msg("创建成功");
                        setTimeout(() => { location.reload(); }, 500);
                    }
                    else if (httpRequest.responseText == "exist") {
                        layer.msg("创建失败：已经存在");
                        setTimeout(() => { location.reload(); }, 500);
                    }
                    else layer.msg("创建失败");
                }
            };
            layer.close(index);
        });
    }
    )
}