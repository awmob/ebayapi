<?php


	Class call_functions{


		
		public function curler($api_endpoint, $headers, $xml_request){
			// Send request to eBay and load response in $response
			//add to separate function in class later --------------------------------------------------------------------------
			$connection = curl_init();
			curl_setopt($connection, CURLOPT_URL, $api_endpoint);
			curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($connection, CURLOPT_POST, 1);
			curl_setopt($connection, CURLOPT_POSTFIELDS, $xml_request);
			curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($connection);
			curl_close($connection);

			return $response;

		}



		public function headersmain($compat_level, $dev_id, $app_id, $cert_id, $call_name, $site_id){

			$headers = array 
			(
				 'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compat_level,
				 'X-EBAY-API-DEV-NAME: ' . $dev_id,
				 'X-EBAY-API-APP-NAME: ' . $app_id,
				 'X-EBAY-API-CERT-NAME: ' . $cert_id,
				 'X-EBAY-API-CALL-NAME: ' . $call_name, 
				 'X-EBAY-API-SITEID: ' . $site_id,
			);


			return $headers; 



		}

		public function parse_template($template_file, $title, $image1, $image2, $image3, $image4, $image5, $image6, $description, $sku, $shippingfee){
			
			$template_file = str_replace(MACRO_ITEM_TITLE, $title, $template_file);

			$template_file = trim($image1) != "" ? str_replace(MACRO_IMAGE_MAIN, "<img src='". $image1 ."'>", $template_file ) : str_replace(MACRO_IMAGE_MAIN, "", $template_file );

			$template_file = trim($image2) != "" ? str_replace(MACRO_IMAGE_B, "<img src='". $image2 ."'>", $template_file ) : str_replace(MACRO_IMAGE_B, "", $template_file );

			$template_file = trim($image3) != "" ? str_replace(MACRO_IMAGE_C, "<img src='". $image3 ."'>", $template_file ) : str_replace(MACRO_IMAGE_C, "", $template_file );

			$template_file = trim($image4) != "" ? str_replace(MACRO_IMAGE_D, "<img src='". $image4 ."'>", $template_file ) : str_replace(MACRO_IMAGE_D, "", $template_file );

			$template_file = trim($image5) != "" ? str_replace(MACRO_IMAGE_E, "<img src='". $image5 ."'>", $template_file ) : str_replace(MACRO_IMAGE_E, "", $template_file );

			$template_file = trim($image6) != "" ? str_replace(MACRO_IMAGE_F, "<img src='". $image6 ."'>", $template_file ) : str_replace(MACRO_IMAGE_F, "", $template_file );

			$template_file = str_replace(MACRO_ITEM_DESCRIPTION, $description, $template_file);
			$template_file = str_replace(MACRO_INVENTORY_NUMBER, $sku, $template_file );
			$template_file = str_replace(MACRO_SHIPPING_FEE, $shippingfee, $template_file);

			//encode into utf8

			$template_file = utf8_encode($template_file);

			return $template_file;
			
		}

		public function parse_b_template($template_file, $sku, $description, $top_img_type){

			$template_file = str_replace(MACRO_ITEM_DESCRIPTION, $description, $template_file);
			$template_file = str_replace(MACRO_INVENTORY_NUMBER, $sku, $template_file);

			//set top images
			$img_array = $this->set_top_images(trim($top_img_type));

			$template_file = str_replace(MACRO_TOPLINKER, $img_array['link'], $template_file);
			$template_file = str_replace(MACRO_TOPIMAGE, $img_array['img'], $template_file);
		
			$template_file = utf8_encode($template_file);

			return $template_file;
			
		}


		private function set_top_images($top_img_type){
			$top_img_array = array();
			
			//standard 
			if ($top_img_type == 0){
				$top_img_array['link'] = "http://stores.ebay.com.au/Lenycik-SoldSmart-Online-Auctions__W0QQ_sidZ64720189";
				$top_img_array['img'] = "2014_03_09_visit.jpg";

			}

			//sport
			else if($top_img_type == 1){
				$top_img_array['link'] = "http://www.kyberguard.com.au/redirect1/Redirect.asp?Id=42";
				$top_img_array['img'] = "2014_03_09_visitsport.jpg";
			}

			//tools
			else if($top_img_type == 2){
				$top_img_array['link'] = "http://www.kyberguard.com.au/redirect1/Redirect.asp?Id=38";
				$top_img_array['img'] = "2014_03_09_visittools.jpg";
			}

			//musical instruments
			else if($top_img_type == 3){
				$top_img_array['link'] = "http://www.kyberguard.com.au/redirect1/Redirect.asp?Id=46";
				$top_img_array['img'] = "2014_03_09_visitmusi.jpg";
			}
			
			//remote toys
			else if($top_img_type == 4){
				$top_img_array['link'] = "http://www.kyberguard.com.au/redirect1/Redirect.asp?Id=45";
				$top_img_array['img'] = "2014_03_09_visitrc.jpg";
			}
			//pet supplies
			else if($top_img_type == 5){
				$top_img_array['link'] = "http://www.kyberguard.com.au/redirect1/Redirect.asp?Id=41";
				$top_img_array['img'] = "2014_03_09_visitpets.jpg";
			}

			return $top_img_array;


		}

/*
define('MACRO_ITEM_TITLE', '%%ItemTitle%%');
define('MACRO_IMAGE_MAIN', '%%Image1%%');
define('MACRO_IMAGE_B', '%%Image2%%');
define('MACRO_IMAGE_C', '%%Image3%%');
define('MACRO_IMAGE_D', '%%Image4%%');
define('MACRO_IMAGE_E', '%%Image5%%');
define('MACRO_IMAGE_F', '%%Image6%%');
define('MACRO_ITEM_DESCRIPTION', '%%ItemDescription%%');
define('MACRO_INVENTORY_NUMBER', '%%InventoryNumber%%');
define('MACRO_SHIPPING_FEE', '%%ShippingFee%%');
*/


	}



?>