#!/usr/bin/php
<?php
include "groupingTree.php";

$gtree = new GroupingTree();


$input = file_get_contents("wordlist");
$input = trim($input);
$dataA = explode("\n", $input);
foreach ($dataA as $data)
{
	$gtree->store_in_tree($data);
}

echo $gtree->get_highest_count(100);




