<?php
ob_start(); 
//Turn on output buffering.  While output buffering is active no output is sent 
//from the script (other than headers), instead the output is stored in an internal buffer.

include_once('../classes/company.class.php');


class CompanyController {
	
	/**
	* Summary: This will create a new Student object and call a method to search the student table
	* @param: $filters = the $_POST array from the homepage student search form
	* @return: This will return a view from the StudentView class which will produce a HTML table with the results when we pass it 
	* an array of Student objects
	*/
	public function searchCompanies($name) {
		include_once('../views/company.view.php');
		$company = new Company();
		$companyArray = array();

		$companyArray = $company->getCompaniesFromSearch($name);

		CompanyView::buildCompanySearchResults($companyArray);
	}

	public function getCompany($companyId) {
		include_once('../views/company.view.php');

		if(isset($companyId)) {
			$company = new Company();
			$company = $company->getCompany($companyId);
			CompanyView::buildCompanyDetail($company);
		} else {
			return false;
		}
	}

	public function addCompany($data) {
		$company = new Company();
		$company = $company->buildCompanyObject($data);
		$newCompanyId = $company->createCompany($company);

		echo $newCompanyId;
	}

	public function editCompany($data) {
		$company = new Company();
		$company = $company->buildCompanyObject($data);
		$results = $company->editCompany($company);
		
		//$results will contain 1 if no errors - checking the value of results on the ajax 
		//done function and will report the errors on the page, and not redirect.
		echo $results;
	}
	
}	
	
?>

