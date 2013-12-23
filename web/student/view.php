<?php

include('../controllers/student.controller.php');

$studentId;

if(isset($_GET['studentId'])) {
	$studentId = $_GET['studentId'];
}

$controller = new StudentController(); //instantiate a new StudentController object

include('../library/common/body-header.php'); //includes the header html markup
$controller->getStudent($studentId); //gets the html for the homepage
include('../library/common/footer.php'); //includes the footer html markup

?>