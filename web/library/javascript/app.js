$(function() {
	$('#btnStudentSearch').on('click', function(e) {
		e.preventDefault(); //don't submit the form
		var formData = $('#studentSearchForm').serialize();
		var link = './api/students.api.php?' + formData;
		
		$.post(link, function(data){
			$('#student-search-results-wrapper').html(data);
		});
	});

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
});