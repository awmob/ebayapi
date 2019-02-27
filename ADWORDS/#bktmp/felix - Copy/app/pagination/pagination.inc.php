<?php


	Class pagination{

		private $pages_array = array();
		private $current_page;
		private $total_pages;
		private $pages_show_array = array();
		private $pages_to_show;

		/*
			$count_of_entries = number of returned values from dbase
			$items_per_page = number of desired items to appear on each page
			$current_page = number of current page
			$pages_to_show = number of pages to show in results

		*/
		
		//returns array of page numbers for links
		public function paginate_numbers($count_of_entries, $items_per_page, $current_page, $pages_to_show){
			$this->pages_array = array();
			
			$this->pages_to_show = $pages_to_show;
			$this->current_page = $current_page;
			
			//ceiling to round fraction up to nearest whole number - total number of pages also = last page number
			$this->total_pages = ceil($count_of_entries / $items_per_page);
			
			//if the total number of pages is fewer than the limit, return only those pages
			if ($this->total_pages < $pages_to_show){
				for ($i=0; $i < $this->total_pages;$i++){
					array_push($this->pages_array, ($i + 1));
				}
			}
			
			else{
				//if the current page is less than the number of pages to show, then only show the first amount of pages to show
				if ($this->current_page < $pages_to_show){
					for ($i=0; $i < $pages_to_show;$i++){
						array_push($this->pages_array, ($i + 1));
					}			
				}

				//if the current page is not in the first batch of pages:
				else {

					if ($this->total_pages - $this->current_page < $pages_to_show){

						//with x pages of the last page
						$setpage = $this->total_pages - $pages_to_show+1;
						$counter = $pages_to_show;

						for ($i=0; $i < $counter; $i++){
							array_push($this->pages_array, $setpage);
							$setpage++;
						}
					}

					//nowhere near the last page
					
					else{
						
						$setpage = $this->current_page - ($pages_to_show / 2);
						for ($i=0; $i <  $pages_to_show;$i++){
							
							array_push($this->pages_array, $setpage);
							$setpage++;

						}
					}
				}
				
			}

			
			

		}

		/*
			$prev_next = multi array containing text for next and prev -> $prev_next['prev'] = prev  $prev_next['next'] = next 

			returns array with:
			$this->pages_show_array['middle'] = array();
			$this->pages_show_array['prev']  = null;
			$this->pages_show_array['next']  = null;
			$this->pages_show_array['first']  = null;
			$this->pages_show_array['last']  = null;

			if null result, then do not display

		*/

		public function pagination_numbers_set(){
			$this->pages_show_array = array();
			$this->pages_show_array['middle'] = array();
			$this->pages_show_array['prev']  = null;
			$this->pages_show_array['next']  = null;
			$this->pages_show_array['first']  = null;
			$this->pages_show_array['last']  = null;

			
			for ($i=0; $i < sizeof($this->pages_array) ;$i++){

				//first iteration
				if ($i == 0){
					//prev
					if ($this->current_page <= 1){
						$this->pages_show_array['prev'] = null;
					}
					else if ($this->current_page >= $this->total_pages){
						$this->pages_show_array['prev'] = $this->total_pages - 1;
						
					}
					else {
						$this->pages_show_array['prev'] = $this->current_page - 1;
						
					}

					if ($this->current_page > $this->pages_to_show){
						$this->pages_show_array['first'] = "1 ...";
					}


					array_push($this->pages_show_array['middle'], $this->pages_array[$i]);


				}

				//last iteration
				else if ($i == sizeof($this->pages_array)-1){

					if ($this->current_page < $this->total_pages - $this->pages_to_show){
						$this->pages_show_array['last'] = "..." . $this->total_pages;
					}


					//next
					if ($this->current_page >= $this->total_pages){
						$this->pages_show_array['next'] = null;
					}
					else {
						$this->pages_show_array['next'] = $this->current_page + 1;			
					}

				}

				//middle iterations
				else {
					array_push($this->pages_show_array['middle'], $this->pages_array[$i]);


				}

			}
				

				if (empty($this->pages_show_array['next'])){
					$this->pages_show_array['next'] = null;
				}
			

		}

		
		//prefix and suffx for seo links
		public function set_pagination_html($prefix, $suffix){

			$send_array = array();
			$send_array['middle'] = array();
			$send_array['first']  = array();
			$send_array['last'] = array();
			$send_array['next']  = array();
			$send_array['prev'] = array();

			for ($i=0; $i <  sizeof($this->pages_show_array['middle']) ;$i++){
				if (!empty($this->pages_show_array['middle'])){
					$send_array['middle'][$i][0] = $this->pages_show_array['middle'][$i];
					$send_array['middle'][$i][1] = $prefix . $this->pages_show_array['middle'][$i] . $suffix;
				}

			}

			if (!empty($this->pages_show_array['prev'])){
				$send_array['prev'][0] = $this->pages_show_array['prev'];	
				$send_array['prev'][1] = $prefix . $this->pages_show_array['prev'] . $suffix;				
			}
			else {
				$send_array['prev'] = null;
			}

			if (!empty($this->pages_show_array['next'])){
				$send_array['next'][0] = $this->pages_show_array['next'];	
				$send_array['next'][1] = $prefix . $this->pages_show_array['next'] . $suffix;	
			}
			else {
				$send_array['next'] = null;
			}

			if (!empty($this->pages_show_array['first'])){
				$send_array['first'][0] = $this->pages_show_array['first'];	
				$send_array['first'][1] = $prefix . $this->pages_show_array['first'] . $suffix;	
			}
			else {
				$send_array['first'] = null;
			}

			if (!empty($this->pages_show_array['last'])){
				$send_array['last'][0] = $this->pages_show_array['last'];
				$send_array['last'][1] = $prefix . $this->pages_show_array['last'] . $suffix;	
			}
			else {
				$send_array['last'] = null;
			}

			return $send_array;

		}







	}



?>