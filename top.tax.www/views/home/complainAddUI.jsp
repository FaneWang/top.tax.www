<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%
    pageContext.setAttribute("basePath", request.getContextPath()+"/") ;
%>
<html>
<head>
    <%@include file="/common/header.jsp"%>
    <script type="text/javascript" charset="utf-8" src="${basePath}js/ueditor-1.4.3/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="${basePath}js/ueditor-1.4.3/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="${basePath}js/ueditor-1.4.3/lang/zh-cn/zh-cn.js"></script>
    <title>我要投诉</title>
</head>
<body>
<form id="form" name="form" action="${basePath}sys/home_complainAdd.action" method="post" enctype="multipart/form-data">
    <div class="vp_d_1">
        <div style="width:1%;float:left;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <div class="vp_d_1_1">
            <div class="content_info">
    <div class="c_crumbs"><div><b></b><strong>工作主页</strong>&nbsp;-&nbsp;我要投诉</div></div>
    <div class="tableH2">我要投诉</div>
    <table id="baseInfo" width="100%" align="center" class="list" border="0" cellpadding="0" cellspacing="0"  >
        <tr>
            <td class="tdBg" width="250px">投诉标题：</td>
            <td><s:textfield name="complain.compTitle"/></td>
        </tr>
        <tr>
            <td class="tdBg">被投诉人部门：</td>
            <td>
                <s:select name="complain.toCompDept" id="toCompDept" list="#{'':'请选择','经营部':'经营部','工程部':'工程部','财务部':'财务部'}"></s:select>
            </td>
        </tr>
        <tr>
            <td class="tdBg">被投诉人姓名：</td>
            <td>
                <select name="complain.toCompName" id="toCompName"></select>
            </td>
        </tr>
        <tr>
            <td class="tdBg">投诉内容：</td>
            <td><s:textarea id="editor" name="complain.compContent" cssStyle="width:90%;height:160px;" /></td>
        </tr>
        <tr>
            <td class="tdBg">是否匿名投诉：</td>
            <td><s:radio name="complain.isAnon" list="#{'0':'非匿名投诉','1':'匿名投诉' }" value="1"/></td>
        </tr>
        <%--国税系统只有登录后才能使用，那么必然存在一个用户，假设这个用户是普通客户，那么国税的员工就是管理员--%>
       <s:hidden name="complain.compComp" value="%{#session.SYS_USER.dept}"/>
        <s:hidden name="complain.compName" value="%{#session.SYS_USER.name}"/>
        <s:hidden name="complain.compMobile" value="%{#session.SYS_USER.mobile}"/>
    </table>

    <div class="tc mt20">
        <input type="button" id="submit" class="btnB2" value="保存" />
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button"  onclick="javascript:window.close()" class="btnB2" value="关闭" />
    </div>
    </div></div>
    <div style="width:1%;float:left;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
    </div>
</form>
<script type="text/javascript">
    //使用富文本编辑器
    window.UEDITOR_HOME_URL = "${basePath}js/ueditor-1.4.3/"
    var ue = UE.getEditor('editor');

    //二级联动获取部门员工
    $("#toCompDept").change(function(){
        var toDept = $("#toCompDept").val();
        /*indexOf 如果不包含某字符就返回-1*/
        if (toDept != "") {
            $.ajax({
                url:"${basePath}sys/home_homeGetJson.action",
                data:{"toDept":toDept},
                type:"post",
                dataType:"json",
                success:function(data){
                    if(data != null && data != undefined){
                        if("success" == data.msg){
                            var $toCompName = $("#toCompName");
                            $toCompName.empty();
                            $.each(data.users,function (i,user) {
                                $toCompName.append("<option value = '" + user.name + "'>" + user.name + "</option>");
                            });
                        }else{
                            alert("获取部门人员列表失败！");
                        }
                    }else{
                        alert("获取部门人员列表失败！");
                    }
                },
                error:function () {
                    alert("获取部门人员列表失败！");
                }
            });
        }else{
            $("#toCompName").empty();
        }
    });

    //异步保存投诉信息
    $("#submit").click(function(){
            $.ajax({
                url:"${basePath}sys/home_complainAdd.action",
                data:$("#form").serialize(),
                type:"post",
                success:function(data){
                    if(data != null && data != undefined){
                        if("success" == data){
                            alert("投诉成功！");
                            window.opener.parent.location.reload(true);
                            window.close();
                        }else{
                            alert("投诉失败！");
                        }
                    }else{
                        alert("投诉失败！");
                    }
                },
                error:function () {
                    alert("投诉失败！");
                }
            });
    });
</script>
</body>
</html>