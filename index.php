<!DOCTYPE html>
<html>
<head>
	
</head>
<body>
<?php
include ('Verify.php');
include ('Bmp2Jpg.php');
if (isset($_FILES['imgfile'])&& is_uploaded_file($_FILES['imgfile']['tmp_name']))
{
	$imgFile = $_FILES['imgfile'];
	$imgFileName = $imgFile['name'];
	$imgType = $imgFile['type'];
	$imgSize = $imgFile['size'];
	$imgTmpFile = $imgFile['tmp_name'];
	$newFileName=time();
	move_uploaded_file($imgTmpFile, 'upfile/'.$newFileName.".bmp");
	$validType = false;
	$upRes = $imgFile['error'];
	if ($upRes == 0)
	{
		if ($imgType == 'image/bmp')
		{
			$validType = true;
		}
		if ($validType)
		{
			$strPrompt = sprintf("原图：<img src='upfile/%s'><br/>"
			,$newFileName.".bmp"
			);
			echo $strPrompt;

			$b2j=new Bmp2Jpg();

			$img = $b2j->ImageCreateFromBmp('upfile/'.$newFileName.".bmp");
			
			imagejpeg($img, 'verify/'.$newFileName.".jpg");
			$verify=new verify();
			$verify->setPicture('verify/'.$newFileName.".jpg");
			echo "识别结果：";
			$verify->start();
		}
	}
}
?>
	<form action="" method="post" enctype="multipart/form-data" name="upload_form">
	  <label>选择图片文件</label>
	  <input name="imgfile" type="file" accept="image/bmp"/>
	  <input name="upload" type="submit" value="识别" />
	</form>
</body>
</html>
