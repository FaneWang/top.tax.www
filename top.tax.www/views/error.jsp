<%@ page language="java" import="java.util.*" pageEncoding="utf-8"%>
<%@ taglib prefix="s" uri="/struts-tags" %>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <base href="<%=basePath%>">
    
    <title>系统异常信息</title>
    
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">    
	<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
	<meta http-equiv="description" content="This is my page">
	<!--
	<link rel="stylesheet" type="text/css" href="styles.css">
	-->

  </head>
  
  <body>
  	<img src="<%=request.getContextPath() %>/images/common/error.jpg">
    <br>
    <%--这里取到的exception是Action中抛出的异常ActionException，放到了栈顶，
        怎么拿到父类的私有属性errorMsg的呢？子异常类拥有父类的get/set方法，struts标签通过get/set方法注入的
    --%>
    <s:if test="exception.errorMsg != '' && exception.errorMsg != null">
    	<s:property value="exception.errorMsg"/>
    </s:if>
    <s:else>
        <%--这里取值是通过Exception的父类Throwable的get方法--%>
    	操作失败！<s:property value="exception.message"/>
    </s:else>
  <s:debug></s:debug>
  </body>
</html>
