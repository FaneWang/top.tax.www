<%@ page language="java" import="java.util.*" pageEncoding="utf-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
    /*拿到当前年度以及往前的5年*/
    Calendar calendar = Calendar.getInstance();
    int currentYear = calendar.get(Calendar.YEAR);
    request.setAttribute("currentYear",currentYear);
    List<Integer> years = new ArrayList<>();
    for (int i = currentYear; i > currentYear - 5 ; i--) {
        years.add(i);
    }
    request.setAttribute("years",years);
%>

<!DOCTYPE HTML>
<html>
  <head>
    <%@include file="/common/header.jsp"%>
    <title>年度投诉统计图</title>
      <script type="text/javascript" src="${basePath}js/fusioncharts-suite-xt/fusioncharts.js"></script>
      <script type="text/javascript" src="${basePath}js/fusioncharts-suite-xt/themes/fusioncharts.theme.ocean.js"></script>
      <script type="text/javascript" src="${basePath}js/fusioncharts-suite-xt/fusioncharts.charts.js"></script>
      <script type="text/javascript">
          /*页面加载完成后执行方法*/
          $(document).ready(doAnnualStatistic());
          /*使用ajax按年份异步加载统计表*/
          function doAnnualStatistic() {
              /*获取当前年份,如果没有值，默认为当前年份*/
              var curYear = $("#year").val();
              if(curYear == "" || curYear == undefined){
                  curYear = "${currentYear}";
              }
              $.ajax({
                  url:"${basePath}nsfw/complain_getAnnualStatisticChartData.action",
                  data:{"year":curYear},
                  type:"get",
                  dataType:"json",
                  success:function (data) {
                      var revenueChart = new FusionCharts({
                          "type": "line",
                          "renderAt": "chartContainer",
                          "width": "600",
                          "height": "400",
                          "dataFormat": "json",
                          "dataSource":  {
                              "chart": {
                                  "caption": curYear + "年年度投诉统计表",
                                  "xAxisName": "月  份",
                                  "yAxisName": "投 诉 数",
                                  "theme": "ocean"
                              },
                              "data":data.chartData
                          }

                      });
                      revenueChart.render();
                  },
                  error:function () {
                      alert("获取年度投诉统计表失败！");
                  }
              });
          }

      </script>

      <style type="text/css">
          ._charts{
              text-align: center;
          }
      </style>
  </head>
  
  <body>
  	<br>
    <div class="_charts">
        <s:select id="year" list="#request.years" onchange="doAnnualStatistic()"></s:select>
    </div>
    <br>
    <div id="chartContainer" class="_charts"></div>
  <s:debug></s:debug>
  </body>
</html>
