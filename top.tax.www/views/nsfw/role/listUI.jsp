<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <%@include file="/common/header.jsp"%>
    <title>角色管理</title>

</head>
<body class="rightBody">
<form name="form1" action="" method="post">
    <div class="p_d_1">
        <div class="p_d_1_1">
            <div class="content_info">
                <div class="c_crumbs"><div><b></b><strong>角色管理 </strong></div> </div>
                <div class="search_art">
                    <li>
                        角色名称：<s:textfield name="role.roleName" cssClass="s_text" id="roleName"  cssStyle="width:160px;"/>
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
                            <td width="120" align="center">角色名称</td>
                            <td align="center">权限</td>
                            <td width="80" align="center">状态</td>
                            <td width="120" align="center">操作</td>
                        </tr>
                       	<s:iterator value="roles" status="st">
                            <tr  <s:if test="#st.odd">bgcolor="#ffe5e5"</s:if><s:else>bgcolor="#eeffe5"</s:else>>
                                <s:set var="count" value="#st.count" scope="page"></s:set>
                                <td align="center"><input type="checkbox" name="selectedRow" value="<s:property value='roleId'/>"/></td>
                                <td align="center"><s:property value="roleName"/></td>
                                <td align="center">
                                    <%--在开始执行时, iterator 标签会先把 IteratorStatus 类的一个实例压入
                                     ContextMap, 并在每次遍历循环时更新它. 可以将一个指向 IteratorStatus
                                     对象的变量赋给 status 属性.--%>
                                    <s:iterator value="roleRelations">
                                        <s:property value="#privilegeMap[roleCompositeKeys.code]"/>&nbsp;
                                    </s:iterator>
                                </td>
                                <td align="center"><s:property value="state==1?'有效':'无效'"/></td>
                                <td align="center">
                                    <a href="javascript:doEdit('<s:property value='roleId'/>')">编辑</a>
                                    <a href="javascript:doDelete('<s:property value='roleId'/>')">删除</a>
                                </td>
                            </tr>
                        </s:iterator>
                    </table>
                </div>
            </div>
			<div class="c_pate" style="margin-top: 5px;">
		<table width="100%" class="pageDown" border="0" cellspacing="0"
			cellpadding="0">
			<tr>
				<td align="right">
                 	总共${count }条记录，当前第 1 页，共 1 页 &nbsp;&nbsp;
                            <a href="#">上一页</a>&nbsp;&nbsp;<a href="#">下一页</a>
					到&nbsp;<input type="text" style="width: 30px;" onkeypress="if(event.keyCode == 13){doGoPage(this.value);}" min="1"
					max="" value="1" /> &nbsp;&nbsp;
			    </td>
			</tr>
		</table>	
        </div>
        </div>
    </div>
</form>
<script type="text/javascript">

    function doAdd(){
        var form1 = $("form[name='form1']")[0];
        form1.action = "${basePath}nsfw/role_addUI.action";
        form1.submit();
    }
    //全选、全反选
    function doSelectAll(){
        // jquery 1.6 前
        //$("input[name=selectedRow]").attr("checked", $("#selAll").is(":checked"));
        //prop jquery 1.6+建议使用
        $("input[name='selectedRow']").prop("checked", $("#selAll").is(":checked"));
    }

    function doDeleteAll() {
        var form1 = $("form[name='form1']")[0];
        form1.action = "${basePath}nsfw/role_deleteSelected.action";
        form1.submit();
    }

    function doEdit(roleId){
        var form1 = $("form[name='form1']")[0];
        form1.action = "${basePath}nsfw/role_editUI.action?role.roleId=" + roleId;
        form1.submit();
    }

    function doDelete(roleId){
        var form1 = $("form[name='form1']")[0];
        form1.action = "${basePath}nsfw/role_delete.action?role.roleId=" + roleId;
        form1.submit();
    }
</script>
<s:debug></s:debug>
</body>
</html>