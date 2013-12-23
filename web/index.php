<?php
include('controllers/homepage.controller.php');

$controller = new HomepageController(); //instantiate a new HomepageController object

include('library/common/body-header.php'); //includes the header html markup
$controller->getHomepage(); //gets the html for the homepage
include('library/common/footer.php'); //includes the footer html markup

?>
