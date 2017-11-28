<html>
<head>
    <?php $rootPath = $_SERVER['DOCUMENT_ROOT'].'/';include $rootPath.'common/header.php'; ?>
    <script type="text/javascript" src="<?php echo $basePath?>js/jquery-ui/jquery-ui.js"></script>
    <link rel="stylesheet" href="<?php echo $basePath?>css/jquery-ui-css/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo $basePath?>css/nsfw/validate.css">
    <title>用户管理</title>
    
</head>
<body class="rightBody">
<form id="form" name="form" action="<?php echo $basePath.'nsfw/user/UserCtrl/edit' ?>" method="post" enctype="multipart/form-data">
    <!-- 这里必须给主键id给一个隐藏域，不然提交表单的时候，主键id丢失，在数据库中就找不到要修改的实体对象，从而报错 -->
    <input type="hidden" name="id" id="user_id" value="<?php echo $id ?>">
    <input type="hidden" name="preAcc" id="preAcc" value="<?php echo $account ?>">
    <input type="hidden" name="keyword" value="<?php echo $keyword ?>">
    <div class="p_d_1">
        <div class="p_d_1_1">
            <div class="content_info">
    <div class="c_crumbs"><div><b></b><strong>用户管理</strong>&nbsp;-&nbsp;编辑用户</div></div>
    <div class="tableH2">编辑用户</div>
    <table id="baseInfo" width="100%" align="center" class="list" border="0" cellpadding="0" cellspacing="0"  >
        <tr>
            <td class="tdBg" width="200px">所属部门：</td>
            <td>
                <?php echo form_dropdown('dept',array(
                    '工程部' => '工程部',
                    '经营部' => '经营部',
                    '财务部' => '财务部'
                ), $dept); ?>
            </td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">头像：</td>
            <td>
                <?php if(isset($headImg) && !empty($headImg)){ ?>
                    <img src="<?php echo $headImg ?>" width="100" height="100"/>
                <?php } ?>
                <input type="file" name="headImg" onchange="fileChange(this);"/>
            </td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">用户名：</td>
            <td><input type="text" name="name" id="user_name" value="<?php echo $name ?>"><label id="_name" class="_style">用户名不能为空或包含空格！</label></td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">帐号：</td>
            <td><input type="text" name="account" id="user_account" value="<?php echo $account ?>"><label id="_account_a" class="_style">账户已经存在！</label><label id="_account_b" class="_style">账户不能为空或包含空格！</label></td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">密码：</td>
            <td><input type="password" name="password" id="user_password" value="<?php echo $password ?>"><label id="_password" class="_style">6-12位密码，不能为空或包含空格！</label></td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">性别：</td>
            <td>
                <?php $m = $gender == '1';$fm = $gender == '0';echo form_radio('gender', '1', $m);echo '男';echo form_radio('gender', '0', $fm); echo '女' ?>
            </td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">角色：</td>
            <td>
                <?php foreach($roles as $role){
                    $m = in_array($role,$cuRoles);
                    echo form_checkbox('roles[]', $role, $m);echo $role;
                } ?>
            </td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">电子邮箱：</td>
            <td><input type="text" name="email" id="user_email" value="<?php echo $email ?>"><label id="_email" class="_style">邮箱格式错误！</label></td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">手机号：</td>
            <td><input type="text" name="mobile" id="user_mobile" value="<?php echo $mobile ?>"><label id="_mobile" class="_style">手机号格式错误！</label></td>
        </tr>        
        <tr>
            <td class="tdBg" width="200px">生日：</td>
            <td><input type="text" name="birthday" readonly="true" id="birthday" value="<?php echo $birthday ?>"></td>
        </tr>
		<tr>
            <td class="tdBg" width="200px">状态：</td>
            <td>
                <?php $m = $state == '1';$fm = $state == '0';echo form_radio('state', '1', $m);echo '有效';echo form_radio('state', '0', $fm); echo '无效' ?>
            </td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">备注：</td>
            <td><textarea name="memo" rows="3" cols="75" id="user_memo"><?php echo $memo ?></textarea><label id="_memo" class="_style">不能超过200字！</label></td>
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



    // 缓存以前的账户名，用来做账户验证
    var preAcc = $("#preAcc").val();

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

    //账户名验证，使用ajax（应该还要排除当前账户，思路是先缓存原值，在作对比）
    $("#user_account").change(function(){
        var account = $("#user_account").val();
        var id = $("#user_id").val();
        /*indexOf 如果不包含某字符就返回-1*/
        if (/^[a-zA-Z0-9_-]+$/.test(account) && !(preAcc == account)) {
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

        if(!(/^[a-zA-Z0-9_-]+$/.test(account))){
            $("#_account_b").css("display","inline");
        }

        var id = $("#user_id").val();
        /* 表单提交时的验证必须使用同步的方式，如果使用异步，那么在执行异步回调函数内容之前表单就已经提交了，
            此时再更改标记就没有任何意义了，因此此时会出现表单验证无效或者表单不能提交的情况，输入框失焦事件则
            不会存在这个问题，因为回调方法中并没有影响到后续程序执行的代码。
         */
        if (/^[a-zA-Z0-9_-]+$/.test(account) && !(preAcc == account)) {
            $.ajax({ 
                url:"<?php echo $basePath.'nsfw/user/UserCtrl/validate/account/' ?>" + account,
                type:"get",
                async:false,
                dataType:"json",
                success:function(data){
                    var isExist = data.msg;
                    if("true" != isExist){
                        $("#_account_a").css("display","inline");
                    }else{
                        isAccount = true;
                    } 
                }
            });
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