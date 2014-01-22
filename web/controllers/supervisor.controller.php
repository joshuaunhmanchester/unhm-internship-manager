<?php
ob_start(); 
//Turn on output buffering.  While output buffering is active no output is sent 
//from the script (other than headers), instead the output is stored in an internal buffer.

include_once('../classes/supervisor.class.php');


class SupervisorController {
	
	/**
	* Summary: This will create a new Supervisor object and call a method to search the student table
	* @param: $filters = the $_POST array from the homepage student search form
	* @return: This will return a view from the StudentView class which will produce a HTML table with the results when we pass it 
	* an array of Supervisor objects
	*/
	public function searchSupervisors($filters) {
		include_once('../views/supervisor.view.php');
		$supervisor = new Supervisor();
		$supervisorsArray = array();

		$supervisorsArray = $supervisor->getSupervisorsFromSearch($filters);

		SupervisorView::buildSupervisorSearchResults($supervisorsArray);
	}

	public function addSupervisor($data) {
		$supervisor = new Supervisor();
		$supervisor = $supervisor->buildSupervisorObject($data);
		$newSupervisorId = $supervisor->createSupervisor($supervisor);

		echo $newSupervisorId;
	}

	public function getSupervisor($supervisorId) {
		include_once('../views/supervisor.view.php');

		if(isset($supervisorId)) {
			$supervisor = new Supervisor();
			$supervisor = $supervisor->getSupervisor($supervisorId);
			SupervisorView::buildSupervisorDetail($supervisor);
		} else {
			return false;
		}
	}

	public function editSupervisor($data) {
		$supervisor = new Supervisor();
		$supervisor = $supervisor->buildSupervisorObject($data);
		$results = $supervisor->editSupervisor($supervisor);
		
		echo $results;
	}
	
}	
	
?>

