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
<style>
.layui-body{

  left:10px;
}
.layui-layout-admin .layui-body {

    top: 70px;

}
  /* .layui-table-cell {
   line-height: 10px;
  } */
  .layui-nav {
    position: relative;
    padding: 0 20px;
    background-color: #444;
    color: #fff;
    border-radius: 2px;
    font-size: 0;
    box-sizing: border-box; */
}
.layui-nav .layui-nav-item {
    position: relative;
    display: inline-block;
    *display: inline;
    *zoom: 1;
    vertical-align: middle;
    line-height: 50px;
}

form {
    position: inline;
    top: 10px;
}
 </style>
</style>
<body class="layui-layout-body">




  
  <div class="layui-body">
    <!-- 内容主体区域 -->

    <form class="layui-form" action="/admin/agent/showlisthtml" lay-filter="example">
<div class="layui-inline">
    <div class="layui-input-inline">
      <select name="one_class" class="one_selects" lay-filter="one_selects">
        <option value="" selected>请选择厂家</option>
        @foreach($one_select as $k=>$y)
        <option class="select_elc" value="{{$y}}"  >{{$y}}</option>
        @endforeach
      </select>
    </div>
    <div class="layui-input-inline">
      <select name="two_class" id="two_selects">
        <option value="">请选择电控系统</option>
      </select>
    </div>
  </div>


  <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="/img/ava.jpg" class="layui-nav-img">
          {{$username}}
        </a>

      </li>
      <li class="layui-nav-item">
      <div class='logout'>退了</div></li>
    </ul>



    <div class="layui-input-inline layui-inline">
      <input type="text" name="keyword"  placeholder="搜索故障码" autocomplete="off" class="layui-input layui-inline" value="{{$keyword}}">
    </div>
    <div class="layui-input-inline layui-inline">
      <input type="text" name="spn"  placeholder="搜索spn码" autocomplete="off" class="layui-input layui-inline" value="{{$spn}}">
    </div>

  <button type="submit" class="layui-btn layui-inline" lay-submit="" lay-filter="errcode">立即提交</button>
              
</form>  
<table class="layui-table" lay-data="{ url:'/admin/agent/getcodelistdata', page:true, id:'idTest',limit:20,limits:[15,60,90]}" lay-filter="demo" id="demo">
  <thead>
    <tr>
      <th lay-data="{field:'id', width:'5%', title: 'ID', sort: true}">ID</th>
      <th lay-data="{field:'pcode', width:'8%', title: '故障码'}">用户名</th>
      <th lay-data="{field:'spncode', width:'8%', title: 'spn'}">用户名</th>
      <th lay-data="{field:'firstOneTag', width:'8%', title: '厂家', sort: true}">性别</th>
      <th lay-data="{field:'secondOneTag', width:'10%', title: '电脑版'}">城市</th>
      <th lay-data="{field:'descs', width:'15%', title: '故障描述'}">签名</th>
      <th lay-data="{field:'symptom', title: '故障现象', width: '15%', minWidth: 100} ">积分</th>
      
      <th lay-data="{field:'the_system', title: '适用车型', width: '20%', minWidth: 100} ">职业</th>
      <th lay-data="{field:'lock', title:'是否标记',width: '7%', templet: '#checkboxTpl'}">财富</th>
      <th lay-data="{fixed: 'right', width:178, align:'center', toolbar: '#barDemo'}"></th>
    </tr>
  </thead>
</table>
  </div>
</div>



<script src="/layui/layui.all.js"></script>  
<script src="/jquery-3.5.1.min.js"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
 
<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail" value="@{{d.id}}">查看</a>
</script>

<script type="text/html" id="checkboxTpl">
  <!-- 这里的 checked 的状态只是演示 -->
  <input type="checkbox" name="lock" value="@{{d.id}}" title="标记" lay-filter="lockDemo" @{{ d.status == 1 ? 'checked' : '' }}>
</script>
<script>

layui.use(['form', 'layedit','table','element','laytpl'], function(){
  var table = layui.table
  ,form = layui.form
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,element = layui.element
  ,laytpl = layui.laytpl;

 //监听工具条
 table.on('tool(demo)', function(obj){
    var data = obj.data;
    if(obj.event === 'detail'){
      layer.msg('ID：'+ data.id + ' 的查看操作');
      var token = localStorage.getItem("token");
      if (token){
        window.open("http://127.0.0.1:8591/admin/agent/code?id="+data.id+"&token="+token)
      }else{
        layer.msg('没有登录', {icon: 6}); 
      }
        

    } 
  });

  //注销登录
  $(".logout").click(function(){
    var token = localStorage.getItem("token");
    $.ajax({
  url: '/login/mylogout',
  type: 'post',
  async:false,
  // 设置的是请求参数
  data: { 'token': token},
  // 用于设置响应体的类型 注意 跟 data 参数没关系！！！
  dataType: 'json',
  success: function (res) {
    // 一旦设置的 dataType 选项，就不再关心 服务端 响应的 Content-Type 了
    // 客户端会主观认为服务端返回的就是 JSON 格式的字符串
    console.log(res)
    if(res['code']==200){
        console.log("注销成功");
        console.log(res['data']);
        localStorage.removeItem("token");
        window.location.href = '/login/mylogin';
        
    }else{
        layer.msg(res['msg'], {icon: 6}); 
        // console.log(res['msg']);
        // console.log(localStorage.getItem("token"));
        localStorage.removeItem("token");
    }
}
})
   
    
  })

    //表单提交
   form.on('checkbox(lockDemo)', function(obj){
    // layer.tips(this.value + ' ' + this.name + '：'+ obj.elem.checked, obj.othis);
    var change_id = this.value;
    $.ajax({
     url:'/admin/agent/changestatus?id='+change_id,
     type:'get',
     dataType:'text',
     success:function(data){
       console.log(data)
     },
     error:function(error){
        console.log(error)
     }
    })
  });



    //监听提交
    form.on('submit(errcode)', function(data){
      var formData = data.field;
            var one_class = formData.one_class,
            two_class=formData.two_class,
            keyword= formData.keyword,
            spn= formData.spn;

            //执行重载
            table.reload('idTest', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {//这里传参  向后台
                  one_class :formData.one_class,
                  two_class:formData.two_class,
                  keyword: keyword,
                  spn:formData.spn
                    //可传多个参数到后台...  ，分隔
                }
                , url: '/admin/agent/getcodelistdata'//后台做模糊搜索接口路径
                , method: 'get'
            });
            return false;//fals
  });

  //级联选择器
  form.on('select(one_selects)', function(data){
    console.log(data)
   $.getJSON("/admin/agent/getsecclass?onetag="+data.value, function(data){
     console.log(data);
    var optionstring = "";
    $.each(data, function(index,val){
     optionstring += "<option value=\"" + val + "\" >" + val + "</option>";
    });
    $("#two_selects").html(optionstring);
    form.render('select'); //这个很重要
   });
});
});
</script>
</body>
</html>