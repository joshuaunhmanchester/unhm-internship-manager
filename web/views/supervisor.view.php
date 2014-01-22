<?php
	
class SupervisorView {
	
	static function getHomepageSupervisorHtml() {
		//Build the Companies drop down list for the Supervisor Create form
		require_once('./classes/company.class.php');
		$companiesArray = array();
		$companiesArray = Company::getAllCompanies();
		$companiesDropDown = SupervisorView::getCompaniesDropdown($companiesArray);

		return <<<HTML
			<form method="post" id="supervisorSearchForm" action="./api/supervisor.api.php?action=search">
				<fieldset>
					<legend>Search Supervisors</legend>
					<input type="hidden" name="action" value="search" />
					<div class="form-wrapper">
						<div class="form-item-inline">
							<label for="supervisor-search-fname">First Name</label>
							<input type="text" id="supervisor-search-fname" name="txtSupervisorFName" />
						</div>
						<div class="form-item-inline">
							<label for="supervisor-search-lname">Last Name</label>
							<input type="text" id="supervisor-search-lname" name="txtSupervisorLName" />
						</div>
						<div class="form-item-inline">
							<label for="supervisor-search-email">Email</label>
							<input type="text" id="supervisor-search-email" name="txtSupervisorEmail" />
						</div>
						<input id="btnSupervisorSearch" class="button" type="submit" value="submit" />
					</div>
				</fieldset>
			</form>
			<div id="supervisor-search-results-wrapper" class="search-results-table-wrapper"></div>
			<div class="create-entity-wrapper">
				<form method="post" id="supervisorCreateForm" action="./api/supervisor.api.php?action=create">
				<fieldset>
					<legend>Create</legend>
					<div class="form-wrapper">
						<div class="form-item-inline">
							<label for="supervisor-create-fname"><span>*</span>First Name</label>
							<input type="text" id="supervisor-create-fname" name="txtSupervisorFName" />
						</div>
						<div class="form-item-inline">
							<label for="supervisor-create-lname"><span>*</span>Last Name</label>
							<input type="text" id="supervisor-create-lname" name="txtSupervisorLName" />
						</div>
						<div class="form-item-inline">
							<label for="supervisor-create-email"><span>*</span>Email</label>
							<input type="text" id="supervisor-create-email" name="txtSupervisorEmail" />
						</div>
						<div class="form-item-inline">
							<label for="supervisor-create-phone"><span>*</span>Contact Phone</label>
							<input type="text" id="supervisor-create-phone" name="txtSupervisorPhone" />
						</div>
						<div class="form-item-inline">
							<label for="supervisor-create-companyId"><span>*</span>Company</label>
							$companiesDropDown
							<!--<input type="text" id="supervisor-create-companyId" name="txtSupervisorCompanyId" />-->
						</div>
						<input id="btnCreateSupervisor" class="button" type="submit" value="Create" /> <br />
						<div class="alert-box" id="supervisorCreateAlert"></div>
					</div>
				</fieldset>
				</form>
			</div>			
HTML;
	}

	static function buildSupervisorSearchResults($supervisorsArray) {
		if(is_array($supervisorsArray)) {
			if(count($supervisorsArray) > 0) {
				foreach($supervisorsArray as $supervisor) {
					$rows .= '<tr data-studentrowid="'.$supervisor->supervisorId.'">
						<td><a href="supervisor/view.php?supervisorId='.$supervisor->supervisorId.'" class="viewSupervisorDetailModel" id="'.$supervisor->supervisorId.'">View</a></td>
						<td>' . $supervisor->firstName . '</td>
						<td>' . $supervisor->lastName . '</td>
						<td>' . $supervisor->email . '</td>
						<td>' . $supervisor->phone . '</td>
						<td>' . $supervisor->company->name . '</td>
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
							<th>Phone</th>
							<th>Company Name</th>
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

	static function buildSupervisorDetail($supervisor) {
		if(isset($supervisor)) {
			$html = 
			'<div id="root">
				<form method="post" id="supervisorEditForm" action="../api/supervisor.api.php?action=edit">
					<div class="item-wrapper">
						<fieldset>
							<legend>Supervisor Details | ID #'.$supervisor->supervisorId.'</legend>
							<input type="hidden" name="supervisorId" value="'.$supervisor->supervisorId.'" />
							<div class="form-item">
								<label for="supervisor-search-fname">First Name</label>
								<input type="text" id="supervisor-search-fname" name="txtSupervisorFName" value="'.$supervisor->firstName.'" />
							</div>
							<div class="form-item">
								<label for="supervisor-search-lname">Last Name</label>
								<input type="text" id="supervisor-search-lname" name="txtSupervisorLName" value="'.$supervisor->lastName.'" />
							</div>
							<div class="form-item">
								<label for="supervisor-search-email">Email</label>
								<input type="text" id="supervisor-search-email" name="txtSupervisorEmail" value="'.$supervisor->email.'" />
							</div>
							<div class="form-item">
								<label for="supervisor-search-grad">Phone</label>
								<input type="text" id="supervisor-search-phone" name="txtSupervisorPhone" value="'.$supervisor->phone.'" />
							</div>
							<div class="form-item">
								<label for="supervisor-search-company">Company Name</label>
								<input type="text" disabled="disable" id="supervisor-search-company" name="txtSupervisorCompanyId" value="'.$supervisor->company->name.'" />
							</div>
							<div class="alert-box error"></div>
							<input id="btnEditSupervisor" class="button" type="submit" value="submit" />
						</fieldset>
					</div>
				</form>
			</div>';

			echo $html;
		} else {
			echo "Sorry, could not load the Supervisor you requested. <br />";
		}
	}

	private static function getCompaniesDropdown($companiesArray) {
		$html = "<select name='txtSupervisorCompanyId'>";
		$html .= "<option value='0'>Select a Company</option>";
		foreach($companiesArray as $company) {
			$html .= "<option value={$company->companyId}>{$company->name}</option>";
		}
		$html .= "</select>";
		return $html;
	}
}
	
?>