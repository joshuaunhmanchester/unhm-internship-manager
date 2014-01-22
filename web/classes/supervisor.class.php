<?php
/**
* @author Joshua Anderson
* Date: 12/17/13
* Description: Class for a Supervisor
* This class contains all the logic associated with a Supervisor object - inserting, editing, deleting, and any other helper 
* methods regarding ONLY a Supervisor.
*
*/

//require('../library/common/config.php');
//require('bindparam.class.php');
include_once('company.class.php');

class Supervisor {
	public $supervisorId;
	public $firstName;
	public $lastName;
	public $email;
	public $phone;
	public $companyId;

	public $Company; //fk object to Company

	function __construct() {
		//upon initialize, also instaintiate new Company object
    	$this->Company = new Company();
    }

    public function DisplayName() {
    	return ($this->firstName . ' ' . $this->lastName);
    }

	/**
	* @summary: This method will query the student database table to collect records of students
	* and create a Student Object array to pass back to the controller
	* @param: $filters = the $_POST array from the homepage student search form contains three $_POST values for the first and last name, and email
	* @return: This will return a view from the StudentView class which will produce a HTML table with the results when we pass it 
	* an array of Student objects
	* TODO: Re-factor this function to use the vw_getsupervisors view so we don't have to call the Company class
	*/
	public function getSupervisorsFromSearch($filters) {
		$supervisorsArray = array();
		$whereClause = array();
		$bindParam = new BindParam();
		$dbContext = connect();
		$fname;
		$lname;
		$email;

		if(isset($filters['txtSupervisorFName'])) {
			$fname = strtolower($filters['txtSupervisorFName']);
			if($fname) { 
				$whereClause[] = "LOWER(first_name) LIKE ? "; 
				$bindParam->add('s', '%'.$fname.'%');
			}
		}
		if(isset($filters['txtSupervisorLName'])) {
			$lname = strtolower($filters['txtSupervisorLName']);
			if($lname) { 
				$whereClause[] = "LOWER(last_name) LIKE ? "; 
				$bindParam->add('s', '%'.$lname.'%');
			}
		}
		if(isset($filters['txtSupervisorEmail'])) {
			$email = strtolower($filters['txtSupervisorEmail']);
			if($email) { 
				$whereClause[] = "LOWER(email) LIKE ? "; 
				$bindParam->add('s', '%'.$email.'%');
			}
		}

		if(is_null($fname) && is_null($lname) && is_null($email)) {
			echo "Please make sure you supply either a First Name, Last Name or Email to search";
			return false;
		}

		$query = "SELECT supervisorId, first_name, last_name, email, phone, companyId
				  FROM supervisor ";
		if(count($whereClause)) {
			$query .= "WHERE " . implode('OR ', $whereClause);
		}

		$statement = $dbContext->prepare($query);
		if($statement === false) {
			echo "Failed to prepare the SQL statement: " . htmlspecialchars($dbContenxt->error);
			return false;
		}

		call_user_func_array(array($statement, 'bind_param'), BindParam::refValues($bindParam->get()));

		$results = $statement->execute();
		if($results == false) {
            echo "Failed to execute: " . htmlspecialchars($statement->error);
            return false;
        }

		$statement->bind_result($supervisorId, $first_name, $last_name, $email, $phone, $companyId);
		while($statement->fetch()) {
			if($supervisorId != null) {
				$supervisor = new Supervisor();
				$supervisor->supervisorId = $supervisorId;
				$supervisor->firstName = $first_name;
				$supervisor->lastName = $last_name;
				$supervisor->email = $email;
				$supervisor->phone = $phone;
				$supervisor->companyId = $companyId;
				$supervisor->Company = Company::getCompany($companyId);

				//add supervisor object in iteration to $supervisors array
				$supervisorsArray[] = $supervisor;
			}
		}

		return $supervisorsArray;
	}

	public function createSupervisor($supervisor) {
		$dbContext = connect();
		if($supervisor != null) {
			$query = "INSERT INTO supervisor 
					  (first_name, last_name, email, phone, companyId) 
                      VALUES(?, ?, ?, ?, ?)";
            $statement = $dbContext->prepare($query);

            if($statement === false) {
				$error = "Error: Failed to prepare the SQL statement - " . htmlspecialchars($dbContext->error);
				return $error;
			}

			$result = $statement->bind_param('sssss', $supervisor->firstName, $supervisor->lastName,
													  $supervisor->email, $supervisor->phone,
													  $supervisor->companyId);
			if($result === false) {
				$error = "Error: Failed to bind params - " . htmlspecialchars($statement->error);
            	return $error;
			}

			$result = $statement->execute();

	        if($result == false) {
	            $error = "Error: " . htmlspecialchars($statement->error);
	            return $error;
	        }

	        $newSupervisorId =  $dbContext->insert_id;

	        return $newSupervisorId;
		} else {
			return false;
		}
	}

	/**
	* 
	*/
	public function getSupervisor($supervisorId) {
		$dbContext = connect();
		$supervisor = new Supervisor();
		$supervisor->supervisorId = $supervisorId;

		$query = "SELECT first_name, last_name, email, phone, companyId
		          FROM supervisor
				  WHERE supervisorId = ? 
				  LIMIT 1";
		$statement = $dbContext->prepare($query);
		if($statement === false) {
			echo "Failed to prepare the SQL statement: " . htmlspecialchars($dbContext->error);
			return false;
		}

		$result = $statement->bind_param('i', $supervisorId);
		if($result === false) {
			echo "Failed to bind params: " . htmlspecialchars($statement->error);
            return false;
		}

		$result = $statement->execute();
		if($result === false) {
			echo "Failed to execute: " . htmlspecialchars($statement->error);
            return false;
		}		

		$statement->bind_result($fname, $lname, $email, $phone, $companyId);
		while($statement->fetch()) {
			$supervisor->firstName = $fname;
			$supervisor->lastName = $lname;
			$supervisor->email = $email;
			$supervisor->phone = $phone;
			$supervisor->companyId = $companyId;
			$supervisor->company = Company::getCompany($companyId);
		}

		return $supervisor;
	}

	/**
	* 
	*/
	public function editSupervisor($supervisor) {
		$dbContext = connect();
		$supervisorId = $supervisor->supervisorId;
		$query = "UPDATE supervisor 
		          SET first_name = ?, last_name = ?, email = ?, phone = ?
				  WHERE supervisorId = ?";
		$statement = $dbContext->prepare($query);
		if($statement === false) {
			$error = "Error: Failed to prepare the SQL statement: " . htmlspecialchars($dbContext->error);
			return $error;
		}

		$result = $statement->bind_param('ssssi', $supervisor->firstName, $supervisor->lastName,
													$supervisor->email, $supervisor->phone,
													$supervisorId);
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
	* @summary This function will query agains the vw_getsupervisor database View to return all Supervisors.
	* This view enables us to also return the Company name that each Supervisor is attached to, instead of just
	*/
	public static function getAllSupervisors() {
		$dbContext = connect();
		$supervisorArray = array();

		$query = "SELECT supervisorId, first_name, last_name, email, phone, companyId
				  FROM supervisor
				  ORDER BY last_name";
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

		$statement->bind_result($supervisorId, $first_name, $last_name, $email, $phone, $companyId);
		while($statement->fetch()) {
			if($supervisorId != null) {
				$supervisor = new Supervisor();
				$supervisor->supervisorId = $supervisorId;
				$supervisor->firstName = $first_name;
				$supervisor->lastName = $last_name;
				$supervisor->email = $email;
				$supervisor->phone = $phone;
				$supervisor->companyId = $companyId;
				$supervisor->Company = Company::getCompany($companyId);

				//add supervisor object in iteration to $supervisors array
				$supervisorArray[] = $supervisor;
			}
		}

		return $supervisorArray;
	}

	/**
	* 
	*/
	public function buildSupervisorObject($data) {
		$supervisor = new Supervisor();
		//TODO: add any error checking I might need
		$supervisor->supervisorId = $data['supervisorId'];
		$supervisor->firstName = $data['txtSupervisorFName'];
		$supervisor->lastName = $data['txtSupervisorLName'];
		$supervisor->email = $data['txtSupervisorEmail'];
		$supervisor->phone = $data['txtSupervisorPhone'];
		$supervisor->companyId = $data['txtSupervisorCompanyId'];

		return $supervisor;
	}
}

?>