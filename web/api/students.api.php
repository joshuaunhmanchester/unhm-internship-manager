<?php
/**
* @author Joshua Anderson
* Date: 12/17/13
* Description: This page is part of the api directory in the web app.  This specific file will handle all api requests regarding
* Internship Positions - i.e. gathering a collection and creating a html table
*
*/

include_once('../controllers/student.controller.php');

$action = '';

if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$studentController = new StudentController();
	switch($action) {
		case "search":
			return $studentController->searchStudents($_GET);
			break;
		case "edit":
			return $studentController->editStudent($_GET);
			break;
	}
}

?>
