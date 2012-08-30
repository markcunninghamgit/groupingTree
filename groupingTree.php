#!/usr/bin/php
<?php
//Requires php version 5.4 to do function()['someindex']
Class GroupingTree
{

	private $db = array('count' => 0);
	private $searchQueue = array();

	public function store_in_tree($inputString)
	{
		$strArray = str_split($inputString);
		$pointer = &$this->db;

		foreach ($strArray as $key => $char)
		{
			if (!isset($pointer[$char]))
			{
				$pointer[$char] = array('count' => 0);
			}

			$pointer['count'] ++;
			$pointer = &$pointer[$char];
		}
	}


	public function printr()
	{
		print_r($this->db);
	}

	private function pathpointer($path)
	{
		$pointer = $this->db;

		foreach ($path as $char)
		{
			$pointer = &$pointer[$char];
		}

		return $pointer;
	}

	private function print_path($path)
	{
		$output = '$db';
		foreach ($path as $index)
		{
			$output .= '[' . $index . ']';
		}
		return $output;
	}

	/*
		Adds a all children of a path to searchQueue
	*/
	private function add_children_to_searchQueue($parentPath)
	{
		foreach ($this->pathpointer($parentPath) as $childKey => $child)
		{
			if ($childKey == "count")
			{
				continue;
			}
			
			$childPath = $parentPath;
			$childPath[] = $childKey;
			$this->searchQueue[] = $childPath;
		}
	}


	function get_highest_count($maxCount)
	{
		//reset searchQueue
		$this->searchQueue = array();
		//By adding a blank array, we add a blank top, ie the root of the tree to start from
		$this->searchQueue[] = array();

		//Location of that count
		$highestNode = array();
		$highestCount = 0;

		// Search each node that's in the list. 
		//	If count exceeds max, add all children to searchQueue
		//	if not, compare to highestCount and add if exceeds highest count.
		while(count($this->searchQueue) > 0)
		{
			$nextNode = array_pop($this->searchQueue);
			echo "Next node " . $this->print_path($nextNode). ", count: " . $this->pathpointer($nextNode)['count'] . "\n";

			//If over max, add children and move on
			if ($this->pathpointer($nextNode)['count'] >= $maxCount)
			{
				echo "Count too big, adding children\n";
				//Add children to searchQueue
				$this->add_children_to_searchQueue($nextNode);
			}
			elseif ($this->pathpointer($nextNode)['count'] > $highestCount)
			{
			//Find highest count
				$highestCount = $this->pathpointer($nextNode)['count'];
				$highestNode = $nextNode;
				echo "highest count now $highestCount with node " .$this->print_path($highestNode) . "\n";
			}
			
			echo "Finished examing node, count of searchQueue: " . count($this->searchQueue) . "\n\n";
			
		}

		echo "And the winner is : " .$this->print_path($highestNode). " with count of $highestCount with the limit count being $maxCount\n";

	}

}




