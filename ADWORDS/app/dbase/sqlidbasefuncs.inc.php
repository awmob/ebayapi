<?php
	
	//class connects to the database


	Class dbaseconnect{		
		private $host;
		private $username;
		private $password;
		private $dbase;
		



		//the database connection variable. use to close the database
		public $linker;
		
				
		//connect to the database
		function __construct($host, $usernames, $passs, $dbases){

			$this->host = $host;
			$this->username = $usernames;
			$this->password = $passs;
			$this->dbase = $dbases;
			
			$this->linker = mysqli_connect($this->host, $this->username, $this->password, $this->dbase);
			/* check connection */
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
		
			//echo $this->dbase;
			
		}
		
		
		//query the database - use when no return required
		function connectnoreturn($query){
			
			mysqli_query($this->linker, $query) or die(mysqli_error());
		}
		
		//query the database - use when return variable/s required
		function connectreturn($queryreturn){
			
			$result = mysqli_query($this->linker, $queryreturn) or die(mysqli_error());
			return $result;
		}
		
		//closes the connection
		function closeconnection(){
			mysqli_close($this->linker);

			
		}



		//processes query returns
		//pass array in format:
		//$namesarray[0] = "name1";
		//$namesarray[1] = "name2";
		function dbaseloopback($result, $namesarray){
			//the length of the $result array names
			$namelength = sizeof($namesarray);
			
			//counter for the while loop
			$counter = 0;
			while($row = mysqli_fetch_array( $result )){
				
				//loop through the names and assign values from row to the corresponding name in send
				for ($i=0;$i<$namelength;$i++){
					
					$send[$namesarray[$i]][$counter] = $row[$namesarray[$i]];
					$send[$namesarray[$i]][$counter] = stripslashes($send[$namesarray[$i]][$counter]);
				}//end for
				
				$counter++;

			}//end while

			if (isset($send)){
				return $send;
			}

		}//end dbaseloopback

		
	}
	
	
	
	

?>