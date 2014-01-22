<?php

include('../controllers/supervisor.controller.php');

$supervisorId;

if(isset($_GET['supervisorId'])) {
	$supervisorId = $_GET['supervisorId'];
}

$controller = new SupervisorController(); //instantiate a new SupervisorController object

include('../library/common/body-header.php'); //includes the header html markup
$controller->getSupervisor($supervisorId); //gets the html for the homepage
include('../library/common/footer.php'); //includes the footer html markup

?>