<?php
/**
* @author Joshua Anderson
* Date: 12/17/13
* Description: Class for a Student
*
*/

require('../library/common/config.php');
require('bindparam.class.php');

class Student {
	public $studentId;
	public $firstName;
	public $lastName;
	public $email;
	public $gradYear;
	public $advisor;
	public $notes;

	/**
	* Summary: This method will query the student database table to collect records of students
	* and create a Student Object array to pass back to the controller
	* @param: $filters = the $_POST array from the homepage student search form contains three $_POST values for the first and last name, and email
	* @return: This will return a view from the StudentView class which will produce a HTML table with the results when we pass it 
	* an array of Student objects
	*/
	public function getStudentsFromSearch($filters) {
		$studentsArray = array();
		$whereClause = array();
		$bindParam = new BindParam();
		$dbContext = connect();
		$fname;
		$lname;
		$email;

		if(isset($filters['txtStudentFName'])) {
			$fname = strtolower($filters['txtStudentFName']);
			if($fname) { 
				$whereClause[] = "LOWER(first_name) LIKE ? "; 
				$bindParam->add('s', '%'.$fname.'%');
			}
		}
		if(isset($filters['txtStudentLName'])) {
			$lname = strtolower($filters['txtStudentLName']);
			if($lname) { 
				$whereClause[] = "LOWER(last_name) LIKE ? "; 
				$bindParam->add('s', '%'.$lname.'%');
			}
		}
		if(isset($filters['txtStudentEmail'])) {
			$email = strtolower($filters['txtStudentEmail']);
			if($email) { 
				$whereClause[] = "LOWER(email) LIKE ? "; 
				$bindParam->add('s', '%'.$email.'%');
			}
		}

		if(is_null($fname) && is_null($lname) && is_null($email)) {
			echo "Please make sure you supply either a First Name, Last Name or Email to search";
			return false;
		}

		$query = "SELECT studentId, first_name, last_name, email, grad_year, advisor, notes FROM
				  student ";
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

		$statement->bind_result($studentId, $first_name, $last_name, $email, $grad_year, $advisor, $notes);
		while($statement->fetch()) {
			if($studentId != null) {
				$student = new Student();
				$student->studentId = $studentId;
				$student->firstName = $first_name;
				$student->lastName = $last_name;
				$student->email = $email;
				$student->gradYear = $grad_year;
				$student->advisor = $advisor;
				$student->notes = $notes;

				//add student object in iteration to $students array
				$studentsArray[] = $student;
			}
		}

		return $studentsArray;
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