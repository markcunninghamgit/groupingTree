#!/usr/bin/php
<?php

$examples = array();
$examples [] = "john";
$examples [] = "job";
$examples [] = "joe";
$examples [] = "andrew";
$examples [] = "andy";
$examples [] = "timmy";
$examples [] = "jack";
$examples [] = "joan";
$examples [] = "table";
$examples [] = "chair";
$examples [] = "light";

$input = file_get_contents("wordlist");
$input = trim($input);
$dataA = explode("\n", $input);
foreach ($dataA as $data)
{
	$examples[] = $data;
}

$tree = array('count' => 0);


foreach ($examples as $example)
{
	store_in_tree($tree, $example);	
}

//print_r($tree);
//die();
//assume tree count has more than max


	$searchTree = array();
	$searchTree[] = array();
	$highestCount = 0;
	$maxCount = 150;
	$highestNode = array();

	//Keep searching search queue
	while(count($searchTree) > 0)
	{
		$nextNode = array_pop($searchTree);
		echo "\n\n\nNext node " . print_loc($nextNode). "\n";
		//If over max, add children and move on
		if (locpointer($nextNode)['count'] >= $maxCount)
		{
			echo "Count too big, adding children\n";
			//Add children to searchtree
			foreach (locpointer($nextNode) as $childKey => $nodeChild)
			{
				if ($childKey == "count")
				{
					continue;
				}

				$currentLoc = $nextNode;
				$currentLoc[] = $childKey;
				$searchTree[] = $currentLoc; 
			}
			continue;
		}

		//Find highest count
		echo "Node count: " . locpointer($nextNode)['count'] . "\n";

		if (locpointer($nextNode)['count'] > $highestCount)
		{
			$highestCount = locpointer($nextNode)['count'];
			$highestNode = $nextNode;
			echo "highest count now $highestCount with node " . print_loc($highestNode) . "\n";
		}
		
		echo "end of loop, count of searchTree: " . count($searchTree) . "\n";
		
	}


	echo "And the winner is : " . print_loc($highestNode). " with count of $highestCount with the limit count being $maxCount\n";

function locpointer($loc)
{
	global $tree;
	$pointer = &$tree;
	foreach ($loc as $char)
	{
		$pointer = &$pointer[$char];
	}

	return $pointer;
}

function print_loc($loc)
{
	$output = '$tree';
	foreach ($loc as $index)
	{
		$output .= '[' . $index . ']';
	}
	return $output;
}



function store_in_tree(&$tree, $inputString)
{
	$strArray = str_split($inputString);
	$pointer = &$tree;

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


