<?php

include('../controllers/company.controller.php');

$companyId;

if(isset($_GET['companyId'])) {
	$companyId = $_GET['companyId'];
}

$controller = new CompanyController(); //instantiate a new CompanyController object

include('../library/common/body-header.php'); //includes the header html markup
$controller->getCompany($companyId); //gets the html for the homepage
include('../library/common/footer.php'); //includes the footer html markup

?>