<?php


	/* Generate queries for entry into database */

	Class dbase_setters{
		private $connection;

		
		function __construct($connector){

			$this->connection = $connector;
			
			
		}


		public function clear_table($tablename){
			$query = "DELETE FROM " . $tablename;
			$this->connection->connectnoreturn($query);
		}


		/*
linker
			Inserts data into the database 
			$table = table name
			$cols = multidimensional array of column names then entries [0] = col name [1] = entry

		*/
		public function insert_query($table, array $cols){
			

			foreach ($cols as &$value) {
				//$value[1] = addslashes($value[1]);
				$value[1] = $this->connection->linker->real_escape_string($value[1]);
			}

			$query = "INSERT INTO " . $table . " ";



			for ($i=0; $i < sizeof($cols) ;$i++){
				//first
				if ($i == 0 && sizeof($cols) > 1){
					$cols_show = "(" . $cols[$i][0] . ", ";
					$entry_show = " VALUES ('" . $cols[$i][1] ."', ";
				}

				else if ($i == 0 && sizeof($cols) == 1){
					$cols_show = "(" . $cols[$i][0] . ") ";
					$entry_show = " VALUES ('" . $cols[$i][1] ."') ";
				}

				//last
				else if ($i== sizeof($cols)-1){
	
					$cols_show .= $cols[$i][0] . ") ";
					$entry_show .= "'" . $cols[$i][1] ."');";				
				}
				//middle
				else{
					$cols_show .= $cols[$i][0] . ", ";
					$entry_show .= "'" . $cols[$i][1] ."', ";
					
				}
			}

			$query .= $cols_show;
			$query .= $entry_show;


			$this->connection->connectnoreturn($query);
			
		}




		/*

			Update data into the database 
			$table = table name
			$cols = multidimensional array of column names then entries [0] = col name [1] = entry
			$where = multidimensional array of column names then entries [0] = col name [1] = entry

		*/

		public function update_query($table, array $cols, array $where = null){
			foreach ($cols as &$value) {
				//$value[1] = addslashes($value[1]);
				$value[1] = $this->connection->linker->real_escape_string($value[1]);
			}

			$query = "UPDATE " . $table . " SET ";

			//set update entries
			for ($i=0; $i < sizeof($cols) ;$i++){
				//first
				if ($i == 0 && sizeof($cols) > 1){
					$cols_show = $cols[$i][0] . " = '" . $cols[$i][1] . "', ";
				}

				else if ($i == 0 && sizeof($cols) == 1){
					$cols_show = $cols[$i][0] . " = '" . $cols[$i][1] . "' ";
				}

				//last
				else if ($i== sizeof($cols)-1){
					$cols_show .= $cols[$i][0] . " = '" . $cols[$i][1] . "' ";		
				}
				//middle
				else{
					$cols_show .= $cols[$i][0] . " = '" . $cols[$i][1] . "', ";
					
				}

			}

			$query .= $cols_show;

			$where_show = "";
			if (isset($where)){
				//set where clauses
				for ($i=0; $i < sizeof($where) ;$i++){
					//first
					if ($i == 0 && sizeof($where) > 1){
						$where_show = " WHERE " . $where[$i][0] . " = '" . $where[$i][1] . "' AND ";
					}

					else if ($i == 0 && sizeof($where) == 1){
						$where_show = " WHERE " . $where[$i][0] . " = '" . $where[$i][1] . "' ";
					}

					//last
					else if ($i == sizeof($where)-1){
						$where_show .= $where[$i][0] . " = '" . $where[$i][1] . "' ";		
					}
					//middle
					else{
						$where_show .= $where[$i][0] . " = '" . $where[$i][1] . "' AND ";
						
					}

				}		
				
			}

			$query .= $where_show;

			$this->connection->connectnoreturn($query);

		}

	
	}



?>