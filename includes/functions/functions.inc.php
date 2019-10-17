<?php


function redirect_to($url) {
	if (isset($url)) {
		header("Location: " . $url);
	}
}

function sanitize_output($string) {
	return htmlspecialchars($string);
}