<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>故障码</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="/layui/css/layui.css">
    <script src="/layui/layui.all.js"></script>
    <script src="/jquery-3.5.1.min.js"></script>

    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body class="layui-layout-body" style=" overflow-y:auto; overflow-x:auto;height:1500px;">

<fieldset class="layui-elem-field">
    <legend>选择电控系统：</legend>
    <div class="layui-btn-container">
        @foreach($data_sec as $k=>$y)
            <button class="layui-btn select_elc" value="{{$y['proId']}}" fac="{{$y['the_system']}}">{{$k}}</button>
        @endforeach
    </div>
</fieldset>

<table class="layui-table" lay-even="" lay-skin="nob">
    <colgroup>
        <col width="150">
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>故障码</th>
        <th>{{$data['pcode']}}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>spn码</td>
        <td>{{$data['spncode']}}</td>
    </tr>
    <tr>
        <td>厂家</td>
        <td>{{$data['firstOneTag']}}</td>
    </tr>
    <td>电控系统</td>
    <td>{{$data['secondOneTag']}}</td>
    </tr>
    <tr>
        <td>所有适用车型</td>
        <td>{{$data['the_system']}}</td>
    </tr>
    <tr>
        <td>适用车型</td>
        <td class="change_car"></td>
    </tr>
    <tr>
        <td>故障描述</td>
        <td>{{$data['descs']}}</td>
    </tr>
    </tbody>
</table>

<fieldset class="layui-elem-field">
    <legend>可能症状</legend>
    <div class="layui-field-box">
        {!!$data['symptom']!!}
    </div>
</fieldset>


<fieldset class="layui-elem-field">
    <legend>可能原因：</legend>
    <div class="layui-field-box">
        {!!$data['reason']!!}
    </div>
</fieldset>

<fieldset class="layui-elem-field">
    <legend>排查步骤：</legend>
    <div class="layui-field-box">
        {!!$data['checks']!!}

    </div>
</fieldset>

<!-- <fieldset class="layui-elem-field">
    <legend>加载详情：</legend>
    <div class="layui-field-box showdetailhtml" id="guides"></div>
    <div class="layui-field-box othershowdetailhtml"  style="display:none"></div>
</fieldset> -->

<input type="hidden" value="" id='target'>
</body>
<script>
    $(function () {
      $(".proClick").click(function () {
        var content = $(this).text();
        var val = $(this).attr("proid");
// console.log(content);
// console.log(val);


        if ($('#selected').length > 0) {
          var id = $("#selected").attr("value");
          console.log("开始加载")
          //做标记给后面换电控系统识别
          $('#target').attr("value", content);//给一个隐藏的元素添加content的值，后面好取一点
          var token = localStorage.getItem("token");
//get()方式
          $.ajax({
              url: '/admin/agent/showguide',
              dataType: 'json',
              data: { 'id': id, 'text': content,'token':token },
              beforeSend:function () {
                  this.layerIndex = layer.load(0, { shade: [0.5, '#393D49'] });
              },
            success: function (data) {
              console.log(data);
                if(data['code']=='200'){
                    console.log(data['msg']);
                    console.log(data['data']['content']);
                    var htmls =data['data']['content'];
                    layer.open({
            type: 1,
            skin: 'layui-layer-demo', //样式类名
            title: '标题',
            closeBtn: 1, 
            anim: 2,
            area: ['893px', '600px'],
            shadeClose: true, //开启遮罩关闭
            content: htmls
        });
                    
                }else{
  
                    layer.alert(data['msg'])
                    // $('.showdetailhtml').html(data['msg']);
                }

            },
            complete: function () {
                  layer.close(this.layerIndex);
              },
            error: function (error) {
              console.log(error)
            }
          })
        } else {

          layer.msg('还没有选择电控系统！');
        }

      })
    });




      $("body").delegate(".open-term","click", function(){
        var content = $(this).text();
        var id = $("#selected").attr("value");
        if ($('#selected').length > 0) {
          var id = $("#selected").attr("value");
          console.log("开始加载")
          //做标记给后面换电控系统识别
          $('#target').attr("value", content);//给一个隐藏的元素添加content的值，后面好取一点
          var token = localStorage.getItem("token");
          $.ajax({
              url: '/admin/agent/showguide',
              dataType: 'json',
              data: { 'id': id, 'text': content,'token':token },
              beforeSend:function () {
                  this.layerIndex = layer.load(0, { shade: [0.5, '#393D49'] });
              },
            success: function (data) {
              console.log(data);
                if(data['code']=='200'){
                    console.log(data['msg']);
                    console.log(data['data']['content']);
                    
                    var htmls =data['data']['content'];
                    layer.open({
            type: 1,
            skin: 'layui-layer-demo', //样式类名
            title: '标题',
            closeBtn: 1, 
            anim: 2,
            area: ['893px', '600px'],
            shadeClose: true, //开启遮罩关闭
            content: htmls
        });
                    
                }else{
                  layer.alert(data['msg'])
                }

            },
            complete: function () {
                  layer.close(this.layerIndex);
              },
            error: function (error) {
              console.log(error)
            }
          })
        } else {

          layer.msg('还没有选择电控系统！');
        }


      });



    //处理属性 为 lay-active 的所有元素事件
    $(function () {
        $(".select_elc").click(function () {
            var content = $(this).text();
            var val = $(this).attr("value");//id
            var fac = $(this).attr("fac");
            $(this).css("color", "red");
            $(this).attr("id", "selected");
            $(this).siblings().css("color", "#fff");
            $(this).siblings().attr("id", "noselected");
            $(".change_car").text(fac);
//判断是否加载详情是否存在
            var noContent = $("#guides").html();
            if (noContent == null || noContent.length == 0) {
                console.log("没有加载的内容不用管");
            } else {
                //有内容需要再次异步加载内容
                var content = $('#target').attr("value");
                var token = localStorage.getItem("token");
                $.ajax({
                    url: '/admin/agent/showguide',
                    dataType: 'json',
                    data: { 'id': val, 'text': content,'token':token },
                    beforeSend:function () {
                  this.layerIndex = layer.load(0, { shade: [0.5, '#393D49'] });
              },
                    success: function (data) {
                        if(data['code']=='200'){
                            console.log(data['msg']);
                            console.log(data['data']['content']);
                            var htmls =data['data']['content'];
                    layer.open({
            type: 1,
            skin: 'layui-layer-demo', //样式类名
            title: '标题',
            closeBtn: 1, 
            anim: 2,
            area: ['893px', '600px'],
            shadeClose: true, //开启遮罩关闭
            content: htmls
        });
                        }else{
                          layer.alert(data['msg'])
                        }
                    },
                    complete: function () {
                  layer.close(this.layerIndex);
              },
                    error: function (error) {
                        console.log(error)
                    }
                })
            }


        });

        $("body").delegate(".proClick.clickItem","click", function(){
          var content = $(this).text();
        var id = $("#selected").attr("value");
        if ($('#selected').length > 0) {
          var id = $("#selected").attr("value");
          console.log("开始加载")
          //做标记给后面换电控系统识别
          $('#target').attr("value", content);//给一个隐藏的元素添加content的值，后面好取一点
          var token = localStorage.getItem("token");
          $.ajax({
              url: '/admin/agent/showguide',
              dataType: 'json',
              data: { 'id': id, 'text': content,'token':token },
              beforeSend:function () {
                  this.layerIndex = layer.load(0, { shade: [0.5, '#393D49'] });
              },
            success: function (data) {
              console.log(data);
                if(data['code']=='200'){
                    console.log(data['msg']);
                    console.log(data['data']['content']);
                    var htmls =data['data']['content'];
                    layer.open({
            type: 1,
            skin: 'layui-layer-demo', //样式类名
            title: '标题',
            closeBtn: 1, 
            anim: 2,
            area: ['893px', '600px'],
            shadeClose: true, //开启遮罩关闭
            content: htmls
        });
                    
                }else{
                  layer.alert(data['msg'])
                }

            },
            complete: function () {
                  layer.close(this.layerIndex);
              },
            error: function (error) {
              console.log(error)
            }
          })
        } else {

          layer.msg('还没有选择电控系统！');
        }
        }
        )
    })
</script>
</html>