<?php
require_once('includes/config.inc.php');

$id = (isset($_GET['id'])) ? intval($_GET['id']) : null;
$index = (isset($_GET['index'])) ? intval($_GET['index']) : null;

if ($index > 0 && $index < 2) 
{
	if ($id == null) 
	{
		if($_SERVER['REQUEST_METHOD'] == 'GET') 
		{
			if($index == 1) 
			{
				$object = Personas::getAll();
			}
			echo json_encode($object);
		}
	} 
	else if($id > 0) 
	{
		if($_SERVER['REQUEST_METHOD'] == 'GET') 
		{
			if($index == 1) 
			{
				$object = Personas::getInfoUpdate($id);
			}
			
			echo json_encode($object);
		}
	}
} 

?>