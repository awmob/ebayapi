<?php

Class curler{

	private $cookie;

	function __construct($cookie_file_location){
		
		//the location to save the cookie
		$this->cookie = $cookie_file_location;
	
	}

     

	function curl_ssl_login($url,$data){
		$fp = fopen($this->cookie, "w");
		fclose($fp);

		$login = curl_init();
		curl_setopt($login, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($login, CURLOPT_COOKIEFILE, $this->cookie);
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
		$fp = fopen($this->cookie, "w");
		fclose($fp);

		$login = curl_init();
		curl_setopt($login, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($login, CURLOPT_COOKIEFILE, $this->cookie);
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
	



	function curl_poster($urla,$data){
		//clear cookie
		$fp = fopen($this->cookie, "w");
		fclose($fp);

		$ch = curl_init($urla); 

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie); 
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch,CURLOPT_HEADER ,true );
		//prevents OBJECT MOVED TO HERE error
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		return $page = curl_exec($ch);

		curl_close($ch);  


	}  

	

//standard file getter with only url and no hidden variables
	function curl_getter($urla){
		$ch = curl_init($urla); 

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie); 
		curl_setopt($ch,CURLOPT_HEADER ,false);
		//prevents OBJECT MOVED TO HERE error
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		$page = curl_exec($ch);
		curl_close($ch);  

		return $page;


	}  

	//$usrpass = 'login:password'
	function curl_ssl_getter($urla, $usrpass){
		$ch = curl_init($urla); 

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  FALSE);
		curl_setopt($ch, CURLOPT_USERPWD, $usrpass);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie); 
		curl_setopt($ch,CURLOPT_HEADER ,false);
		//prevents OBJECT MOVED TO HERE error
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		return $page = curl_exec($ch);

		curl_close($ch);  


	}  


	 

}


?>