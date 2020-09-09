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
<body class="layui-layout-body">

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
      <td>厂家</td>
      <td>{{$data['firstOneTag']}}</td>
    </tr>
      <td>电控系统</td>
      <td>{{$data['secondOneTag']}}</td>
    </tr>
    <tr>
      <td>所有适用车型</td>
      <td >{{$data['the_system']}}</td>
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

<fieldset class="layui-elem-field">
  <legend>加载详情：</legend>
  <div class="layui-field-box showdetailhtml" id="guides"></div>
</fieldset>

<input type="hidden" value="" id='target'>
</body>
<script>
$(function () {
$(".proClick").click(function () {
var content=$(this).text();
var val=$(this).attr("proid");
// console.log(content);
// console.log(val);


if($('#selected').length >0){
  var id = $("#selected").attr("value");
  console.log("开始加载")
  //做标记给后面换电控系统识别
$('#target').attr("value",content);
var token = localStorage.getItem("token");
//get()方式
$.ajax({
     url:'/admin/agent/showguide?id='+id+'&text='+content+"&token="+token,
     type:'get',
     dataType:'text',
     success:function(data){
       console.log(data)
       $('.showdetailhtml').html(data);
     },
     error:function(error){
        console.log(error)
     }
    })
}else{

  layer.msg('还没有选择电控系统！'); 
}

})
})


 //处理属性 为 lay-active 的所有元素事件
 $(function () {
$(".select_elc").click(function () {
var content=$(this).text();
var val=$(this).attr("value");//id
var fac=$(this).attr("fac");
$(this).css("color","red");
$(this).attr("id","selected");
$(this).siblings().css("color","#fff");
$(this).siblings().attr("id","noselected");
$(".change_car").text(fac);
//判断是否加载详情是否存在
var noContent = $("#guides").html(); 
if(noContent == null || noContent.length == 0) 
{ 
  console.log("没有加载的内容不用管");
}else{
  //需要再次异步加载内容
  var content = $('#target').attr("value");
  $.ajax({
     url:'/admin/agent/showguide?id='+val+'&text='+content,
     type:'get',
     dataType:'text',
     success:function(data){
       console.log(data)
       $('.showdetailhtml').html(data);
     },
     error:function(error){
        console.log(error)
     }
    })
}


});

})
</script>
</html>