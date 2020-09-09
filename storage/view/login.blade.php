<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>后台管理-登陆</title>
    <link rel="stylesheet" href="/layui/css/layui.css">
    <style>
    body {
    background-color: #e7e7e7;
}

input:-webkit-autofill {
    -webkit-box-shadow: inset 0 0 0 1000px #fff;
    background-color: transparent;

}

.admin-login-background {
    width: 300px;
    height: 300px;
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -150px;
    margin-top: -100px;
}

.admin-header {
    margin-top: -100px;
    margin-bottom: 20px;
}

.admin-logo {
    width: 280px;
}

.admin-button {
    margin-top: 20px;
}

.admin-input {

    border-top-style: none;
    border-right-style: solid;
    border-bottom-style: solid;
    border-left-style: solid;
    height: 50px;
    width: 300px;
    padding-bottom: 0px;
}


.admin-input-username {
    border-top-style: solid;
    border-radius: 10px 10px 0 0;
}

.admin-input-verify {
    border-radius: 0 0 10px 10px;
}

.admin-button {
    width: 300px;
    height: 50px;
    border-radius: 4px;
    background-color: #2d8cf0;
}

.admin-icon {
    margin-left: 260px;
    margin-top: 10px;
    font-size: 30px;
}

i {
    position: absolute;
}

.admin-captcha {
    position: absolute;
    margin-left: 205px;
    margin-top: -40px;
}
</style>
</head>
<body>
<div id="container">
    <div></div>
    <div class="admin-login-background">
        <!--<div class="admin-header">-->
        <!--<img src="image/ex_logo.png" class="admin-logo">-->
        <!--</div>-->
        <form class="layui-form" action="">
            <div>
                <i class="layui-icon layui-icon-username admin-icon admin-icon-username"></i>
                <input type="text" name="username" placeholder="请输入用户名"
                       autocomplete="off"
                       class="layui-input admin-input admin-input-username">
            </div>
            <div>
                <i class="layui-icon layui-icon-password admin-icon admin-icon-password"></i>
                <input type="password" name="password"
                       placeholder="请输入密码"
                       autocomplete="off"
                       class="layui-input admin-input-password">
            </div>

            <div class="layui-btn admin-button">登陆</div>


        </form>
    </div>
</div>
<script src="/layui/layui.js"></script>
<script src="/jquery-3.5.1.min.js"></script>
<script>
layui.use(['form', 'layedit','table','element','laytpl'], function(){
})
$(".admin-button").click(function(){
var username = $(".admin-input-username").val();
var password = $(".admin-input-password").val();
console.log(username);
console.log(password);
$.ajax({
  url: '/login/checklogin',
  type: 'post',
  async:false,
  // 设置的是请求参数
  data: { 'username': username, 'password': password },
  // 用于设置响应体的类型 注意 跟 data 参数没关系！！！
  dataType: 'json',
  success: function (res) {
    // 一旦设置的 dataType 选项，就不再关心 服务端 响应的 Content-Type 了
    // 客户端会主观认为服务端返回的就是 JSON 格式的字符串
    console.log(res)
    if(res['code']==200){
        console.log("登陆成功");
        console.log(res['data']);
        localStorage.setItem("token",res['data']['token']);
        var user_id= res['data']['user_id'];
        var token = res['data']['token'];
        window.location.href = '/admin/agent/showlisthtml?user_id='+user_id+"&token="+token;
        
    }else{
        layer.msg(res['msg'], {icon: 6}); 
        // console.log(res['msg']);
        // console.log(localStorage.getItem("token"));
        localStorage.removeItem("token");
    }
}
})
})


</script>
</body>
</html>