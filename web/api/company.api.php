<?php
/**
* @author Joshua Anderson
* Date: 12/17/13
* Description: This page is part of the api directory in the web app.  This specific file will handle all api requests regarding
* Internship Positions - i.e. gathering a collection and creating a html table
*
*/

include_once('../controllers/company.controller.php');

$action = '';

if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$companyController = new CompanyController();
	switch($action) {
		case "search":
			$name = $_GET['name'];
			return $companyController->searchCompanies($name);
			break;
		case "edit":
			return $companyController->editCompany($_GET);
			break;
		case "create":
			return $companyController->addCompany($_GET);
			break;
	}
}

?>
