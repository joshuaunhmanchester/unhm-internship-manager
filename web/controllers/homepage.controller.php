<?php
ob_start(); //Turn on output buffering.  While output buffering is active no output is sent from the script (other than headers), instead the output is stored in an internal buffer.
include('./views/homepage.view.php');

class HomepageController {
	
	public function getHomepage() {
		$html = HomepageView::getHomepageHtml();
		echo $html;
	}
	
}	
	
?>

