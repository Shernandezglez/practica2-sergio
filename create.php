<?php

// Initialize site configuration
require_once('includes/config.inc.php');

$index = (isset($_GET['index'])) ? intval($_GET['index']) : null;

if($_SERVER['REQUEST_METHOD'] == 'POST' && ($index > 0 && $index < 8)) 
{
	try 
	{
		if($index == 1) 
		{
			$object = Personas::getInstance(json_decode(file_get_contents("php://input")));
		}
		$result = $object->save();

		if($result  === false || $result == "-1") {
			throw new Exception('{"res":"false","action":"create"}');
		} else {
			echo '{"res":"true","action":"create"}';
		}
	} catch(Exception $ex) {
		echo '{"res":"false","action":"create"}';
	}	
}
else {
	echo '{"res":"false","action","create","message":"Are you lost?' . $id .'-' . $index. '"}';
}