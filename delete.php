<?php

// Initialize site configuration
require_once('includes/config.inc.php');

// Check the querystring for a numeric id
if (isset($_GET['id']) && intval($_GET['id']) > 0) {
	
	// Get id from querystring
	$id = $_GET['id'];
	
	// Execute database query
	$persona = new Personas();
	$persona->id = $id;
	$persona->delete();	
}

// Redirect to site root
redirect_to('.');