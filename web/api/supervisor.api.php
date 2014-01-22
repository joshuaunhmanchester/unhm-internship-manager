<?php
/**
* @author Joshua Anderson
* Date: 12/17/13
* Description: This page is part of the api directory in the web app.  This specific file will handle all api requests regarding
* Internship Positions - i.e. gathering a collection and creating a html table
*
*/

include_once('../controllers/supervisor.controller.php');

$action = '';

if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$supervisorController = new SupervisorController();
	switch($action) {
		case "search":
			return $supervisorController->searchSupervisors($_GET);
			break;
		case "edit":
			return $supervisorController->editSupervisor($_GET);
			break;
		case "create":
			return $supervisorController->addSupervisor($_GET);
			break;
	}
}

?>
