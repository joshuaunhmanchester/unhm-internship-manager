<?php
/**
* @author Joshua Anderson
* Date: 12/17/13
* Description: Class for a Company
*
*/

require('../library/common/config.php');
require('bindparam.class.php');

class Company {
	public $companyId;
	public $name;
	public $website;
	public $city;
	public $state;

	/**
	* Summary: This method will query the student database table to collect records of students
	* and create a Student Object array to pass back to the controller
	* @param: $filters = the $_POST array from the homepage student search form contains three $_POST values for the first and last name, and email
	* @return: This will return a view from the StudentView class which will produce a HTML table with the results when we pass it 
	* an array of Student objects
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

	public function getStudent($studentId) {
		$dbContext = connect();
		$student = new Student();
		$student->studentId = $studentId;

		$query = "SELECT first_name, last_name, email, grad_year, advisor, notes FROM student
				  WHERE studentId = ? LIMIT 1";
		$statement = $dbContext->prepare($query);
		if($statement === false) {
			echo "Failed to prepare the SQL statement: " . htmlspecialchars($dbContext->error);
			return false;
		}

		$result = $statement->bind_param('i', $studentId);
		if($result === false) {
			echo "Failed to bind params: " . htmlspecialchars($statement->error);
            return false;
		}

		$result = $statement->execute();
		if($result === false) {
			echo "Failed to execute: " . htmlspecialchars($statement->error);
            return false;
		}		

		$statement->bind_result($fname, $lname, $email, $gradYear, $advisor, $notes);
		while($statement->fetch()) {
			$student->firstName = $fname;
			$student->lastName = $lname;
			$student->email = $email;
			$student->gradYear = $gradYear;
			$student->advisor = $advisor;
			$student->notes = $notes;
		}

		return $student;
	}

	public function editStudent($student) {
		$dbContext = connect();
		$studentId = $student->studentId;
		$query = "UPDATE student SET first_name = ?, last_name = ?, email = ?, grad_year = ?, advisor = ?, notes = ?
				  WHERE studentId = ?";
		$statement = $dbContext->prepare($query);
		if($statement === false) {
			$error = "Error: Failed to prepare the SQL statement: " . htmlspecialchars($dbContext->error);
			return $error;
		}

		$result = $statement->bind_param('sssissi', $student->firstName, $student->lastName,
													$student->email, $student->gradYear,
													$student->advisor, $student->notes,
													$studentId);
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

	public function buildStudentObject($data) {
		$student = new Student();
		//TODO: add any error checking I might need
		$student->studentId = $data['studentId'];
		$student->firstName = $data['txtStudentFName'];
		$student->lastName = $data['txtStudentLName'];
		$student->email = $data['txtStudentEmail'];
		$student->gradYear = $data['txtStudentGradYear'];
		$student->advisor = $data['txtStudentAdvisor'];
		$student->notes = $data['txtStudentNotes'];

		return $student;
	}
}

?>