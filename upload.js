layui.use(['layer'], function () {
    var layer = layui.layer;
    $('#upload').on('click', function (e) {
        layer.open({
            title: '上传文件到当前文件夹',
            btn: ['上传', '取消'],
            area: ['300px', '180px'],
            content: '<input type="file" name="" id="upload_file">',
            yes: function (index, layero) {
                var path = window.location.search.match("path=\\S+&");
                if (path == null) {
                    path = window.location.search.match("path=&");
                    if (path == null) {
                        path = window.location.search.match("path=\\S+");
                        if (path == null) {
                            path = "path=&";
                        }
                        else {
                            path = path + '&';
                        }
                    }
                }
                path = '&' + path;
                path = path.slice(0, -1) + '/';
                upload(path);
            }
            , shadeClose: 'true'
        });
    })
})
function upload(path) {
    var layer = layui.layer;
    var file = $("#upload_file")[0].files[0]// 获取文件对象 
    if (file == undefined) {
        layer.msg("请先选择文件");
        return false;
    }
    var loading = layer.load(1, { shade: false }); // 加载的风格
    var name = file.name; // 文件名
    var size = file.size; // 文件总大小
    var succeed = 0; // 请求成功次数
    var shardSize = 1024 * 1024 * 10; // 这里是分片的文件大小，不要设置太大不然可能OOM
    var shardCount = Math.ceil(size / shardSize); // 计算总片数(向上取整)
    for (var i = 0; i < shardCount; i++) {
        var start = i * shardSize;
        var end = Math.min(size, start + shardSize);
        var form = new FormData();
        form.append("upload_name", name); //文件名称
        form.append("numbers", shardCount); // 总片数
        form.append("number", i + 1); // 当前片
        form.append("data", file.slice(start, end));
        $.ajax({
            url: "upload.php?action=upload",
            type: "POST",
            data: form,
            async: true, // 异步
            processData: false,
            contentType: false,
            success: function (data) {
                console.log(data);
                var returnData = $.parseJSON(data);
                if (returnData.error == 200) {
                    ++succeed;
                    if (succeed == shardCount) {
                        $.ajax({
                            url: "upload.php?action=merge",
                            type: "POST",
                            data: { 'numbers': shardCount, 'upload_name': name },
                            success: function (data) {
                                var returnData = $.parseJSON(data);
                                if (returnData.error == 200) {
                                    layer.closeAll();
                                    var httpRequest = new XMLHttpRequest();
                                    httpRequest.open('GET', 'uploadmove.php?from=' + name + path + name, true);
                                    httpRequest.send();
                                    httpRequest.onreadystatechange = function () {
                                        if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                                            if (httpRequest.responseText == "ok") layer.msg("上传成功");
                                            else layer.msg("上传失败");
                                        }
                                    };
                                    setTimeout(() => { location.reload(); }, 1000);
                                } else {
                                    layer.closeAll();
                                    layer.msg("其他错误");
                                }
                            },
                        });
                    }
                } else {
                    layer.open({ content: "上传失败", time: 2 });
                }
            },
        });
    }
}