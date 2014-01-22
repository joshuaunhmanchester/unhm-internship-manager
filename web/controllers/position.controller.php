<?php
ob_start(); 
//Turn on output buffering.  While output buffering is active no output is sent 
//from the script (other than headers), instead the output is stored in an internal buffer.

include_once('../classes/position.class.php');
include_once('../views/position.view.php');

class PositionController {
	
	public function getCreatePosition() {
		return PositionView::getCreatePositionHtml();
	}
	
}	
	
?>

