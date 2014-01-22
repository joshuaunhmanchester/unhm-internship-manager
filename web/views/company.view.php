<?php
	
class CompanyView {
	
	static function getHomepageCompanyHtml() {
		return <<<HTML
			<form method="post" id="companySearchForm" action="./api/company.api.php?action=search">
				<fieldset>
					<legend>Search Companies</legend>
					<input type="hidden" name="action" value="search" />
					<div class="form-wrapper">
						<div class="form-item-inline">
							<label for="company-search-name">Company Name</label>
							<input type="text" id="company-search-name" name="txtCompanyName" />
						</div>
						<input id="btnCompanySearch" class="button" type="submit" value="submit" />
					</div>
				</fieldset>
			</form>
			<div id="company-search-results-wrapper" class="search-results-table-wrapper"></div>
			<div class="create-entity-wrapper">
				<form method="post" id="companyCreateForm" action="./api/company.api.php?action=create">
				<fieldset>
					<legend>Create</legend>
					<div class="form-wrapper">
						<div class="form-item-inline">
							<label for="company-create-fname"><span>*</span>Name</label>
							<input type="text" id="company-create-name" name="txtCompanyName" />
						</div>
						<div class="form-item-inline">
							<label for="company-create-website"><span>*</span>Website Url</label>
							<input type="text" id="company-create-website" name="txtCompanyWebsite" />
						</div>
						<div class="form-item-inline">
							<label for="company-create-city"><span>*</span>City</label>
							<input type="text" id="company-create-city" name="txtCompanyCity" />
						</div>
						<div class="form-item-inline">
							<label for="company-create-state"><span>*</span>State</label>
							<input type="text" id="company-create-state" name="txtCompanyState" />
						</div>
						<input id="btnCreateCompany" class="button" type="submit" value="Create" /> <br />
						<div class="alert-box" id="companyCreateAlert"></div>
					</div>
				</fieldset>
				</form>
			</div>			
HTML;
	}

	static function buildCompanySearchResults($companyArray) {
		if(is_array($companyArray)) {
			if(count($companyArray) > 0) {
				foreach($companyArray as $company) {
					$rows .= '<tr data-companyrowid="'.$company->companyId.'">
						<td><a href="company/view.php?companyId='.$company->companyId.'" class="viewCompanyDetailModel" id="'.$company->companyId.'">View</a></td>
						<td>' . $company->name . '</td>
						<td><a href="http://'.$company->website.'" target="_blank" title="Go to '.$company->website.'">'.$company->website.'</a></td>
						<td>' . $company->city . '</td>
						<td>' . $company->state . '</td>
					</tr>';
				}

				$table = 
				'<table width="100%">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>Company Name</th>
							<th>Website Url</th>
							<th>City</th>
							<th>State</th>
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

	static function buildCompanyDetail($company) {
		if(isset($company)) {
			$html = 
			'<div id="root">
				<form method="post" id="companyEditForm" action="../api/company.api.php?action=edit">
					<div class="item-wrapper">
						<fieldset>
							<legend>Company Details | ID #'.$company->companyId.'</legend>
							<input type="hidden" name="companyId" value="'.$company->companyId.'" />
							<div class="form-item">
								<label for="company-search-name">Company Name</label>
								<input type="text" id="company-search-fname" name="txtCompanyName" value="'.$company->name.'" />
							</div>
							<div class="form-item">
								<label for="company-search-website">Company Website</label>
								<input type="text" id="company-search-website" name="txtCompanyUrl" value="'.$company->website.'" />
							</div>
							<div class="form-item">
								<label for="company-search-city">City</label>
								<input type="text" id="company-search-city" name="txtCompanyCity" value="'.$company->city.'" />
							</div>
							<div class="form-item">
								<label for="company-search-state">State</label>
								<input type="text" id="company-search-state" name="txtCompanyState" value="'.$company->state.'" />
							</div>
							<div class="alert-box error"></div>
							<input id="btnEditCompany" class="button" type="submit" value="submit" />
						</fieldset>
					</div>
				</form>
			</div>';

			echo $html;
		} else {
			echo "Sorry, could not load the Company you requested. <br />";
		}
	}
}
	
?>