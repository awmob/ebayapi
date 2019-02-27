<?php

Class kerpcurler{

	function __construct($auto_login){
		
		//the location to save the cookie
		define("COOKIEFILELOC","c:/wamp/www/cookie.txt");

		//page to perform login for the password, username etc.
		define("KERP_LOGIN_PAGE","http://www.kerp.biz/kerpadmin/logon.aspx?ReturnUrl=%2fkerpadmin%2fblast.aspx");

		//login, pass etc.
		define("KERP_LOGIN","andrewm");	
		define("KERP_PASS","ponaveci");

		//data page to pass to curler
		define("KERP_LOGIN_DATA","__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=dDw1OTI1NjMwOTt0PDtsPGk8MT47PjtsPHQ8O2w8aTwxPjtpPDM%2BOz47bDx0PHA8cDxsPFRleHQ7PjtsPE1hbmFnZW1lbnQgQXJlYSBMb2dvbjs%2BPjs%2BOzs%2BO3Q8cDxwPGw8VGV4dDs%2BO2w8UGxlYXNlIGVudGVyIHlvdXIgVXNlck5hbWUgYW5kIFBhc3N3b3JkIHRvIGxvZyBpbi4gOz4%2BOz47Oz47Pj47Pj47Pmx7v54OyhnmL%2BMzkmepkwtnpus3&txtUserName=".KERP_LOGIN."&txtPassword=".KERP_PASS."&butOK=++OK++");




		//misc kerp pages
		define("KERP_GOODS_PAGE","http://www.kerp.biz/kerpadmin/goods.aspx");


		


		//if auto login is selectd then login upon class creation
		if ($auto_login){
			$login = $this->curl_main_login(KERP_LOGIN_PAGE,KERP_LOGIN_DATA,"","off");

		}




	}








	/*VIEWSTATE FUNCTIONS */

	function load_goods_page_viewstate($sku){
		$viewstate = "__VIEWSTATE=dDw5ODU2MDgxNjt0PDtsPGk8MT47PjtsPHQ8O2w8aTwxPjtpPDM%2BO2k8MjU%2BO2k8Mzc%2BOz47bDx0PDtsPGk8Mz47PjtsPHQ8cDxwPGw8VmlzaWJsZTs%2BO2w8bzxmPjs%2BPjs%2BOzs%2BOz4%2BO3Q8cDxsPFRleHQ7PjtsPEVtcHR5Oz4%2BOzs%2BO3Q8dDw7dDxpPDE4Mz47QDwyMDA2MTIyMzE2MjYzMDsyMDA2OTE3MTQ4Mjk7MjAwNjkxNzE0ODMwOzIwMDY5MTcxNDgzMTsyMDA2OTE3MTQ4MzI7MjAwNjkxNzE0ODMzOzIwMDY5MTcxNDgzNDsyMDA2OTE3MTQ4MzU7MjAwNjkxNzE0ODM2OzIwMDY5MTcxNDgzNzsyMDA2OTE3MTQ4Mzg7MjAwNjkxNzE0ODM5OzIwMDY5MTcxNDg0MDsyMDA2OTE3MTQ4NDE7MjAwNjkxNzE0ODQyOzIwMDY5MTcxNDg0MzsyMDA2OTE3MTQ4NDQ7MjAwNjkxNzE0ODQ1OzIwMDY5MTcxNDg0NjsyMDA2OTE3MTQ4NDc7MjAwNjkxNzE0ODQ4OzIwMDY5MTcxNDg0OTsyMDA2OTE3MTQ4NTA7MjAwNjkxNzE0ODUxOzIwMDY5MTcxNDg1MjsyMDA2OTE3MTQ4NTM7MjAwNjkxNzE0ODU0OzIwMDY5MTcxNDg1NTsyMDA2OTE3MTQ4NTY7MjAwNjkxNzE0ODU3OzIwMDY5MTcxNDg1ODsyMDA2OTE3MTQ4NTk7MjAwNjkxNzE0ODYwOzIwMDY5MTcxNDg2MTsyMDA2OTE3MTQ4NjI7MjAwNjkxNzE0ODYzOzIwMDY5MTcxNDg2NDsyMDA2OTE3MTQ4NjU7MjAwNjkxNzE0ODY2OzIwMDY5MTcxNDg2NzsyMDA2OTE3MTQ4Njg7MjAwNjkxNzE0ODY5OzIwMDY5MTcxNDg3MDsyMDA2OTE3MTQ4NzE7MjAwNjkxNzE0ODcyOzIwMDY5MTcxNDg3MzsyMDA2OTE3MTQ4NzQ7MjAwNjkxNzE0ODc1OzIwMDY5MTcxNDg3NjsyMDA2OTE3MTQ4Nzc7MjAwNjkxNzE0ODc4OzIwMDY5MTcxNDg3OTsyMDA2OTE3MTQ4ODA7MjAwNjkxNzE0ODgxOzIwMDY5MTcxNDg4MjsyMDA2OTE3MTQ4ODM7MjAwNjkxNzE0ODg0OzIwMDY5MTcxNDg4NTsyMDA2OTE3MTQ4ODY7MjAwNjkxNzE0ODg3OzIwMDY5MTcxNDg4ODsyMDA2OTE3MTQ4ODk7MjAwNjkxNzE0ODkxOzIwMDY5MTcxNDg5MzsyMDA2OTE3MTQ4OTQ7MjAwNjkxNzE0ODk1OzIwMDY5MTcxNDg5NjsyMDA2OTE3MTQ4OTc7MjAwNjkxNzE0ODk4OzIwMDY5MTcxNDg5OTsyMDA2OTE3MTQ5MDA7MjAwNjkxNzE0OTAxOzIwMDY5MTcxNDkwMjsyMDA2OTE3MTQ5MDM7MjAwNjkxNzE0OTA0OzIwMDY5MTcxNDkwNTsyMDA2OTE3MTQ5MDY7MjAwNjkxNzE0OTA3OzIwMDY5MTcxNDkwODsyMDA2OTE3MTQ5MDk7MjAwNjkxNzE0OTEwOzIwMDY5MTcxNDkxMTsyMDA2OTE3MTQ5MTI7MjAwNjkxNzE0OTEzOzIwMDY5MTcxNDkxNDsyMDA2OTE3MTQ5MTU7MjAwNjkxNzE0OTE2OzIwMDY5MTcxNDkxNzsyMDA2OTE3MTQ5MTg7MjAwNjkxNzE0OTE5OzIwMDY5MTcxNDkyMDsyMDA2OTE3MTQ5MjE7MjAwNjkxNzE0OTIyOzIwMDY5MTcxNDkyMzsyMDA2OTE3MTQ5MjQ7MjAwNjkxNzE0OTI1OzIwMDY5MTcxNDkyNjsyMDA2OTE3MTQ5Mjc7MjAwNjkxNzE0OTI4OzIwMDY5MTcxNDkzMTsyMDA2OTE3MTQ5MzI7MjAwNjkxNzE0OTMzOzIwMDY5MTcxNDkzNDsyMDA2OTE3MTQ5MzU7MjAwNjkxNzE0OTM2OzIwMDY5MTcxNDkzODsyMDA2OTE3MTQ5Mzk7MjAwNjkxNzE0OTQwOzIwMDY5MTcxNDk0MTsyMDA2OTE3MTQ5NDI7MjAwNjkxNzE0OTQzOzIwMDY5MTcxNDk0NDsyMDA2OTE3MTQ5NDU7MjAwNjkxNzE0OTQ2OzIwMDY5MTcxNDk0NzsyMDA2OTE3MTQ5NDg7MjAwNjkxNzE0OTQ5OzIwMDY5MTcxNDk1MDsyMDA2OTE3MTQ5NTE7MjAwNjkxNzE0OTUyOzIwMDY5MTcxNDk1MzsyMDA2OTE3MTQ5NTQ7MjAwNjkxNzE0OTU1OzIwMDY5MTcxNDk1NjsyMDA2OTE3MTQ5NTc7MjAwNjkxNzE0OTU4OzIwMDY5MTcxNDk1OTsyMDA2OTE3MTQ5NjM7MjAwNjkxNzE0OTY0OzIwMDY5MTcxNDk2NTsyMDA2OTE3MTQ5Njc7MjAwNjkxNzE0OTY4OzIwMDY5MTcxNDk3MDsyMDA2OTE3MTQ5NzE7MjAwNjkxNzE0OTcyOzIwMDY5MTcxNDk3NDsyMDA2OTE3MTQ5NzU7MjAwNjkxNzE0OTc2OzIwMDY5MTcxNDk3NzsyMDA2OTE3MTQ5Nzg7MjAwNjkxNzE0OTc5OzIwMDY5MTcxNDk4MDsyMDA2OTI0MTI1MzMyOzIwMDY5MjQxMjUzMzM7MjAwNjkyNDEyNTMzNDsyMDA3MTExMTYzNjU4OzIwMDcxMTIxMTQ4Mjg7MjAwNzExMjEyNTU3OzIwMDcxMTIxMzI3MjsyMDA3MTE0MTcyMTUyOzIwMDcxMTYxNTQ1MTk7MjAwNzEyNjE0MTQ1NjsyMDA3MTUxNDEwMzM7MjAwNzE1MTUzMDU0OzIwMDcxNTE2MzUzMzsyMDA3MTUxNzAzMzsyMDA3MTcxMDU5NDM7MjAwNzE3MTQyNzU3OzIwMDcxNzE1MjcyMTsyMDA3MTcxNjMwNzsyMDA3MTc5NTA1MDsyMDA3MjIxNTU2NTI7MjAwNzI0MTY0NjQ3OzIwMDcyNDE2NTQ1MjsyMDA3MzE2MTczMTU7MjAwNzMxNzE0NTM0MTsyMDA3MzE4MTYyNTM5OzIwMDczMjUxMjE4NTY7MjAwNzMzMDE1NTU1NzsyMDA3MzMwMTcyNDE5OzIwMDczNTExMTA0NTsyMDA3MzUxMTEyMjY7MjAwNzM2MTIzOTU2OzIwMDc0MTM4NTY0MjsyMDA3NDEzODU4MTQ7MjAwNzQxMzkxNTU7MjAwNzQxMzkzNDI7SFpIO0ltYXJ0O09KTTtTaHJpcm87VGluc2hlZDtZWTs%2BO0A8MjA7MjE7MjI7MjM7MjQ7MjU7MjY7Mjc7Mjg7Mjk7MzA7MzE7MzI7MzM7MzQ7MzU7MzY7Mzc7Mzg7Mzk7NDA7NDE7NDI7NDM7NDQ7NDU7NDY7NDc7NDg7NDk7NTA7NTE7NTI7NTM7NTQ7NTU7NTY7NTc7NTg7NTk7NjA7NjE7NjI7NjM7NjQ7NjU7NjY7Njc7Njg7Njk7NzA7NzE7NzI7NzM7NzQ7NzU7NzY7Nzc7Nzg7Nzk7ODA7ODE7ODI7ODM7ODQ7ODU7ODY7ODc7ODg7ODk7OTA7OTE7OTI7OTM7OTQ7OTU7OTY7OTc7OTg7OTk7MTAwOzEwMTsxMDI7MTAzOzEwNDsxMDU7MTA2OzEwNzsxMDg7MTA5OzExMDsxMTE7MTEyOzExMzsxMTQ7MTE1OzExNjsxMTc7MTE4OzExOTsxMjA7MTIxOzEyMjsxMjM7MTI0OzEyNTsxMjY7MTI3OzEyODsxMjk7MTMwOzEzMTsxMzI7MTMzOzEzNDsxMzU7MTM2OzEzNzsxMzg7MTM5OzE0MDsxNDE7MTQyOzE0MzsxNDQ7MTQ1OzE0NjsxNDc7MTQ4OzE0OTsxNTA7MTUxOzE1MjsxNTM7MTU0OzE1NTsxNTY7MTU3OzE1ODsxNTk7MTYwOzE2MTsxNjI7MTYzOzE2NDsxNjU7MTY2OzE2NzsxNjg7MTY5OzE3MDsxNzE7MTcyOzE3MzsxNzQ7MTc1OzE3NjsxNzc7MTc4OzE3OTsxODA7MTgxOzE4MjsxODM7MTg0OzE4NTsxODY7MTg3OzE4ODsxODk7MTkwOzE5MTsxOTI7MTkzOzE5NDsxOTU7MTk2Ozc7MTM7MTc7MTQ7OTsxNjs%2BPjs%2BOzs%2BO3Q8QDA8cDxwPGw8Q3VycmVudFBhZ2VJbmRleDs%2BO2w8aTwwPjs%2BPjs%2BOzs7Ozs7Ozs7Oz47Oz47Pj47Pj47bDxDaGVja1plcm87Q2hlY2tOZXc7Q2hlY2tQdWI7Pj7SXMaNIKX4fvU23kQ4kO6QWpmPAQ%3D%3D&Top11%3AOpenC1%3ArblOPen=0&Top11%3AOpenC1%3ATextFilter=&TextSearch=".trim($sku)."&ButSearch=%3E&TextFilter=Keywords&ddlSupplier=20&TextItem=";

		return $viewstate;
	}










	/*END VIEWSTATE FUNCIONS

/*******************************NEW FUNCTION*******************************/
/*******************************NEW FUNCTION*******************************/
/*******************************NEW FUNCTION*******************************/

	function altextracter($string, $curler){
		$regex = "#alt=\".+\">#";
		$alt = $curler->matcher($string, $regex,0);
		$alt = str_replace("alt=\"","",$alt);
		$alt = str_replace("\">","",$alt);
		return $alt;
	}




	function newline($string, $newpage){
		$newpage = str_replace($string,$string . "\r\n",$newpage); 
		return $newpage;
	}

	function newlinepre($string, $newpage){
		$newpage = str_replace($string,"\r\n" . $string,$newpage); 
		return $newpage;
	}
/*******************************NEW FUNCTION*******************************/
/*******************************NEW FUNCTION*******************************/
/*******************************NEW FUNCTION*******************************/
	function code_cleanup($newpage){
		$newpage = str_replace("\n","",$newpage);  
		$newpage = str_replace("\t","",$newpage); 
		$newpage = str_replace("\r","",$newpage); 
		return $newpage;
	}

/*******************************NEW FUNCTION*******************************/
/*******************************NEW FUNCTION*******************************/
/*******************************NEW FUNCTION*******************************/

	function matcher($page, $expression,$type){
		preg_match($expression,$page,$desclear);

		if ($type == 1){
			$pagereturn = $desclear[1];
		}

		else {
			$pagereturn = $desclear[0];
		}
		
		return $pagereturn;
	}




/*******************************NEW FUNCTION*******************************/
/*******************************NEW FUNCTION*******************************/
/*******************************NEW FUNCTION*******************************/

function curl_login($urla,$data,$file_path){
	//file to save cookies to
	$fh = fopen($file_path,'w');
	fclose($fh);


	$ch = curl_init($urla); 

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $file_path); 
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch,CURLOPT_HEADER ,true );


	curl_exec($ch);

	curl_close($ch);  


}     

	function curl_ssl_login($url,$data){
		$fp = fopen(COOKIEFILELOC, "w");
		fclose($fp);

		$login = curl_init();
		curl_setopt($login, CURLOPT_COOKIEJAR, COOKIEFILELOC);
		curl_setopt($login, CURLOPT_COOKIEFILE, COOKIEFILELOC);
		curl_setopt($login, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
		curl_setopt($login, CURLOPT_TIMEOUT, 40);
		curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
		if ($proxystatus == 'on') {
			curl_setopt($login, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($login, CURLOPT_HTTPPROXYTUNNEL, TRUE);
			curl_setopt($login, CURLOPT_PROXY, $proxy);
		}
		curl_setopt($login, CURLOPT_URL, $url);
		curl_setopt($login, CURLOPT_HEADER, TRUE);
		curl_setopt($login, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($login, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($login, CURLOPT_POST, TRUE);
		curl_setopt($login, CURLOPT_POSTFIELDS, $data);
		ob_start();      // prevent any output
		return curl_exec ($login); // execute the curl command
		ob_end_clean();  // stop preventing output
		curl_close ($login);
		unset($login);     
	} 





	function curl_main_login($url,$data,$proxy,$proxystatus){
		$fp = fopen(COOKIEFILELOC, "w");
		fclose($fp);

		$login = curl_init();
		curl_setopt($login, CURLOPT_COOKIEJAR, COOKIEFILELOC);
		curl_setopt($login, CURLOPT_COOKIEFILE, COOKIEFILELOC);
		curl_setopt($login, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
		curl_setopt($login, CURLOPT_TIMEOUT, 40);
		curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
		if ($proxystatus == 'on') {
			curl_setopt($login, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($login, CURLOPT_HTTPPROXYTUNNEL, TRUE);
			curl_setopt($login, CURLOPT_PROXY, $proxy);
		}
		curl_setopt($login, CURLOPT_URL, $url);
		curl_setopt($login, CURLOPT_HEADER, TRUE);
		curl_setopt($login, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($login, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($login, CURLOPT_POST, TRUE);
		curl_setopt($login, CURLOPT_POSTFIELDS, $data);
		ob_start();      // prevent any output
		return curl_exec ($login); // execute the curl command
		ob_end_clean();  // stop preventing output
		curl_close ($login);
		unset($login);    
	}               

	function curl_grab_page($site,$proxy,$proxystatus){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if ($proxystatus == 'on') {
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
		}
		curl_setopt($ch, CURLOPT_COOKIEFILE, COOKIEFILELOC);
		curl_setopt($ch, CURLOPT_URL, $site);
		ob_start();      // prevent any output
		return curl_exec ($ch); // execute the curl command
		ob_end_clean();  // stop preventing output
		curl_close ($ch);
	} //end grab_page21/09/2009


	function curl_poster($urla,$data,$file_path){
		$ch = curl_init($urla); 

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $file_path); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, $file_path); 
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch,CURLOPT_HEADER ,true );
		//prevents OBJECT MOVED TO HERE error
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		return $page = curl_exec($ch);

		curl_close($ch);  


	}  

	function curl_getter($urla,$file_path){
		$ch = curl_init($urla); 

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $file_path); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, $file_path); 
		curl_setopt($ch,CURLOPT_HEADER ,false);
		//prevents OBJECT MOVED TO HERE error
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		return $page = curl_exec($ch);

		curl_close($ch);  


	}  


	function curl_ssl_getter($urla,$file_path){
		$ch = curl_init($urla); 

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  FALSE);
		curl_setopt($ch, CURLOPT_USERPWD, 'lenycik:ap4346702ep');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_COOKIEJAR, $file_path); 
		//curl_setopt($ch, CURLOPT_COOKIEFILE, $file_path); 
		curl_setopt($ch,CURLOPT_HEADER ,false);
		//prevents OBJECT MOVED TO HERE error
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		return $page = curl_exec($ch);

		curl_close($ch);  


	}  


	function getviewstate($ch){
		$html = $ch;
		$matches = array();
		preg_match('/<input type="hidden" name="__VIEWSTATE" value="([^"]*?)" \/>/', $html, $matches);
		$viewstate = $matches[1];
		$viewstate = urlencode($viewstate);
		return $viewstate;

	}


}


?>