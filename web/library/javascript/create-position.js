$(function() {
	/*
	* @author Joshua Anderson
	* @date: 1/6/14
	* Below will handle any JS for the Create Position form
	**/

	//TODO: hide all the other steps div wrappers until the previous steps are successfully completed

	/**
	* @summary Below will include the actions for the Student, Company, and Supervisor
	* sections. After a selection or new addition has been made, the selected value
	* will be set on the accompanying hidden input at the top of the form
	* #studentId
	* #companyId
	* #supervisorId
	*/

	/*
	* STUDENTS
	*/
	$('input[name=chooseStudent]').on('change', function(e) {
		var value = $(this).val();
		if(value === 'new') {
			$('#student-select').hide();
			$('#student-create').show();
		} else {
			$('#student-select').show();
			$('#student-create').hide();
		}
	});

	$('#student-select').on('change', function(e) {
		var studentId = $(this).find("option:selected").val();
		$('#studentId').val(studentId);

		//show the next step
		$('#companyListItem').show();
	});

	$('#btnCreateStudentNextStep').on('click', function(e) {
		//TODO: check for validation
		e.preventDefault(); //don't submit the form
		var formData = $('#positionCreateForm').serialize();
		var link = '../api/students.api.php?action=create&' + formData;
		$.post(link, function(data) { //data will contain the new student ID or an error
			if(data.indexOf('Error') > -1) {
				//error - show the error notification
				$('#studentCreateAlert').show();
				$('#studentCreateAlert').removeClass('success');
				$('#studentCreateAlert').addClass('error');	
				$('#studentCreateAlert').html(data);
			} else {
				//success - show the sucess notification
				$('#studentCreateAlert').show();
				$(this).prop("disabled", true);
				$('#studentCreateAlert').removeClass('error');
				$('#studentCreateAlert').addClass('success');	
				$('#studentCreateAlert').html('New student successfully created!');

				//set the value of the hidden input
				$('#studentId').val(data);

				//show the next step
				$('#companyListItem').show();
			}
		});
	});

	/*
	* COMPANIES
	*/
	$('input[name=chooseCompany]').on('change', function(e) {
		var value = $(this).val();
		if(value === 'new') {
			$('#company-select').hide();
			$('#company-create').show();
		} else {
			$('#company-select').show();
			$('#company-create').hide();
		}
	});

	$('#company-select').on('change', function(e) {
		var companyId = $(this).find("option:selected").val();
		var companyName = $(this).find("option:selected").text();
		$('#txtCurrentSelectedCompanyName').html(companyName);
		$('#txtSupervisorCompanyId').val(companyId);
		$('#companyId').val(companyId);
		
		//show the next step
		$('#supervisorListItem').show();
	});

	$('#btnCreateCompanyNextStep').on('click', function(e) {
		//TODO: check for validation
		e.preventDefault(); //don't submit the form
		var formData = $('#positionCreateForm').serialize();
		var link = '../api/company.api.php?action=create&' + formData;
		$.post(link, function(data) { //data will contain the new student ID or an error
			if(data.indexOf('Error') > -1) {
				//error - show the error notification
				$('#companyCreateAlert').show();
				$('#companyCreateAlert').removeClass('success');
				$('#companyCreateAlert').addClass('error');	
				$('#companyCreateAlert').html(data);
			} else {
				//success - show the sucess notification
				$('#companyCreateAlert').show();
				$(this).prop("disabled", true);
				$('#companyCreateAlert').removeClass('error');
				$('#companyCreateAlert').addClass('success');	
				$('#companyCreateAlert').html('New company successfully created!');

				//set the value of the hidden input
				$('#txtSupervisorCompanyId').val(companyId);
				$('#companyId').val(data);

				//show the next step
				$('#supervisorListItem').show();
			}
		});
	});

	/*
	* SUPERVISORS
	*/
	$('input[name=chooseSupervisor]').on('change', function(e) {
		var value = $(this).val();
		if(value === 'new') {
			$('#supervisor-select').hide();
			$('#supervisor-create').show();
		} else {
			$('#supervisor-select').show();
			$('#supervisor-create').hide();
		}
	});

	$('#supervisor-select').on('change', function(e) {
		var companyId = $(this).find("option:selected").val();
		$('#supervisorId').val(companyId);
		
		//show the next step
		$('#positionListItem').show();
		$('#position-create').show();
	});

	$('#btnCreateSupervisorNextStep').on('click', function(e) {
		//TODO: check for validation
		e.preventDefault(); //don't submit the form
		var formData = $('#positionCreateForm').serialize();
		var link = '../api/supervisor.api.php?action=create&' + formData;
		$.post(link, function(data) { //data will contain the new student ID or an error
			if(data.indexOf('Error') > -1) {
				//error - show the error notification
				$('#supervisorCreateAlert').show();
				$('#supervisorCreateAlert').removeClass('success');
				$('#supervisorCreateAlert').addClass('error');	
				$('#supervisorCreateAlert').html(data);
			} else {
				//success - show the sucess notification
				$('#supervisorCreateAlert').show();
				$(this).prop("disabled", true);
				$('#supervisorCreateAlert').removeClass('error');
				$('#supervisorCreateAlert').addClass('success');	
				$('#supervisorCreateAlert').html('New Supervisor successfully created!');

				//set the value of the hidden input
				$('#supervisorId').val(data);

				//show the next step
				$('#positionListItem').show();
				$('#position-create').show();
			}
		});
	});

});