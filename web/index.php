<?php
include_once('library/common/config.php');
include_once('controllers/homepage.controller.php');

$controller = new HomepageController(); //instantiate a new HomepageController object

include_once('library/common/body-header.php'); //includes the header html markup
$controller->getHomepage(); //gets the html for the homepage
include_once('library/common/footer.php'); //includes the footer html markup

?>
