<?php


	$cookie_file = "tmp.cookie";
    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, 'http://10.22.151.40/scripts/login.exe/getPassport?');
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 1);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //设置post方式提交
    curl_setopt($curl, CURLOPT_POST, 1);
    //设置post数据
    $post_data = array('UserName'=>'114173125');
	curl_setopt($curl,CURLOPT_COOKIEJAR,$cookie_file);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    //执行命令
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);
    //显示获得的数据
	preg_match_all('|Set-Cookie: (.*);|U', $data, $arr);
	$cookies = implode(';', $arr[1]);
	//var_dump($cookies);
    //print_r($data);
	preg_match_all('/<img(.*?)src=(.*?)\/?>/i', $data, $arr1);
	//var_dump($arr1[2][2]);
	$pic="10.22.151.40";
	$pic=$pic.$arr1[2][2];
	$picurl=str_replace('"', '', $pic);
	//var_dump($picurl);
	
	 
	$curl1 = curl_init($picurl);

	curl_setopt($curl1, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl1, CURLOPT_COOKIEFILE, $cookie_file);
	
	$data1 = curl_exec($curl1);
	curl_close($curl1);
 
//保存验证码图片
	$fp = fopen("valid.bmp","wb");
	fwrite($fp, $data1);
	fclose($fp);
 
   
?>

<div>
<img src="valid.bmp" alt="">
</div>

