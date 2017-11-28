<html>
<head>
	<title>Upload Form</title>
</head>
<body>

	<?php echo $error;?>

	<?php echo form_open_multipart('nsfw/user/UserCtrl/do_upload');?>

	<input type="file" name="userfile" size="20" />
	<input type="text" name="ddd">

	<br /><br />

	<input type="submit" value="upload" />

</form>

</body>
</html>