function del(name, path) {
    layui.use('layer', function () {
        var $ = layui.jquery, layer = layui.layer;
        var title = '确认删除' + name + '吗？';
        layer.open({
            title: title,
            btn: ['确认删除', '取消'],
            area: ['300px', '180px'],
            content: title,
            yes: function (index, layero) {
                var httpRequest = new XMLHttpRequest();
                httpRequest.open('GET', '/delete.php?delete=' + path + '/' + name, true);
                httpRequest.send();
                httpRequest.onreadystatechange = function () {
                    if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                        if (httpRequest.responseText == "ok") {
                            layer.msg("删除成功");
                            setTimeout(() => { location.reload(); }, 500);
                        }
                        else layer.msg("删除失败");
                    }
                };
            }
            , shadeClose: 'true'
        });
    }
    )
}