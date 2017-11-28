<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <%@include file="/common/header.jsp"%>
    <title>信息发布管理</title>
    <script type="text/javascript">
        var list_url = "${basePath}nsfw/info_listUI.action";
    </script>
</head>
<body class="rightBody">
<form name="form1" action="" method="post">
    <div class="p_d_1">
        <div class="p_d_1_1">
            <div class="content_info">
                <div class="c_crumbs"><div><b></b><strong>信息发布管理</strong></div> </div>
                <div class="search_art">
                    <li>
                        信息标题：<s:textfield name="info.title" cssClass="s_text" id="infoTitle"  cssStyle="width:160px;"/>
                    </li>
                    <li><input type="button" class="s_button" value="搜 索" onclick="doSearch()"/></li>
                    <li style="float:right;">
                        <input type="button" value="新增" class="s_button" onclick="doAdd()"/>&nbsp;
                        <input type="button" value="删除" class="s_button" onclick="doDeleteAll()"/>&nbsp;
                    </li>
                </div>

                <div class="t_list" style="margin:0px; border:0px none;">
                    <table width="100%" border="0">
                        <tr class="t_tit">
                            <td width="30" align="center"><input type="checkbox" id="selAll" onclick="doSelectAll()" /></td>
                            <td align="center">信息标题</td>
                            <td width="120" align="center">信息分类</td>
                            <td width="120" align="center">创建人</td>
                            <td width="140" align="center">创建时间</td>
                            <td width="80" align="center">状态</td>
                            <td width="120" align="center">操作</td>
                        </tr>
                        <s:iterator value="pageResult.list" status="st">
                            <s:set var="count" value="#st.count" scope="page"></s:set>
                            <tr <s:if test="#st.odd">bgcolor="#ffe5e5"</s:if><s:else>bgcolor="#eeffe5"</s:else> >
                                <td align="center"><input type="checkbox" name="selectedRow" value="<s:property value='infoId'/>"/></td>
                                <td align="center"><s:property value="title"/></td>
                                <td align="center">
                                    <s:property value="#INFO_TYPE[type]"/>
                                </td>
                                <td align="center"><s:property value="creator"/></td>
                                <td align="center"><s:date name="createTime" format="yy-MM-dd hh:mm"/></td>
                                <td align="center" id="state_<s:property value='infoId'/>"><s:property value="state == 1?'发布':'停用'"/></td>
                                <td align="center">
                                	<span id="href_<s:property value='infoId'/>">
                                    <s:if test="state==1">
                                        <a href="javascript:doPublicInfo('<s:property value='infoId'/>', 0)">停用</a>
                                    </s:if>
                                	<s:else>
                                        <a href="javascript:doPublicInfo('<s:property value='infoId'/>', 1)">发布</a>
                                    </s:else>
                                	</span>
                                    <a href="javascript:doEdit('<s:property value='infoId'/>')">编辑</a>
                                    <a href="javascript:doDelete('<s:property value='infoId'/>')">删除</a>
                                </td>
                            </tr>
                        </s:iterator>
                    </table>
                </div>
            </div>
        <jsp:include page="/common/pagination.jsp"></jsp:include>

        </div>
    </div>
</form>
<script type="text/javascript">
    function doAdd() {
        var form1 = $("form[name='form1']")[0];
        form1.action = "${basePath}nsfw/info_addUI.action";
        form1.submit();
    }

    function doEdit(id){
        var form1 = $("form[name='form1']")[0];
        form1.action = "${basePath}nsfw/info_editUI.action?info.infoId=" + id;
        form1.submit();
    }

    function doDeleteAll() {
        var form1 = $("form[name='form1']")[0];
        form1.action = "${basePath}nsfw/info_deleteSelected.action";
        form1.submit();
    }

    function doDelete(id){
        var form1 = $("form[name='form1']")[0];
        form1.action = "${basePath}nsfw/info_delete.action?info.infoId=" + id;
        form1.submit();
    }

    //全选、全反选
    function doSelectAll(){
        // jquery 1.6 前
        //$("input[name=selectedRow]").attr("checked", $("#selAll").is(":checked"));
        //prop jquery 1.6+建议使用
        $("input[name='selectedRow']").prop("checked", $("#selAll").is(":checked"));
    }

    function doPublicInfo(id,state){
        $.ajax({
            url:"${basePath}nsfw/info_publicInfo.action",
            data:{"info.infoId":id,"info.state":state},
            type:"get",
            dataType:"json",
            success:function(data){
                var isSuccess = data.msg;
                if("success" == isSuccess){
                    if (state == 1) {
                        $("#state_" + id).text("发布");
                        $("#href_" + id).html("<a href=\"javascript:doPublicInfo('" + id + "', 0)\">停用</a>");
                    } else {
                        $("#state_" + id).text("停用");
                        $("#href_" + id).html("<a href=\"javascript:doPublicInfo('" + id + "', 1)\">发布</a>");
                    }
                }else{
                    alert("更新状态失败！");
                }
            },
            error:function(){alert("更新状态失败！");}
        });
    }

    function doSearch(){
        $("#pageNo").val(0);
        var form1 = $("form[name='form1']")[0];
        form1.action = list_url;
        form1.submit();
    }

</script>
<s:debug></s:debug>
</body>
</html>