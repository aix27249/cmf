<?php

function preventCaching() {
	header("Expires: Mon, 09 Jun 2012 01:00:00 GMT"); // Datum aus Vergangenheit
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header("Cache-Control: no-store, no-cache, must-revalidate"); 
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
}
