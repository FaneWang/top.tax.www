<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib prefix="s" uri="/struts-tags" %>
<%
    String path = request.getContextPath();
    String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>
            <div class="c_pate" style="margin-top: 5px;">
                <s:if test="pageResult.totalCount > 0">
                <table width="100%" class="pageDown" border="0" cellspacing="0"
                       cellpadding="0">
                    <tr>
                        <td align="right">
                            总共 <s:property value="pageResult.totalCount"/> 条记录，当前第 <s:property value="pageResult.pageNo"/> 页，共 <s:property value="pageResult.pageCount"/> 页 &nbsp;&nbsp;
                            <%--防止超出下限--%>
                            <s:if test="%{pageResult.pageNo > 1}">
                                <a href="javascript:doGoPage(<s:property value='%{pageResult.pageNo - 1}'/>)">上一页</a>
                            </s:if>
                            <%--防止超出上限--%>
                            <s:if test="%{pageResult.pageNo < pageResult.pageCount}">
                                <a href="javascript:doGoPage(<s:property value='%{pageResult.pageNo + 1}'/>)">下一页</a>
                            </s:if>
                            到&nbsp;<input id="pageNo" name="pageNo" type="text" style="width: 30px;" onkeypress="if(event.keyCode == 13){doGoPage(this.value);}" min="1"
                                          max="" value="<s:property value='pageResult.pageNo'/>" /> &nbsp;&nbsp;
                        </td>
                    </tr>
                </table>
                </s:if>
                <s:else>
                    暂无记录！
                </s:else>
            </div>

<script type="text/javascript">
    function doGoPage(pageNo){
        $("#pageNo").val(pageNo);
        var form1 = $("form[name='form1']")[0];
        form1.action = list_url;
        form1.submit();
    }

</script>