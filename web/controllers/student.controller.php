<?php
ob_start(); 
//Turn on output buffering.  While output buffering is active no output is sent 
//from the script (other than headers), instead the output is stored in an internal buffer.

include('../classes/student.class.php');


class StudentController {
	
	/**
	* Summary: This will create a new Student object and call a method to search the student table
	* @param: $filters = the $_POST array from the homepage student search form
	* @return: This will return a view from the StudentView class which will produce a HTML table with the results when we pass it 
	* an array of Student objects
	*/
	public function searchStudents($filters) {
		include_once('../views/student.view.php');
		$student = new Student();
		$studentArray = array();

		$studentsArray = $student->getStudentsFromSearch($filters);

		StudentView::buildStudentSearchResults($studentsArray);
	}

	public function getStudent($studentId) {
		include_once('../views/student.view.php');

		if(isset($studentId)) {
			$student = new Student();
			$student = $student->getStudent($studentId);
			StudentView::buildStudentDetail($student);
		} else {
			return false;
		}
	}

	public function editStudent($data) {
		$student = new Student();
		$student = $student->buildStudentObject($data);
		$results = $student->editStudent($student);
		if($results === 1) {
			header('Location: /internship');
		} else {

		}
		echo $results;
	}
	
}	
	
?>

