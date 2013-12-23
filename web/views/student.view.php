<?php
	
class StudentView {
	
	static function getHomepageStudentHtml() {
		return <<<HTML
			<form method="post" id="studentSearchForm" action="./api/students.api.php?action=search">
				<fieldset>
					<legend>Search Students</legend>
					<input type="hidden" name="action" value="search" />
					<div class="form-wrapper">
						<div class="form-item-inline">
							<label for="student-search-fname">First Name</label>
							<input type="text" id="student-search-fname" name="txtStudentFName" />
						</div>
						<div class="form-item-inline">
							<label for="student-search-lname">Last Name</label>
							<input type="text" id="student-search-lname" name="txtStudentLName" />
						</div>
						<div class="form-item-inline">
							<label for="student-search-email">Email</label>
							<input type="text" id="student-search-email" name="txtStudentEmail" />
						</div>
						<input id="btnStudentSearch" class="button" type="submit" value="submit" />
					</div>
				</fieldset>
			</form>
			<div id="student-search-results-wrapper" class="search-results-table-wrapper"></div>
						
HTML;
	}

	static function buildStudentSearchResults($studentsArray) {
		if(is_array($studentsArray)) {
			if(count($studentsArray) > 0) {
				foreach($studentsArray as $student) {
					$rows .= '<tr data-studentrowid="'.$student->studentId.'">
						<td><a href="student/view.php?studentId='.$student->studentId.'" class="viewStudentDetailModel" id="'.$student->studentId.'">View</a></td>
						<td>' . $student->firstName . '</td>
						<td>' . $student->lastName . '</td>
						<td>' . $student->email . '</td>
						<td>' . $student->gradYear . '</td>
						<td>' . $student->advisor . '</td>
					</tr>';
				}

				$table = 
				'<table width="100%">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email</th>
							<th>Graduation Year</th>
							<th>Advisor Name</th>
						</tr>
					</thead>
					<tbody>' . $rows . '</tbody>
				</table>';

				echo $table;	
			} else {
				echo "There were no results";
			}
		} else {
			echo "There was an error processing this request.";
		}
	}

	static function buildStudentDetail($student) {
		if(isset($student)) {
			$html = 
			'<div id="root">
				<form method="post" id="studentEditForm" action="../api/students.api.php?action=edit">
					<div class="item-wrapper">
						<fieldset>
							<legend>Student Details | ID #'.$student->studentId.'</legend>
							<input type="hidden" name="studentId" value="'.$student->studentId.'" />
							<div class="form-item">
								<label for="student-search-fname">First Name</label>
								<input type="text" id="student-search-fname" name="txtStudentFName" value="'.$student->firstName.'" />
							</div>
							<div class="form-item">
								<label for="student-search-lname">Last Name</label>
								<input type="text" id="student-search-lname" name="txtStudentLName" value="'.$student->lastName.'" />
							</div>
							<div class="form-item">
								<label for="student-search-email">Email</label>
								<input type="text" id="student-search-email" name="txtStudentEmail" value="'.$student->email.'" />
							</div>
							<div class="form-item">
								<label for="student-search-grad">Graduation Year</label>
								<input type="text" id="student-search-grad" name="txtStudentGradYear" value="'.$student->gradYear.'" />
							</div>
							<div class="form-item">
								<label for="student-search-adv">Department Advisor</label>
								<input type="text" id="student-search-adv" name="txtStudentAdvisor" value="'.$student->advisor.'" />
							</div>
							<div class="form-item">
								<label for="student-search-notes">Student Notes</label>
								<textarea id="student-search-notes" name="txtStudentNotes" rows="10" cols="65">'.$student->notes.'</textarea>
							</div>
							<div class="alert-box error"></div>
							<input id="btnEditStudent" class="button" type="submit" value="submit" />
						</fieldset>
					</div>
				</form>
			</div>';

			echo $html;
		} else {
			echo "Sorry, could not load the Student you requested. <br />";
		}
	}
}
	
?>