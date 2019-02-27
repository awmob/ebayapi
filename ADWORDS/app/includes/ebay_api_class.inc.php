<?php


	Class ebay_api_class{

		private $dbase_getters;
		private $dbase_setters;
		private $curler;


		function __construct($dbase_getters, $dbase_setters, $curler){
			//set the array with the config settings
			$this->dbase_getters = $dbase_getters;
			$this->dbase_setters = $dbase_setters;
			$this->curler = $curler;
		}
		
		public function functionname(){
			

		}



	}



?>