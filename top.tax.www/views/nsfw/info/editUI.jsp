<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <%@include file="/common/header.jsp"%>
    <title>信息发布管理</title>
    <link rel="stylesheet" href="${basePath}css/nsfw/validate.css">
    <script type="text/javascript" charset="utf-8" src="${basePath}js/ueditor-1.4.3/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="${basePath}js/ueditor-1.4.3/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="${basePath}js/ueditor-1.4.3/lang/zh-cn/zh-cn.js"></script>
</head>
<body class="rightBody">
<form id="form" name="form" action="${basePath}nsfw/info_edit.action" method="post" enctype="multipart/form-data">
    <div class="p_d_1">
        <div class="p_d_1_1">
            <div class="content_info">
    <div class="c_crumbs"><div><b></b><strong>信息发布管理</strong>&nbsp;-&nbsp;修改信息</div></div>
    <div class="tableH2">修改信息</div>
    <s:hidden name="info.infoId"/>
    <table id="baseInfo" width="100%" align="center" class="list" border="0" cellpadding="0" cellspacing="0"  >
        <tr>
            <td class="tdBg" width="200px">信息分类：</td>
            <td><s:select name="info.type" list="#INFO_TYPE"/></td>
            <td class="tdBg" width="200px">来源：</td>
            <td><s:textfield name="info.source"/><label id="_source" class="_style">字数错误！</label></td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">信息标题：</td>
            <td colspan="3"><s:textfield name="info.title" cssStyle="width:90%"/><label id="_title" class="_style">字数错误！</label></td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">信息内容：</td>
            <td colspan="3"><s:textarea id="editor" name="info.content" cssStyle="width:90%;height:160px;" /></td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">备注：</td>
            <td colspan="3"><s:textarea name="info.memo" cols="90" rows="3"/><label id="_memo" class="_style">字数错误！</label></td>
        </tr>
        <tr>
            <td class="tdBg" width="200px">创建人：</td>
            <td>
                <s:property value="info.creator"/>
                <s:hidden name="info.creator"></s:hidden>
            </td>
            <td class="tdBg" width="200px">创建时间：</td>
            <td>
                <s:date name="info.createTime" format="yy-MM-dd hh:mm"/>
            </td>
        </tr>
    </table>
    <%--必须给一个隐藏域ID，不然会报错--%>
    <s:hidden name="info.state"/>
    <s:hidden name="tempTitle"></s:hidden>
    <div class="tc mt20">
        <input type="button" class="btnB2" value="保存" />
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button"  onclick="javascript:history.go(-1)" class="btnB2" value="返回" />
    </div>
    </div></div></div>
</form>
<script type="text/javascript">
    //验证来源字数
    $("#info_source").focusout(function(){
        var source = $("#info_source").val();
        if (source.length > 50 || source.length == 0) {
            $("#_source").css("display","inline");
        }
    });
    $("#info_source").focusin(function(){
        $("#_source").css("display","none");
    });
    //验证标题字数
    $("#info_title").focusout(function(){
        var title = $("#info_title").val();
        if (title.length > 100 || title.length == 0) {
            $("#_title").css("display","inline");
        }
    });
    $("#info_title").focusin(function(){
        $("#_title").css("display","none");
    });
    //验证备注字数
    $("#info_memo").focusout(function(){
        var memo = $("#info_memo").val();
        if (memo.length > 200) {
            $("#_memo").css("display","inline");
        }
    });
    $("#info_memo").focusin(function(){
        $("#_memo").css("display","none");
    });




    $("input[value='保存']").click(function () {
        var isSource = false;
        var isTitle = false;
        var isMemo = true;

        //验证来源字数
        var source = $("#info_source").val();
        if (source.length > 50 || source.length == 0) {
            $("#_source").css("display","inline");
        }else{
            isSource = true;
        }
        //验证标题字数

        var title = $("#info_title").val();
        if (title.length > 100 || title.length == 0) {
            $("#_title").css("display","inline");
        }else{
            isTitle = true;
        }

        //验证备注字数

        var memo = $("#info_memo").val();
        if (memo.length > 200) {
            $("#_memo").css("display","inline");
            isMemo = false;
        }else{
            isMemo = true;
        }
        if(isSource && isTitle && isMemo){
            $("#form")[0].submit();
        }
    });

    /*使用ueditor富文本编辑器*/
    window.UEDITOR_HOME_URL = "${basePath}js/ueditor-1.4.3/"
    var ue = UE.getEditor('editor');
</script>
<script type="text/javascript" src="${basePath}js/wangEditor-2.1.23/wangEditor.js"></script>
</body>
</html>