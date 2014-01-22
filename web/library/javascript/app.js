$(function() {

	/* homepage search buttons */
	$('#btnStudentSearch').on('click', function(e) {
		e.preventDefault(); //don't submit the form
		var formData = $('#studentSearchForm').serialize();
		var link = './api/students.api.php?' + formData;
		
		$.post(link, function(data){
			$('#student-search-results-wrapper').html(data);
		});
	});

	$('#btnCompanySearch').on('click', function(e) {
		e.preventDefault(); //don't submit the form
		var companyNameQuery = $('#company-search-name').val();
		var link = './api/company.api.php?action=search&name=' + companyNameQuery;

		$.post(link, function(data) {
			$('#company-search-results-wrapper').html(data);
		});
	});

	$('#btnSupervisorSearch').on('click', function(e) {
		e.preventDefault(); //don't submit the form
		var formData = $('#supervisorSearchForm').serialize();
		var link = './api/supervisor.api.php?' + formData;
		
		$.post(link, function(data){
			$('#supervisor-search-results-wrapper').html(data);
		});
	});

	/* end homepage search buttons */

	/* View/edit buttons */

	$('#btnEditStudent').on('click', function(e) {
		e.preventDefault(); //don't submit the form
		var formData = $('#studentEditForm').serialize();
		var link = '../api/students.api.php?action=edit&' + formData;
		$.post(link, function(data) {
			if(data == 1) {
				window.location.href = '/internship';
			} else {
				//error
				$('.alert-box').show();
				$('.alter-box').html(data);
			}
		});
	});

	$('#btnEditCompany').on('click', function(e) {
		e.preventDefault(); //don't submit the form
		var formData = $('#companyEditForm').serialize();
		var link = '../api/company.api.php?action=edit&' + formData;
		$.post(link, function(data) {
			if(data == 1) {
				window.location.href = '/internship';
			} else {
				//error
				$('.alert-box').show();
				$('.alter-box').html(data);
			}
		});
	});

	$('#btnEditSupervisor').on('click', function(e) {
		e.preventDefault(); //don't submit the form
		var formData = $('#supervisorEditForm').serialize();
		var link = '../api/supervisor.api.php?action=edit&' + formData;
		$.post(link, function(data) {
			if(data == 1) {
				window.location.href = '/internship';
			} else {
				//error
				$('.alert-box').show();
				$('.alter-box').html(data);
			}
		});
	});

	/* end view/edit buttons */

	/* create buttons */
	$('#btnCreateStudent').on('click', function(e) {
		//TODO: check for validation
		e.preventDefault(); //don't submit the form
		var formData = $('#studentCreateForm').serialize();
		var link = './api/students.api.php?action=create&' + formData;
		$.post(link, function(data) {
			if(data.indexOf('Error') > -1) {
				//error
				$('#studentCreateAlert').show();
				$('#studentCreateAlert').removeClass('success');
				$('#studentCreateAlert').addClass('error');	
				$('#studentCreateAlert').html(data);
			} else {
				//success
				$('#studentCreateAlert').show();
				$(this).prop("disabled", true);
				$('#studentCreateAlert').removeClass('error');
				$('#studentCreateAlert').addClass('success');	
				$('#studentCreateAlert').html('New student successfully created!');
			}
		});
	});

	$('#btnCreateCompany').on('click', function(e) {
		//TODO: check for validation
		e.preventDefault(); //don't submit the form
		var formData = $('#companyCreateForm').serialize();
		var link = './api/company.api.php?action=create&' + formData;
		$.post(link, function(data) {
			if(data.indexOf('Error') > -1) {
				//error
				$('#companyCreateAlert').show();
				$('#companyCreateAlert').removeClass('success');
				$('#companyCreateAlert').addClass('error');	
				$('#companyCreateAlert').html(data);
			} else {
				//success
				$('#companyCreateAlert').show();
				$(this).prop("disabled", true);
				$('#companyCreateAlert').removeClass('error');
				$('#companyCreateAlert').addClass('success');	
				$('#companyCreateAlert').html('New company successfully created!');
			}
		});
	});

	$('#btnCreateSupervisor').on('click', function(e) {
		//TODO: check for validation
		e.preventDefault(); //don't submit the form
		var formData = $('#supervisorCreateForm').serialize();
		var link = './api/supervisor.api.php?action=create&' + formData;
		$.post(link, function(data) {
			if(data.indexOf('Error') > -1) {
				//error
				$('#supervisorCreateAlert').show();
				$('#supervisorCreateAlert').removeClass('success');
				$('#supervisorCreateAlert').addClass('error');	
				$('#supervisorCreateAlert').html(data);
			} else {
				//success
				$('#supervisorCreateAlert').show();
				$(this).prop("disabled", true);
				$('#supervisorCreateAlert').removeClass('error');
				$('#supervisorCreateAlert').addClass('success');	
				$('#supervisorCreateAlert').html('New Supervisor successfully created!');
			}
		});
	});
});