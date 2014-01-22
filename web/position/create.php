<?php
include_once('../controllers/position.controller.php');
include_once('../classes/student.class.php');
include_once('../classes/company.class.php');
include_once('../classes/supervisor.class.php');

$controller = new PositionController(); //instantiate a new PositionController object

include_once('../library/common/body-header.php'); //includes the header html markup
$controller->getCreatePosition(); //gets the html for the Create page
include_once('../library/common/footer.php'); //includes the footer html markup

?>