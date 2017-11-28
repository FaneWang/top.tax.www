
<html>
<head>
    <?php $rootPath = $_SERVER['DOCUMENT_ROOT'].'/';include $rootPath.'common/header.php'; ?>
    <script type="text/javascript" src="<?php echo $basePath?>js/jquery-ui/jquery-ui.js"></script>
    <link rel="stylesheet" href="<?php echo $basePath?>css/jquery-ui-css/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo $basePath?>css/nsfw/validate.css">
    <title>用户管理</title>
</head>
<body class="rightBody">
<form id="form" name="form" action="<?php echo $basePath.'nsfw/user/UserCtrl/add' ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="keyword" value="<?php echo $keyword ?>">
    <div class="p_d_1">
        <div class="p_d_1_1">
            <div class="content_info">
    <div class="c_crumbs"><div><b></b><strong>用户管理</strong>&nbsp;-&nbsp;新增用户</div></div>
    <div class="tableH2">新增用户</div>
    <table id="baseInfo" width="100%" align="center" class="list" border="0" cellpadding="0" cellspacing="0"  >
        <tr>
            <td class="tdBg" width="200px">所属部门：</td>
            <td>
                <select name="dept">
                    <option value="工程部">工程部</option>
                    <option value="经营部">经营部</option>
                    <option value="财务部">财务部</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">头像：</td>
            <td>
                <input type="file" name="headImg" onchange="fileChange(this);"/>
            </td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">用户名：</td>
            <td><input type="text" name="name" id="user_name"><label id="_name" class="_style">用户名不能为空或包含空格！</label></td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">帐号：</td>
            <td><input type="text" name="account" id="user_account"><label id="_account_a" class="_style">账户已经存在！</label><label id="_account_b" class="_style">账户不能为空或包含空格！</label></td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">密码：</td>
            <td><input type="password" name="password" id="user_password"><label id="_password" class="_style">6-12位密码，不能为空或包含空格！</label></td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">性别：</td>
            <td>
                <input type="radio" name="gender" value="1" checked>男
                <input type="radio" name="gender" value="0">女
            </td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">角色：</td>
            <td>
                <?php foreach($roles as $role){ ?>
                <input type="checkbox" name="roles[]" value="<?php echo $role ?>"><?php echo $role ?>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">电子邮箱：</td>
            <td><input type="text" name="email" id="user_email"><label id="_email" class="_style">邮箱格式错误！</label></td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">手机号：</td>
            <td><input type="text" name="mobile" id="user_mobile"><label id="_mobile" class="_style">手机号格式错误！</label></td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">生日：</td>
            <td><input type="text" name="birthday" readonly="true" id="birthday"></td>
        </tr>
		<tr>
            <td class="tdBg" width="200px">状态：</td>
            <td>
                <input type="radio" name="state" value="1" checked>有效
                <input type="radio" name="state" value="0">无效
            </td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">备注：</td>
            <td><textarea name="memo" rows="3" cols="75" id="user_memo"></textarea><label id="_memo" class="_style">不能超过200字！</label></td>
        </tr>
    </table>
    <div class="tc mt20">
        <input type="button" class="btnB2" value="保存" />
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button"  onclick="javascript:history.go(-1)" class="btnB2" value="返回" />
    </div>
    </div></div></div>
</form>

<script type="text/javascript">
    var isIE = /msie/i.test(navigator.userAgent) && !window.opera;   
    function fileChange(target,id) {   
        var fileSize = 0;   
        var filetypes =[".jpg",".png",".gif"];   
        var filepath = target.value;
        console.log(filepath);
        var filemaxsize = 512;//2M   
        if(filepath){   
            var isnext = false;   
            var fileend = filepath.substring(filepath.indexOf("."));   
            if(filetypes && filetypes.length>0){   
                for(var i =0; i<filetypes.length;i++){   
                    if(filetypes[i]==fileend){   
                        isnext = true;   
                        break;   
                    }   
                }   
            }   
            if(!isnext){   
                alert("不接受此文件类型！");   
                target.value ="";   
                return false;   
            }   
        }else{   
            return false;   
        }   
        if (isIE && !target.files) {   
            var filePath = target.value;   
            var fileSystem = new ActiveXObject("Scripting.FileSystemObject");   
            if(!fileSystem.FileExists(filePath)){   
                alert("文件不存在，请重新输入！");   
                return false;   
            }   
            var file = fileSystem.GetFile (filePath);   
            fileSize = file.Size;   
        } else {   
            fileSize = target.files[0].size;   
        }   

        var size = fileSize / 1024;   
        if(size>filemaxsize){   
            alert("大小不能大于"+filemaxsize/1024+"M！");   
            target.value ="";   
            return false;   
        }   
        if(size<=0){   
            alert("大小不能为0M！");   
            target.value ="";   
            return false;   
        }   
    }   




    // 以下代码为表单验证
    /*注意js代码有错整体都是不能执行的*/
    $("#birthday").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat:"yy-mm-dd"
    });
    /*验证用户名*/
    $("#user_name").focusout(function(){
        var name = $("#user_name").val();
        if(name == null || name.indexOf(" ") >= 0 || name.length == 0){
            $("#_name").css("display","inline");
        }
    });
    $("#user_name").focusin(function(){
        $("#_name").css("display","none");
    });

    //账户名验证，使用ajax
    $("#user_account").change(function(){
        var account = $("#user_account").val();
        /*indexOf 如果不包含某字符就返回-1*/
        if (/^[a-zA-Z0-9_-]+$/.test(account)) {
            $.ajax({
                url:"<?php echo $basePath.'nsfw/user/UserCtrl/validate/account/' ?>" + account,
                type:"get",
                dataType:"json",
                success:function(data){
                    var isExist = data.msg;
                    if("true" != isExist){
                        $("#_account_a").css("display","inline");
                    }
                }
            });
        }
    });

    $("#user_account").focusout(function(){
        var account = $("#user_account").val();
        if(!(/^[a-zA-Z0-9_-]+$/.test(account))){
            $("#_account_b").css("display","inline");
        }
    });

    $("#user_account").focusin(function(){
        $("#_account_a").css("display","none");
        $("#_account_b").css("display","none");
    });

    /*验证密码*/
    $("#user_password").focusout(function(){
        var password = $("#user_password").val();
        if(!(/^[a-zA-Z0-9_-]{6,12}$/.test(password))) {
            $("#_password").css("display", "inline");
        }
    });
    $("#user_password").focusin(function(){
        $("#_password").css("display","none");
    });

    /*验证邮箱*/
    $("#user_email").focusout(function(){
        var email = $("#user_email").val();
        if (email != null && email.indexOf(" ") < 0 && email.length != 0) {
            var regex = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
            if(!(regex.test(email))){
                $("#_email").css("display","inline");
            }
        }
    });
    $("#user_email").focusin(function(){
        $("#_email").css("display","none");
    });

    /*验证手机*/
    $("#user_mobile").focusout(function(){
        var mobile = $("#user_mobile").val();
        if (mobile != null && mobile.indexOf(" ") < 0 && mobile.length != 0) {
            var regex = /^1[0-9]{10}$/;
            if(!(regex.test(mobile))){
                $("#_mobile").css("display","inline");
            }
        }
    });
    $("#user_mobile").focusin(function(){
        $("#_mobile").css("display","none");
    });

    /*验证备注字数*/
    $("#user_memo").focusout(function(){
        var memo = $("#user_memo").val();
        if (memo.length > 200) {
            $("#_memo").css("display","inline");
        }
    });
    $("#user_memo").focusin(function(){
        $("#_memo").css("display","none");
    });






    $("input[value='保存']").click(function () {
        var isName = false;
        var isAccount = false;
        var isPassword = false;
        var isEmail = true;
        var isMobile = true;
        var isMemo = true;
        var name = $("#user_name").val();
        if(name == null || name.indexOf(" ") >= 0 || name.length == 0){
            $("#_name").css("display","inline");
        }else{
            isName = true;
        }

        //账户名验证，使用ajax
        var account = $("#user_account").val();
        /*indexOf 如果不包含某字符就返回-1*/
        if (/^[a-zA-Z0-9_-]+$/.test(account)) {
            $.ajax({
                url:"<?php echo $basePath.'nsfw/user/UserCtrl/validate/account/' ?>" + account,
                type:"get",
                dataType:"json",
                success:function(data){
                    var isExist = data.msg;
                    if("true" != isExist){
                        $("#_account_a").css("display","inline");
                    }
                }
            });
        }else{
            isAccount = true;
        }

        var account = $("#user_account").val();
        if(!(/^[a-zA-Z0-9_-]+$/.test(account))){
            $("#_account_b").css("display","inline");
        }else{
            isAccount = true;
        }

        /*验证密码*/
        var password = $("#user_password").val();
        if(!(/^[a-zA-Z0-9_-]{6,12}$/.test(password))) {
            $("#_password").css("display", "inline");
        }else{
            isPassword = true;
        }

        /*验证邮箱*/
        var email = $("#user_email").val();
        if (email != null && email.indexOf(" ") < 0 && email.length != 0) {
            var regex = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
            if(!(regex.test(email))){
                $("#_email").css("display","inline");
                isEmail = false;
            }else{
                isEmail = true;
            }
        }

        /*验证手机*/
        var mobile = $("#user_mobile").val();
        if (mobile != null && mobile.indexOf(" ") < 0 && mobile.length != 0) {
            var regex = /^1[0-9]{10}$/;
            if(!(regex.test(mobile))){
                $("#_mobile").css("display","inline");
                isMobile = false;
            }else{
                isMobile = true;
            }
        }

        /*验证备注字数*/
        var memo = $("#user_memo").val();
        if (memo.length > 200) {
            $("#_memo").css("display","inline");
            isMemo = false;
        }else{
            isMemo = true;
        }

        if(isName && isAccount && isPassword && isMobile && isEmail && isMemo){
            $("#form")[0].submit();
        }
    });
</script>
</body>
</html>