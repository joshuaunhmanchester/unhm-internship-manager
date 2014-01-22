<?php
	
class PositionView {
	public $studentsArray = array();
	public $companyArray = array();
	public $supervisorsArray = array();

	static function getCreatePositionHtml() {
		$studentsArray = Student::getAllStudents();
		$companiesArray = Company::getAllCompanies();
		$supervisorArray = Supervisor::getAllSupervisors();
		$studentsDropDown = PositionView::getStudentsDropdown($studentsArray);
		$companiesDropDown = PositionView::getCompaniesDropdown($companiesArray);
		$supervisorsDropDown = PositionView::getSupervisorDropdown($supervisorArray);

		$html = 
		'<div id="root">
			<script src="../library/javascript/create-position.js" type="text/javascript"></script>
			<form method="post" id="positionCreateForm" action="../api/position.api.php?action=create">
				<div class="item-wrapper">
					<input type="hidden" id="studentId" value="" />
					<input type="hidden" id="companyId" value="" />
					<input type="hidden" id="supervisorId" value="" />
					<fieldset>
						<legend>Create new Internship Position</legend>
						<div id="st-accordion" class="st-accordion">
							<ul>
								<li id="studentListItem">
									<a href="#">
										1. Student <span class="st-arrow">Open or Close</span>
									</a>
									<div class="st-content">
										<div class="create-options-wrapper">
											<input type="radio" id="exisitingStudent" name="chooseStudent" value="existing" />
											<label for="exisitingStudent">Choose existing Student</label>
										</div>
										<div class="create-options-wrapper">
											<input type="radio" id="createStudent" name="chooseStudent" value="new" />
											<label for="createStudent">Create new Student</label>
										</div>
										<div class="select-existing-wrapper" id="student-select">
											' . $studentsDropDown . '
										</div>
										<div class="create-new-wrapper" id="student-create">
											<div class="form-item">
												<label for="student-create-fname"><span>*</span>First Name</label>
												<input type="text" id="student-create-fname" name="txtStudentFName" />
											</div>
											<div class="form-item">
												<label for="student-create-lname"><span>*</span>Last Name</label>
												<input type="text" id="student-create-lname" name="txtStudentLName" />
											</div>
											<div class="form-item">
												<label for="student-create-email"><span>*</span>Email</label>
												<input type="text" id="student-create-email" name="txtStudentEmail" />
											</div>
											<div class="form-item">
												<label for="student-create-gradYear"><span>*</span>Graduation Year</label>
												<input type="text" id="student-create-gradYear" name="txtStudentGradYear" />
											</div>
											<div class="form-item">
												<label for="student-create-advisor"><span>*</span>Advisor</label>
												<input type="text" id="student-create-advisor" name="txtStudentAdvisor" />
											</div>
											<input id="btnCreateStudentNextStep" class="button" type="submit" value="Create" /> <br />
											<div class="alert-box" id="studentCreateAlert"></div>
										</div>
									</div>
								</li>
								<li id="companyListItem" class="hiddenAtStart">
									<a href="#">
										2. Company <span class="st-arrow">Open or Close</span>
									</a>
									<div class="st-content">
										<div class="create-options-wrapper">
											<input type="radio" id="exisitingCompany" name="chooseCompany" value="existing" />
											<label for="exisitingCompany">Choose existing Company</label>
										</div>
										<div class="create-options-wrapper">
											<input type="radio" id="createCompany" name="chooseCompany" value="new" />
											<label for="createCompany">Create new Company</label>
										</div>
										<div class="select-existing-wrapper" id="company-select">
											' . $companiesDropDown . '
										</div>
										<div class="create-new-wrapper" id="company-create">
											<div class="form-item">
												<label for="company-create-name"><span>*</span>Company Name</label>
												<input type="text" id="company-create-name" name="txtCompanyName" />
											</div>
											<div class="form-item">
												<label for="company-create-website"><span>*</span>Company Website</label>
												<input type="text" id="company-create-website" name="txtCompanyWebsite" />
											</div>
											<div class="form-item">
												<label for="company-create-city"><span>*</span>City</label>
												<input type="text" id="company-create-city" name="txtCompanyCity" />
											</div>
											<div class="form-item">
												<label for="company-create-state"><span>*</span>State</label>
												<input type="text" id="company-create-state" name="txtCompanyState" />
											</div>
											<input id="btnCreateCompanyNextStep" class="button" type="submit" value="Create" /> <br />
											<div class="alert-box" id="companyCreateAlert"></div>
										</div>
									</div>
								</li>
								<li id="supervisorListItem" class="hiddenAtStart">
									<a href="#">
										3. Supervisor <span class="st-arrow">Open or Close</span>
									</a>
									<div class="st-content">
										<div class="create-options-wrapper">
											<input type="radio" id="exisitingSupervisor" name="chooseSupervisor" value="existing" />
											<label for="exisitingSupervisor">Choose existing Supervisor</label>
										</div>
										<div class="create-options-wrapper">
											<input type="radio" id="createSupervisor" name="chooseSupervisor" value="new" />
											<label for="createSupervisor">Create new Supervisor</label>
										</div>
										<div class="select-existing-wrapper" id="supervisor-select">
											' . $supervisorsDropDown . '
										</div>
										<div class="create-new-wrapper" id="supervisor-create">
											<div class="note red small">
												NOTE: This new supervisor will be linked to the selected Company above: 
												<span id="txtCurrentSelectedCompanyName"></span>
											</div>
											<div class="form-item">
												<label for="supervisor-create-fname"><span>*</span>First Name</label>
												<input type="text" id="supervisor-create-fname" name="txtSupervisorFName" />
											</div>
											<div class="form-item">
												<label for="supervisor-create-lname"><span>*</span>Last Name</label>
												<input type="text" id="supervisor-create-lname" name="txtSupervisorLName" />
											</div>
											<div class="form-item">
												<label for="supervisor-create-email"><span>*</span>Email</label>
												<input type="text" id="supervisor-create-email" name="txtSupervisorEmail" />
											</div>
											<div class="form-item">
												<label for="supervisor-create-phone"><span>*</span>Contact Phone</label>
												<input type="text" id="supervisor-create-phone" name="txtSupervisorPhone" />
											</div>
											<input type="hidden" name="txtSupervisorCompanyId" id="txtSupervisorCompanyId" value="" />
											<input id="btnCreateSupervisorNextStep" class="button" type="submit" value="Create" /> <br />
											<div class="alert-box" id="supervisorCreateAlert"></div>
										</div>
									</div>
								</li>
								<li id="positionListItem" class="hiddenAtStart">
									<a href="#">
										4. Position <span class="st-arrow">Open or Close</span>
									</a>
									<div class="st-content">
										<p>Please fill in the remaining items to complete the new Position process</p>
										<div class="create-new-wrapper" id="position-create">
											<div class="form-item">
												<label for="position-create-title"><span>*</span>Position Title</label>
												<input type="text" id="position-create-title" name="txtPositionTitle" />
											</div>
											<div class="form-item">
												<label for="position-create-term"><span>*</span>Term</label>
												<input type="text" id="position-create-term" name="txtPositionTerm" />
											</div>
											<div class="form-item inline">
												<label for="position-create-year"><span>*</span>Year</label>
												<input type="text" id="position-create-year" name="txtPositionYear" />
											</div>
											<div class="form-item inline">
												<label for="position-create-paid"><span>*</span>Check if this is paid</label>
												<input type="checkbox" id="position-create-paid" name="txtPositionIsPaid" />
											</div>
											<div class="form-item inline">
												<label for="position-create-hours"><span>*</span>How many hours per week?</label>
												<input type="text" id="position-create-hours" name="txtPositionHours" />
											</div>
										</div>
										<input id="btnCreatePosition" class="button" type="submit" value="submit" />
									</div>
								</li>
							</ul>
						</div>
						
					</fieldset>
				</div>
			</form>
			<script type="text/javascript">
	            $(function() {
					$("#st-accordion").accordion();
	            });
	        </script>
		</div>';

		echo $html;
	}

	private static function getStudentsDropdown($studentsArray) {
		$html = "<select name='existingStudentId'>";
		$html .= "<option value='0'>Select a Student</option>";
		foreach($studentsArray as $student) {
			$html .= "<option value={$student->studentId}>{$student->firstName}</option>";
		}
		$html .= "</select>";
		return $html;
	}

	private static function getCompaniesDropdown($companiesArray) {
		$html = "<select name='existingCompanyId'>";
		$html .= "<option value='0'>Select a Company</option>";
		foreach($companiesArray as $company) {
			$html .= "<option value={$company->companyId}>{$company->name}</option>";
		}
		$html .= "</select>";
		return $html;
	}

	private static function getSupervisorDropdown($supervisorArray) {
		$html = "<select name='existingSupervisorId'>";
		$html .= "<option value='0'>Select a Supervisor</option>";
		foreach($supervisorArray as $supervisor) {
			$displayName = $supervisor->DisplayName();
			$html .= "<option value={$supervisor->supervisorId}>{$displayName}</option>";
		}
		$html .= "</select>";
		return $html;
	}
}
	
?>