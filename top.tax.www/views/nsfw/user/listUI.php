<!DOCTYPE html>
<html>
<head>
    <title>用户管理</title>
    <?php $rootPath = $_SERVER['DOCUMENT_ROOT'].'/';include $rootPath.'common/header.php'; ?>
    <script type="text/javascript">
        function doDeleteAll() {
            var form1 = $("form[name='form1']")[0];
            form1.action = "<?php echo $basePath.'nsfw/user/UserCtrl/deleteAll' ?>";
            form1.submit();
        }

        function doAdd() {
            var form1 = $("form[name='form1']")[0];
            form1.action = "<?php echo $basePath.'nsfw/user/UserCtrl/addUI' ?>";
            form1.submit();
        }
        function doEdit(id){
            var form1 = $("form[name='form1']")[0];
            form1.action = "<?php echo $basePath.'nsfw/user/UserCtrl/editUI' ?>" + "/id/" + id;
            form1.submit();
        }
        function doDelete(id){
            var form1 = $("form[name='form1']")[0];
            form1.action = "<?php echo $basePath.'nsfw/user/UserCtrl/delete' ?>" + "/id/" + id;
            form1.submit();
        }

        function doExportExcel(){
            var form1 = $("form[name='form1']")[0];
            form1.action = "<?php echo $basePath.'nsfw/user/UserCtrl/import' ?>";
            form1.submit();
        }
        function doImportExcel(){
            var form1 = $("form[name='form1']")[0];
            form1.action = "<?php echo $basePath.'nsfw/user/UserCtrl/export' ?>";
            form1.submit();
        }

        //全选、全反选
		function doSelectAll(){
			// jquery 1.6 前
			//$("input[name=selectedRow]").attr("checked", $("#selAll").is(":checked"));
			//prop jquery 1.6+建议使用
			$("input[name='selectedRow']").prop("checked", $("#selAll").is(":checked"));
		}
    </script>
</head>
<body class="rightBody">
<form name="form1" action="" method="post" enctype="multipart/form-data">
    <div class="p_d_1">
        <div class="p_d_1_1">
            <div class="content_info">
                <div class="c_crumbs"><div><b></b><strong>用户管理</strong></div> </div>
                <div class="search_art">
                    <li>
                        用户名： <input type="text" name="search" cssClass="s_text" id="userName"  cssStyle=width:160px;" value="<?php echo $keyword ?>"/>
                    </li>
                    <li><input type="button" class="s_button" value="搜 索" onclick="doSearch()"/></li>
                    <li style="float:right;">
                        <input type="button" value="新增" class="s_button" onclick="doAdd()"/>&nbsp;
                        <input type="button" value="删除" class="s_button" onclick="doDeleteAll()"/>&nbsp;
                        <input type="button" value="导出" class="s_button" onclick="doExportExcel()"/>&nbsp;
                    	<input name="userExcel" type="file"/>
                        <input type="button" value="导入" class="s_button" onclick="doImportExcel()"/>&nbsp;

                    </li>
                </div>

                <div class="t_list" style="margin:0px; border:0px none;">
                    <table width="100%" border="0">
                        <tr class="t_tit">
                            <td width="30" align="center"><input type="checkbox" id="selAll" onclick="doSelectAll()" /></td>
                            <td width="140" align="center">用户名</td>
                            <td width="140" align="center">帐号</td>
                            <td width="160" align="center">所属部门</td>
                            <td width="80" align="center">性别</td>
                            <td align="center">电子邮箱</td>
                            <td width="100" align="center">操作</td>
                        </tr>
                        
                        <?php $i = 0;if(isset($users)){ ?>
                        <?php foreach($users as $user){ ?>
                            <tr bgcolor="<?php if($i%2 ==  0){echo '#ffe5e5';}else{echo '#eeffe5';} $i++; ?>" >
                                <td align="center"><input type="checkbox" name="selectedRow" value="<?php echo $user['id']; ?>"/></td>
                                <td align="center"><?php echo $user['name']; ?></td>
                                <td align="center"><?php echo $user['account']; ?></td>
                                <td align="center"><?php echo $user['dept']; ?></td>
                                <td align="center"><?php echo $user['gender'] === '1' ? '男' : '女'; ?></td>
                                <td align="center"><?php echo $user['email']; ?></td>
                                <td align="center">
                                    <a href="javascript:doEdit('<?php echo $user['id']; ?>')">编辑</a>
                                    <a href="javascript:doDelete('<?php echo $user['id']; ?>')">删除</a>
                                </td>
                            </tr>
                        <?php }} ?>
                    </table>
                </div>
            </div>
        <div class="c_pate" style="margin-top: 5px;">
		<table width="100%" class="pageDown" border="0" cellspacing="0"
			cellpadding="0">
			<tr>
				<td align="right">
                 	总共<?php echo $total ?>条记录，当前第 <?php echo $pageNo ?> 页，共 <?php echo $totalCount ?> 页 &nbsp;&nbsp;
                            <?php if($pageNo > 1){ ?><a href="javascript:doGoPage(<?php echo $pageNo - 1 ?>)">上一页</a>&nbsp;&nbsp;<?php } ?><?php if($pageNo < $totalCount){ ?><a href="javascript:doGoPage(<?php echo $pageNo + 1 ?>)">下一页</a><?php } ?>
					到&nbsp;<input type="text" style="width: 30px;" id="pageNo" name="pageNo" onkeypress="if(event.keyCode == 13){doGoPage(this.value);}" min="1"
					max="" value="<?php echo $pageNo ?>" /> &nbsp;&nbsp;
			    </td>
			</tr>
		</table>	
        </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    function doGoPage(pageNo){
        $('#pageNo').val(pageNo);
        var form1 = $("form[name='form1']")[0];
        form1.action = "<?php echo $basePath.'nsfw/user/UserCtrl/listUI' ?>";
        form1.submit();
    }

    function doSearch(){
        var form1 = $("form[name='form1']")[0];
        form1.action = "<?php echo $basePath.'nsfw/user/UserCtrl/listUI' ?>";
        form1.submit();
    }

</script>
</body>
</html>