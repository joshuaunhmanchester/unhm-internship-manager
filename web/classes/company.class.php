<?php
/**
* @author Joshua Anderson
* Date: 12/17/13
* Description: Class for a Company entity.
* This class contains all the logic associated with a Company object - inserting, editing, deleting, and any other helper 
* methods regarding ONLY a Company.
*
*/

if(!function_exists('connect')) {
	require_once('../library/common/config.php');	
}

require_once('bindparam.class.php');

class Company {
	public $companyId;
	public $name;
	public $website;
	public $city;
	public $state;

	function __construct() {
    }
	/**
	* 
	*/
	public function getCompaniesFromSearch($name) {
		$companyArray = array();
		$dbContext = connect();
		
		if(is_null($name)) {
			echo "Please make sure you supply a Company Name to search";
			return false;
		}

		$name = '%'.strtolower($name).'%'; //wildcard search

		$query = "SELECT companyId, name, website, city, state 
				  FROM company 
				  WHERE LOWER(name) LIKE ?";

		$statement = $dbContext->prepare($query);
		if($statement === false) {
			echo "Failed to prepare the SQL statement: " . htmlspecialchars($dbContenxt->error);
			return false;
		}

		$result = $statement->bind_param('s', $name);
		if($result === false) {
			echo "Failed to bind params: " . htmlspecialchars($statement->error);
            return false;
		}

		$results = $statement->execute();
		if($results == false) {
            echo "Failed to execute: " . htmlspecialchars($statement->error);
            return false;
        }

		$statement->bind_result($companyId, $name, $website, $city, $state);
		while($statement->fetch()) {
			if($companyId != null) {
				$company = new Company();
				$company->companyId = $companyId;
				$company->name = $name;
				$company->website = $website;
				$company->city = $city;
				$company->state = $state;

				//add company object in current iteration to $companyArray
				$companyArray[] = $company;
			}
		}

		return $companyArray;
	}

	public function createCompany($company) {
		$dbContext = connect();
		if($company != null) {
			$query = "INSERT INTO company 
					  (name, website, city, state) 
                      VALUES(?, ?, ?, ?)";
            $statement = $dbContext->prepare($query);

            if($statement === false) {
				$error = "Error: Failed to prepare the SQL statement - " . htmlspecialchars($dbContext->error);
				return $error;
			}

			$result = $statement->bind_param('ssss', $company->name, $company->website,
													  $company->city, $company->state);
			if($result === false) {
				$error = "Error: Failed to bind params - " . htmlspecialchars($statement->error);
            	return $error;
			}

			$result = $statement->execute();

	        if($result == false) {
	            $error = "Error: Failed to execute - " . htmlspecialchars($statement->error);
	            return $error;
	        }

	        $newCompanyId =  $dbContext->insert_id;

	        return $newCompanyId;
		} else {
			return false;
		}
	}

	public static function getAllCompanies() {
		$dbContext = connect();
		$companiesArray = array();

		$query = "SELECT companyId, name, website, city, state
				  FROM company
				  ORDER BY name";
		$statement = $dbContext->prepare($query);
		if($statement === false) {
			echo "Failed to prepare the SQL statement: " . htmlspecialchars($dbContext->error);
			return false;
		}

		$result = $statement->execute();
		if($result === false) {
			echo "Failed to execute: " . htmlspecialchars($statement->error);
            return false;
		}		

		$statement->bind_result($companyId, $name, $website, $city, $state);
		while($statement->fetch()) {
			$company = new Company();
			$company->companyId = $companyId;
			$company->name = $name;
			$company->website = $website;
			$company->city = $city;
			$company->state = $state;

			$companiesArray[] = $company;
		}

		return $companiesArray;
	}

	/**
	* 
	*/
	public static function getCompany($companyId) {
		//this is static so Supervisor class can call this to set the 
		//fk object
		$dbContext = connect();
		$company = new Company();
		$company->companyId = $companyId;

		$query = "SELECT name, website, city, state 
				  FROM company 
				  WHERE companyId = ? LIMIT 1";
				  
		$statement = $dbContext->prepare($query);
		if($statement === false) {
			echo "Failed to prepare the SQL statement: " . htmlspecialchars($dbContext->error);
			return false;
		}

		$result = $statement->bind_param('i', $companyId);
		if($result === false) {
			echo "Failed to bind params: " . htmlspecialchars($statement->error);
            return false;
		}

		$result = $statement->execute();
		if($result === false) {
			echo "Failed to execute: " . htmlspecialchars($statement->error);
            return false;
		}		

		$statement->bind_result($name, $website, $city, $state);
		while($statement->fetch()) {
			$company->name = $name;
			$company->website = $website;
			$company->city = $city;
			$company->state = $state;
		}

		return $company;
	}

	/**
	* 
	*/
	public function editCompany($company) {
		$dbContext = connect();
		$companyId = $company->companyId;
		$query = "UPDATE company 
				  SET name = ?, website = ?, city = ?, state = ?
				  WHERE companyId = ?";
		$statement = $dbContext->prepare($query);
		if($statement === false) {
			$error = "Error: Failed to prepare the SQL statement: " . htmlspecialchars($dbContext->error);
			return $error;
		}

		$result = $statement->bind_param('ssssi', $company->name, $company->website,
												  $company->city, $company->state,
												  $companyId);
		if($result === false) {
			$error = "Error: Failed to bind params: " . htmlspecialchars($statement->error);
            return $error;
		}

		$result = $statement->execute();
		if($result === false) {
			$error = "Error: Failed to execute: " . htmlspecialchars($statement->error);
            return $error;
		}	

		return true;
	}

	/**
	* 
	*/
	public function buildCompanyObject($data) {
		$company = new Company();
		//TODO: add any error checking I might need
		$company->companyId = $data['companyId'];
		$company->name = $data['txtCompanyName'];
		$company->website = $data['txtCompanyWebsite'];
		$company->city = $data['txtCompanyCity'];
		$company->state = $data['txtCompanyState'];

		return $company;
	}
}

?>