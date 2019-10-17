<?php

// Initialize site configuration
require_once('includes/config.inc.php');

$id = (isset($_GET['id'])) ? intval($_GET['id']) : -1;
$index = (isset($_GET['index'])) ? intval($_GET['index']) : -1;

if ($id > 0 && ($index > 0 && $index < 2)) 
{	
	if($_SERVER['REQUEST_METHOD'] == 'GET') 
	{
		if($index == 1) 
		{
			$object = Personas::getById($id);
		}
		echo json_encode($object);
	} 
	else if($_SERVER['REQUEST_METHOD'] == 'PUT') 
	{
		try {
			if($index == 1) 
			{
				$object = Personas::getInstance(json_decode(file_get_contents("php://input")));
			}
			
			$object->setId($id);
			$result = $object->save();

			if($result  === false || $result == "-1") {
				throw new Exception('');
			} else {
				echo '{"res":"true","action":"update"}';
			}
		} catch(Exception $ex) {
			echo '{"res":"false","action":"update"}';
		}
	} 
}