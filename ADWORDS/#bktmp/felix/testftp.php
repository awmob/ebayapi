<?php

set_time_limit(30);
/*
$ftp_server="www.soldsmart.com.au";
 $ftp_user_name="001";
 $ftp_user_pass="effecifa$";
 $file = "";//tobe uploaded
 $remote_file = "";

 // set up basic connection
 $conn_id = ftp_connect($ftp_server, 21000);


 SoldSmartUse
SoldSmartUse/Datafeed_Unitex.txt
            <User>002</User>
            <Pass>vatimade#</Pass>
 http://www.web-development-blog.com/archives/tutorial-ftp-upload-via-curl/
*/

$login = rawurlencode("002");
$pass = rawurlencode("vatimade#");

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "ftp://".$login.":".$pass."@www.soldsmart.com.au:21000/");   //ftp://ftp_login:password@ftp.domain.com/



//curl_setopt($curl, CURLOPT_COOKIEJAR, "cookies.txt");
curl_setopt($curl, CURLOPT_PORT, 21000);
//curl_setopt($curl, CURLOPT_USERPWD, "002:vatimade#");





$result = curl_exec($curl);
$error_no = curl_errno($curl);
curl_close($curl);


		if ($error_no == 0) {
        	$error = 'Success.';
        } else {
        	$error = 'Error.' . $error_no;
        }

echo $error;

echo "<p>";

echo $result;

echo "</p>";

?>