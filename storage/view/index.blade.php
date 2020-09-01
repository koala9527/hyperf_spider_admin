<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Layui</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="/layui/css/layui.css">
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
           
<table class="layui-hide" id="test"></table>
              
          
<script src="/layui/layui.all.js"></script>  
<script src="/jquery-3.5.1.min.js"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
 
<script>
layui.use('table', function(){
  var table = layui.table;
  
  table.render({
    elem: '#test'
    ,url: '/admin/agent/getcodelistdata' //数据接口
    ,page:true
    ,cellMinWidth: 180 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
    ,cols: [[
      {field:'id', width:'5%', title: 'ID', sort: true}
      ,{field:'pcode', width:'5%', title: '故障码'}
      ,{field:'firstOneTag', width:'5%', title: '厂家', sort: true}
      ,{field:'secondOneTag', width:'10%', title: '电脑版'}
      ,{field:'descs', width:'20%', title: '故障描述'}
      ,{field:'symptom', title: '故障现象', width: '20%', minWidth: 100} 
      ,{field:'the_system', title: '适用车型', width: '25%', minWidth: 100} 

    ]]
  });
});
</script>

</body>
</html>